<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Voucher;
use Livewire\Component;
use App\Mail\ReviewRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;

class RoomReservation extends Component
{
    public $room;
    public $guest_name;
    public $discount;
    public $voucherId;
    public $guest_email;
    public $check_in;
    public $check_out;
    public $guests_number = 1;
    public $total_price = 0;
    public $unavailableDates = [];
    public $guests = [
        'adults' => 1,
        'teenagers' => 0,
        'children' => 0,
        'infants' => 0,
        'seniors' => 0
    ];
    public $voucher_code;
    public $applied_voucher = null;
    public $original_price = 0;
    public $discount_amount = 0;

    protected $rules = [
        'guest_name' => 'required|string|max:255',
        'guest_email' => 'required|email:rfc,dns',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
        'voucher_code' => 'nullable|string|exists:vouchers,code',
    ];

    public function mount(Room $room)
    {
        $this->room = $room;
        $this->guests_number = 1;
        $this->check_in = request()->query('check_in');
        $this->check_out = request()->query('check_out');
        $this->loadUnavailableDates();
        $this->calculateTotalPrice();
    }

    public function addGuest($type)
    {
        $totalGuests = array_sum($this->guests);
        if ($totalGuests < $this->room->capacity) {
            $this->guests[$type]++;
            $this->guests_number = $totalGuests + 1;
            $this->calculateTotalPrice();
        }
    }

    public function removeGuest($type)
    {
        if ($this->guests[$type] > 0) {
            $this->guests[$type]--;
            $this->guests_number = array_sum($this->guests);
            $this->calculateTotalPrice();
        }
    }

    public function updatedGuests()
    {
        $this->calculateTotalPrice();
    }

    public function applyVoucher()
    {
        if (empty($this->voucher_code)) {
            session()->flash('voucher_error', __('messages.enter_voucher_code'));
            return;
        }

        $voucher = Voucher::where('code', $this->voucher_code)
            ->where(function ($query) {
                $query->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('usage_limit')
                    ->orWhere('usage_limit', '>', 0);
            })
            ->first();

        if (!$voucher) {
            session()->flash('voucher_error', __('messages.invalid_voucher'));
            $this->applied_voucher = null;
            $this->calculateTotalPrice();
            return;
        }

        // Sprawdź minimalna wartość zamówienia
        if ($voucher->minimum_order_value && $this->original_price < $voucher->minimum_order_value) {
            session()->flash('voucher_error', __('messages.minimum_order_value_not_met', ['amount' => $voucher->minimum_order_value]));
            return;
        }

        $this->applied_voucher = $voucher;
        $this->calculateTotalPrice();
        session()->flash('voucher_success', __('messages.voucher_applied'));
    }

    public function loadUnavailableDates()
    {
        // Pobierz wszystkie zajęte terminy
        $reservations = $this->room->reservations()
            ->where('check_out', '>=', now())
            ->get();

        foreach ($reservations as $reservation) {
            $period = Carbon::parse($reservation->check_in)->daysUntil($reservation->check_out);
            foreach ($period as $date) {
                $this->unavailableDates[] = $date->format('Y-m-d');
            }
        }
    }

    public function updatedCheckIn($value)
    {
        $this->calculateTotalPrice();
    }

    public function updatedCheckOut($value)
    {
        $this->calculateTotalPrice();
    }

    public function updatedGuestsNumber($value)
    {
        if (empty($value)) {
            $this->guests_number = 1;
        }

        $this->guests_number = max(1, min(intval($value), $this->room->capacity));

        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice()
    {
        if ($this->check_in && $this->check_out) {
            $checkIn = Carbon::parse($this->check_in);
            $checkOut = Carbon::parse($this->check_out);
            $nights = $checkIn->diffInDays($checkOut);

            $basePrice = $this->room->price_per_person;
            $total = 0;

            $total += $this->guests['adults'] * $basePrice;
            $total += $this->guests['teenagers'] * $basePrice * 0.8; // 20%
            $total += $this->guests['children'] * $basePrice * 0.5; // 50% 
            $total += $this->guests['seniors'] * $basePrice * 0.65; // 35% 

            $this->original_price = $total * max(1, $nights);

            // Zastosuj voucher jeśli istnieje
            $this->discount_amount = 0;
            if ($this->applied_voucher) {
                if ($this->applied_voucher->discount_type === 'percentage') {
                    $this->discount_amount = $this->original_price * ($this->applied_voucher->discount_value / 100);
                    if ($this->applied_voucher->maximum_discount) {
                        $this->discount_amount = min($this->discount_amount, $this->applied_voucher->maximum_discount);
                    }
                } else {
                    $this->discount_amount = min($this->applied_voucher->discount_value, $this->original_price);
                }
            }

            // Oblicz końcową cenę
            $this->total_price = max(0, $this->original_price - $this->discount_amount);
        }
    }


    public function reserve()
    {
        $this->validate();

        if (!$this->room->isAvailable($this->check_in, $this->check_out)) {
            session()->flash('error', __('messages.room_not_available'));
            return;
        }
        if ($this->guests['adults'] === 0 && $this->guests['seniors'] === 0) {
            session()->flash('error', __('messages.at_least_one_adult_required'));
            return;
        }

        if ($this->applied_voucher) {
            $this->applyVoucher(); // Ponowna walidacja vouchera
            if (session()->has('voucher_error')) {
                return;
            }
        }

        $cancellationCode = mt_rand(10000, 99999);
        $totalGuests = collect($this->guests)->sum();

        $reservation = $this->room->reservations()->create([
            'guest_name' => $this->guest_name,
            'guest_email' => $this->guest_email,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'guests' => $this->guests,
            'guests_number' => $totalGuests,
            'total_price' => $this->total_price,
            'cancellation_code' => $cancellationCode,
        ]);

        // Mail::to($reservation->guest_email)->send(new ReservationConfirmation($reservation));
        // Mail::to($reservation->guest_email)->send(new ReviewRequest($reservation));

        return redirect()->route('reservation.confirmation', $reservation->id)
            ->with('success', __('messages.reservation_completed'));
        if ($this->applied_voucher && $this->applied_voucher->usage_limit) {
            $this->applied_voucher->usage_limit--;
            $this->applied_voucher->save();
        }
    }

    public function render()
    {
        return view('livewire.room-reservation');
    }
}

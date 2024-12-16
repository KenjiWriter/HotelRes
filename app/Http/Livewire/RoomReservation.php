<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;
use App\Mail\ReviewRequest;

class RoomReservation extends Component
{
    public $room;
    public $guest_name;
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

    protected $rules = [
        'guest_name' => 'required|string|max:255',
        'guest_email' => 'required|email:rfc,dns',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
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

            $this->total_price = $total * max(1, $nights);
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
    }

    public function render()
    {
        return view('livewire.room-reservation');
    }
}

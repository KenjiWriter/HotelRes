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

    protected $rules = [
        'guest_name' => 'required|string|max:255',
        'guest_email' => 'required|email:rfc,dns',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
        'guests_number' => 'required|integer|min:1',
    ];

    public function mount(Room $room)
    {
        $this->room = $room;
        $this->guests_number = 1;
        $this->loadUnavailableDates();
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
        $guests = intval($this->guests_number ?: 1);

        $pricePerPerson = floatval($this->room->price_per_person);

        if ($this->check_in && $this->check_out) {
            $checkIn = Carbon::parse($this->check_in);
            $checkOut = Carbon::parse($this->check_out);
            $nights = $checkIn->diffInDays($checkOut);

            $this->total_price = $pricePerPerson * $guests * max(1, $nights);
        } else {
            $this->total_price = $pricePerPerson * $guests;
        }
    }

    public function reserve()
    {
        $this->validate();

        if (!$this->room->isAvailable($this->check_in, $this->check_out)) {
            session()->flash('error', 'Pokój nie jest dostępny w wybranym terminie.');
            return;
        }

        $cancellationCode = mt_rand(10000, 99999);

        $reservation = $this->room->reservations()->create([
            'guest_name' => $this->guest_name,
            'guest_email' => $this->guest_email,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'guests_number' => $this->guests_number,
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

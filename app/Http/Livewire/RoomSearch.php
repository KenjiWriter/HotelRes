<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Room;
use Carbon\Carbon;

class RoomSearch extends Component
{
    public $checkIn;
    public $checkOut;
    public $guests = 1;
    public $priceMin;
    public $priceMax;
    public $amenities = [];
    public $availableRoomsCount;
    public $errorMessage;

    public function mount()
    {
        $this->checkIn = Carbon::tomorrow()->format('Y-m-d');
        $this->checkOut = Carbon::tomorrow()->addDay()->format('Y-m-d');
        $this->updateAvailableRoomsCount();
    }

    public function updated()
    {
        if ($this->checkIn && $this->checkOut && Carbon::parse($this->checkIn)->gt(Carbon::parse($this->checkOut))) {
            $this->errorMessage = __('messages.invalid_date_range');
            $this->swapDates();
        } elseif ($this->priceMin && $this->priceMax && $this->priceMin > $this->priceMax) {
            $this->errorMessage = __('messages.invalid_price_range');
            $this->swapPrices();
        } else {
            $this->errorMessage = null;
        }

        $this->updateAvailableRoomsCount();
    }

    private function swapDates()
    {
        [$this->checkIn, $this->checkOut] = [$this->checkOut, $this->checkIn];
    }

    private function swapPrices()
    {
        [$this->priceMin, $this->priceMax] = [$this->priceMax, $this->priceMin];
    }

    public function updateAvailableRoomsCount()
    {
        $query = Room::query();

        // Filter by guests
        $query->where('capacity', '>=', $this->guests);

        // Filter by price
        if ($this->priceMin) {
            $query->where('price_per_person', '>=', $this->priceMin);
        }
        if ($this->priceMax) {
            $query->where('price_per_person', '<=', $this->priceMax);
        }

        // Filter by amenities
        if (!empty($this->amenities)) {
            foreach ($this->amenities as $amenityId) {
                $query->whereHas('amenities', function ($q) use ($amenityId) {
                    $q->where('amenities.id', $amenityId);
                });
            }
        }

        // Check availability
        $checkIn = Carbon::parse($this->checkIn);
        $checkOut = Carbon::parse($this->checkOut);

        $query->whereDoesntHave('reservations', function ($q) use ($checkIn, $checkOut) {
            $q->where(function ($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in', [$checkIn, $checkOut])
                  ->orWhereBetween('check_out', [$checkIn, $checkOut])
                  ->orWhere(function ($q) use ($checkIn, $checkOut) {
                      $q->where('check_in', '<=', $checkIn)
                        ->where('check_out', '>=', $checkOut);
                  });
            });
        });

        // Count available rooms
        $this->availableRoomsCount = $query->count();
    }

    public function search()
    {
        return redirect()->route('search.results', [
            'check_in' => $this->checkIn,
            'check_out' => $this->checkOut,
            'guests' => $this->guests,
            'price_min' => $this->priceMin,
            'price_max' => $this->priceMax,
            'amenities' => implode(',', $this->amenities),
        ]);
    }

    public function render()
    {
        return view('livewire.room-search');
    }
}
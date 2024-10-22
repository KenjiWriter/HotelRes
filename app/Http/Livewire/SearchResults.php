<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Room;

class SearchResults extends Component
{
    public $rooms;
    public $sortOrder = 'default';
    public $checkIn;
    public $checkOut;

    public function mount($rooms, $checkIn, $checkOut)
    {
        $this->rooms = $rooms;
        $this->checkIn = $checkIn;
        $this->checkOut = $checkOut;
    }

    public function updatedSortOrder()
    {
        if ($this->sortOrder === 'asc') {
            $this->rooms = Room::orderBy('price_per_person', 'asc')->get();
        } elseif ($this->sortOrder === 'desc') {
            $this->rooms = Room::orderBy('price_per_person', 'desc')->get();
        } else {
            $this->rooms = Room::all();
        }
    }

    public function render()
    {
        return view('livewire.search-results');
    }
}

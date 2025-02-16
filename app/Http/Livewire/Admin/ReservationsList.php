<?php

namespace App\Http\Livewire\Admin;

use App\Models\Reservation;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class ReservationsList extends Component
{
    use WithPagination;

    public $search = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $status = '';
    public $showAdvancedFilters = false;
    public $guestsCount = '';
    public $email = '';
    public $selectedReservation = null;
    public $showModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
        'status' => ['except' => ''],
        'guestsCount' => ['except' => ''],
        'email' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showReservationDetails($reservationId)
    {
        $this->selectedReservation = Reservation::with(['room'])->find($reservationId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedReservation = null;
    }

    public function toggleAdvancedFilters()
    {
        $this->showAdvancedFilters = !$this->showAdvancedFilters;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'dateFrom', 'dateTo', 'status', 'guestsCount', 'email']);
    }

    public function render()
    {
        $query = Reservation::query()
            ->with(['room'])
            ->when($this->dateFrom, function ($query) {
                return $query->where('check_in', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                return $query->where('check_out', '<=', $this->dateTo);
            })
            ->when($this->status, function ($query) {
                $now = Carbon::now();
                switch ($this->status) {
                    case 'upcoming':
                        return $query->where('check_in', '>', $now);
                    case 'current':
                        return $query->where('check_in', '<=', $now)
                            ->where('check_out', '>=', $now);
                    case 'past':
                        return $query->where('check_out', '<', $now);
                }
            })
            ->when($this->guestsCount, function ($query) {
                return $query->where('guests_number', $this->guestsCount);
            })
            ->when($this->email, function ($query) {
                return $query->where('guest_email', 'like', '%' . $this->email . '%');
            });

        $reservations = $query->orderBy('check_in', 'desc')
            ->paginate(10);

        return view('livewire.admin.reservations-list', [
            'reservations' => $reservations
        ]);
    }
}

<?php
namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReservationStats extends Component
{
    public $period = 'week';
    public $stats;

    public function mount()
    {
        $this->stats = collect([]);
        $this->loadStats();
    }

    public function updatedPeriod()
    {
        $this->loadStats();
    }

public function loadStats()
{
    $now = Carbon::now();
    
    switch($this->period) {
        case 'week':
            // Dane dla bieżącego miesiąca, pogrupowane po tygodniach
            $startOfMonth = $now->copy()->startOfMonth();
            $endOfMonth = $now->copy()->endOfMonth();
            
            $this->stats = collect(Reservation::selectRaw('
                YEARWEEK(check_in) as week_number,
                COUNT(*) as count,
                SUM(total_price) as earnings
            ')
                ->whereBetween('check_in', [$startOfMonth, $endOfMonth])
                ->groupBy('week_number')
                ->orderBy('week_number')
                ->get()
                ->map(function ($item) use ($now) {
                    $weekNumber = $item->week_number;
                    $item->date = 'Tydzień ' . Carbon::now()->setISODate(date('Y'), substr($weekNumber, -2))->weekOfYear;
                    return $item;
                }));
            break;

        case 'month':
            // Dane dla bieżącego roku, pogrupowane po miesiącach
            $this->stats = collect(Reservation::selectRaw('
                MONTH(check_in) as month,
                COUNT(*) as count,
                SUM(total_price) as earnings
            ')
                ->whereYear('check_in', $now->year)
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->map(function ($item) {
                    $item->date = Carbon::create()->month($item->month)->translatedFormat('F');
                    return $item;
                }));
            break;

        case 'year':
            // Wszystkie dane pogrupowane po latach
            $this->stats = collect(Reservation::selectRaw('
                YEAR(check_in) as year,
                COUNT(*) as count,
                SUM(total_price) as earnings
            ')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->get()
                ->map(function ($item) {
                    $item->date = $item->year;
                    return $item;
                }));
            break;
    }
}


    public function getTotalCount()
    {
        return $this->stats->sum('count');
    }

    public function getAverageCount()
    {
        return $this->stats->avg('count');
    }

    public function getTotalEarnings()
    {
        return $this->stats->sum('earnings');
    }

    public function getAverageEarnings()
    {
        return $this->stats->avg('earnings');
    }

    public function getMaxCount()
    {
        return $this->stats->max('count') ?: 1;
    }

    public function render()
    {
        return view('livewire.admin.reservation-stats');
    }
}




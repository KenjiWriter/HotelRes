<?php

// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        
        // Statystyki dla bieżącego tygodnia
        $weeklyStats = Reservation::whereBetween('check_in', [
            $now->copy()->startOfWeek(),
            $now->copy()->endOfWeek()
        ])->count();

        $weeklyEarnings = Reservation::whereBetween('check_in', [
            $now->copy()->startOfWeek(),
            $now->copy()->endOfWeek()
        ])->sum('total_price');

        // Statystyki na dziś
        $todayStats = Reservation::whereDate('check_in', $now)->count();
        $todayEarnings = Reservation::whereDate('check_in', $now)->sum('total_price');

        // Statystyki na jutro
        $tomorrowStats = Reservation::whereDate('check_in', $now->copy()->addDay())->count();
        $tomorrowEarnings = Reservation::whereDate('check_in', $now->copy()->addDay())->sum('total_price');

        return view('admin.dashboard', compact(
            'weeklyStats',
            'weeklyEarnings',
            'todayStats',
            'todayEarnings',
            'tomorrowStats',
            'tomorrowEarnings'
        ));
    }
}

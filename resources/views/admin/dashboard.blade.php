@extends('layouts.admin')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard</h2>
        </div>

        <!-- Stats Grid -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Today's Stats -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white text-sm font-medium">Dzisiejsze rezerwacje</p>
                    <p class="text-white text-3xl font-bold">{{ $todayStats }}</p>
                </div>
                <div class="p-3 bg-blue-600 rounded-full">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="text-white">
                <p class="text-sm">Zysk dziś:</p>
                <p class="text-xl font-semibold">{{ number_format($todayEarnings, 2) }} zł</p>
            </div>
        </div>

            <!-- Tomorrow's Reservations -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-medium">Jutrzejsze rezerwacje</p>
                        <p class="text-white text-3xl font-bold">{{ $tomorrowStats }}</p>
                    </div>
                    <div class="p-3 bg-green-600 rounded-full">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Weekly Reservations -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-white text-sm font-medium">Rezerwacje w tym tygodniu</p>
                        <p class="text-white text-3xl font-bold">{{ $weeklyStats }}</p>
                    </div>
                    <div class="p-3 bg-purple-600 rounded-full">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-white">
                    <p class="text-sm">Zysk w tym tygodniu:</p>
                    <p class="text-xl font-semibold">{{ number_format($weeklyEarnings, 2) }} zł</p>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="p-6 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Statystyki rezerwacji</h3>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <livewire:admin.reservation-stats />
            </div>
        </div>
    </div>
</div>
@endsection

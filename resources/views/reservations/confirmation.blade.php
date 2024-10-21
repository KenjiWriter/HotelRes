@extends('layouts.app')
@section('title', 'Potwierdzenie rezerwacji')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 dark:text-white">Potwierdzenie rezerwacji</h1>

        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-200 border border-green-400 text-green-700 dark:text-green-800 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukces!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4 dark:text-white">Szczegóły rezerwacji</h2>
                <p class="dark:text-gray-300"><strong>Pokój:</strong> {{ $reservation->room->name }}</p>
                <p class="dark:text-gray-300"><strong>Gość:</strong> {{ $reservation->guest_name }}</p>
                <p class="dark:text-gray-300"><strong>E-mail:</strong> {{ $reservation->guest_email }}</p>
                <p class="dark:text-gray-300"><strong>Data zameldowania:</strong> {{ $reservation->check_in->format('d.m.Y') }}</p>
                <p class="dark:text-gray-300"><strong>Data wymeldowania:</strong> {{ $reservation->check_out->format('d.m.Y') }}</p>
                <p class="dark:text-gray-300"><strong>Liczba gości:</strong> {{ $reservation->guests_number }}</p>
                <p class="dark:text-gray-300"><strong>Cena za osobę za noc:</strong> {{ number_format($reservation->room->price_per_person, 2) }} PLN</p>
                <p class="dark:text-gray-300"><strong>Całkowita cena:</strong> {{ number_format($reservation->total_price, 2) }} PLN</p>
            </div>
        </div>

        <a href="{{ route('home') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Powrót do strony głównej
        </a>
    </div>
@endsection
@extends('layouts.app')
@section('title', __('messages.confirmation_title'))

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 dark:text-white">{{ __('messages.confirmation_title') }}</h1>

        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-200 border border-green-400 text-green-700 dark:text-green-800 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">{{ __('messages.success_message') }}</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4 dark:text-white">{{ __('messages.reservation_details') }}</h2>
                <p class="dark:text-gray-300"><strong>{{ __('messages.room') }}:</strong> {{ $reservation->room->name }}</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.guest') }}:</strong> {{ $reservation->guest_name }}</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.email') }}:</strong> {{ $reservation->guest_email }}</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.check_in') }}:</strong> {{ $reservation->check_in->format('d.m.Y') }}</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.check_out') }}:</strong> {{ $reservation->check_out->format('d.m.Y') }}</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.guests_number') }}:</strong> {{ $reservation->guests_number }}</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.per_person_per_night') }}:</strong> {{ number_format($reservation->room->price_per_person, 2) }} PLN</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.total_price') }}:</strong> {{ number_format($reservation->total_price, 2) }} PLN</p>
            </div>
        </div>

        <a href="{{ route('home') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('messages.back_to_home') }}
        </a>
    </div>
@endsection
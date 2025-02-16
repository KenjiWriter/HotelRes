@extends('layouts.app')
@section('title', __('messages.confirmation_title'))

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 dark:text-white">{{ __('messages.confirmation_title') }}</h1>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4 dark:text-white">{{ __('messages.reservation_details') }}</h2>
                <p class="dark:text-gray-300"><strong>{{ __('messages.room') }}:</strong> {{ $reservation->room->name }}</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.guest') }}:</strong> {{ $reservation->guest_name }}</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.email') }}:</strong> {{ $reservation->guest_email }}
                </p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.check_in') }}:</strong>
                    {{ $reservation->check_in->format('d.m.Y') }}</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.check_out') }}:</strong>
                    {{ $reservation->check_out->format('d.m.Y') }}</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.guests_number') }}:</strong>
                    {{ $reservation->guests_number }}</p>
                <p class="dark:text-gray-300"><strong>{{ __('messages.per_person_per_night') }}:</strong>
                    {{ number_format($reservation->room->price_per_person, 2) }} PLN</p>

                {{-- Sekcja z ceną i rabatem --}}
                <div class="mt-4 border-t pt-4">
                    @if ($reservation->discount_amount > 0)
                        <p class="dark:text-gray-300">
                            <strong>{{ __('messages.original_price') }}:</strong>
                            <span class="line-through">{{ number_format($reservation->original_price, 2) }} PLN</span>
                        </p>
                        <p class="dark:text-gray-300 text-green-600">
                            <strong>{{ __('messages.discount_applied') }}:</strong>
                            -{{ number_format($reservation->discount_amount, 2) }} PLN
                            @if ($reservation->voucher_code)
                                ({{ __('messages.voucher_code') }}: {{ $reservation->voucher_code }})
                            @endif
                        </p>
                    @endif
                    <p class="dark:text-gray-300 text-xl font-bold mt-2">
                        <strong>{{ __('messages.total_price') }}:</strong>
                        {{ number_format($reservation->total_price, 2) }} PLN
                    </p>
                </div>

                {{-- Szczegóły gości --}}
                @if ($reservation->guests_details)
                    <div class="mt-4 border-t pt-4">
                        <h3 class="text-lg font-bold mb-2 dark:text-white">{{ __('messages.guests_details') }}</h3>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach ($reservation->guests_details as $type => $count)
                                @if ($count > 0)
                                    <p class="dark:text-gray-300">
                                        <strong>{{ __("messages.$type") }}:</strong> {{ $count }}
                                    </p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <a href="{{ route('home') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('messages.back_to_home') }}
        </a>
    </div>
@endsection

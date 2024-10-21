@extends('layouts.app')

@section('title', __('messages.cancel_reservation'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center">{{ __('messages.cancel_reservation') }}</h1>
    <p class="text-center mb-4">{{ __('messages.cancel_info') }}</p>

    <form action="{{ route('reservation.cancel', ['id' => $reservation->id]) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-md mx-auto dark:bg-gray-800">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300" for="cancellation_code">
                {{ __('messages.cancellation_code') }}
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-700" id="cancellation_code" type="text" name="cancellation_code" value="{{ old('cancellation_code', $code) }}" required>
            @error('cancellation_code')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Anuluj rezerwację
            </button>
        </div>
    </form>
</div>
@endsection
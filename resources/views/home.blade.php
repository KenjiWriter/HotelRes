@extends('layouts.app')
@section('title', __('messages.search_room'))
@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 dark:text-white">{{ __('messages.search_room') }}</h1>
        <form action="{{ route('search') }}" method="GET" class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="check_in">
                    {{ __('messages.check_in') }}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="check_in" type="date" name="check_in" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="check_out">
                    {{ __('messages.check_out') }}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="check_out" type="date" name="check_out" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="guests">
                    {{ __('messages.guests') }}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="guests" type="number" name="guests" min="1" required>
            </div>
            <div class="mb-4 flex space-x-4">
                <div class="w-1/2">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="price_min">
                        {{ __('messages.price_min') }}
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price_min" type="number" name="price_min" min="0" step="0.01">
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="price_max">
                        {{ __('messages.price_max') }}
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price_max" type="number" name="price_max" min="0" step="0.01">
                </div>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    {{ __('messages.search') }}
                </button>
            </div>
        </form>
    </div>
@endsection
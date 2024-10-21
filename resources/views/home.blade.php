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
        <h2 class="text-2xl font-bold mb-4 dark:text-white">{{ __('messages.suggested_rooms') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($suggestedRooms as $room)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="swiper-container h-64 relative">
                    <div class="swiper-wrapper">
                        @if($room->images->isEmpty())
                            <div class="swiper-slide">
                                <img src="{{ asset('rooms_photos/room1.png') }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            @foreach($room->images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="absolute bottom-0 right-0 bg-black bg-opacity-50 text-white px-2 py-1 text-sm">
                        {{ __('messages.swipe_to_see_more') }}
                    </div>
                </div>
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-2 dark:text-white">{{ $room->name }}</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ Str::limit($room->description, 100) }}</p>
                    <p class="text-lg font-semibold dark:text-gray-300">{{ __('messages.price') }}: {{ number_format($room->price_per_person, 2) }} {{ __('messages.per_person_per_night') }}</p>
                    <p class="text-gray-600 mb-4 dark:text-white">{{ __('messages.capacity') }}: {{ $room->capacity }}</p>
                    <a href="{{ route('room.show', ['id' => $room->id]) }}"
                       class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                       {{ __('messages.details_and_booking') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        new Swiper('.swiper-container', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            spaceBetween: 4000,
            slidesPerView: 1,
        });
    </script>
@endsection
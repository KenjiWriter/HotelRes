@extends('layouts.app')
@section('title', __('messages.room_name', ['name' => $room->name]))
@section('style')
    <style>
        .swiper-container {
            width: 100%;
            height: 256px;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 30px 20px;
            border-radius: 5px;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 dark:text-white">{{ $room->name }}</h1>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">{{ __('messages.error') }}</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Section with images and description -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8 flex dark:bg-gray-800">
            <!-- Images on the left -->
            <div class="w-1/2">
                <div class="swiper-container h-64 relative">
                    <div class="swiper-wrapper">
                        @if ($room->images->isEmpty())
                            <div class="swiper-slide">
                                <img src="{{ asset('rooms_photos/room1.png') }}" alt="{{ $room->name }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @else
                            @foreach ($room->images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $room->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div
                        class="absolute bottom-0 right-0 bg-black bg-opacity-50 text-white px-2 py-1 text-sm dark:text-white">
                        {{ __('messages.swipe_to_see_more') }}
                    </div>
                </div>
            </div>

            <!-- Description on the right -->
            <div class="w-1/2 p-6">
                <p class="text-gray-700 mb-4 dark:text-white">{{ $room->description }}</p>
                <p class="text-lg font-semibold mb-2 dark:text-white">{{ __('messages.price') }}:
                    {{ number_format($room->price_per_person, 2) }} {{ __('messages.per_person_per_night') }}</p>
                <p class="text-gray-600 mb-4 dark:text-white">{{ __('messages.capacity') }}: {{ $room->capacity }}</p>
                <!-- Amenities -->
                <h3 class="text-lg font-bold mt-4 dark:text-white">{{ __('amenities.Amenities') }}:</h3>
                <ul class="list-disc list-inside dark:text-white">
                    @foreach ($room->amenities as $amenity)
                        <li>{{ __('amenities.' . $amenity->name) }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-4">{{ __('messages.booking_room') }}</h2>
        <livewire:room-reservation :room="$room" />
        <div class="mt-8">
            <h3 class="text-xl font-bold mb-4">Average Rating: {{ number_format($room->averageRating(), 1) }}</h3>

            @foreach ($room->reviews as $review)
                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded">
                    <p><strong>Rating:</strong> {{ number_format($review->rating, 1) }}</p>
                    @if ($review->comment)
                        <p><strong>Comment:</strong> {{ $review->comment }}</p>
                    @endif
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

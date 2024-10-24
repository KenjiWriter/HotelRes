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
        .swiper-button-next, .swiper-button-prev {
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 30px 20px;
            border-radius: 5px;
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 dark:text-white">{{ $room->name }}</h1>

        @if(session('error'))
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
                    <div class="absolute bottom-0 right-0 bg-black bg-opacity-50 text-white px-2 py-1 text-sm dark:text-white">
                        {{ __('messages.swipe_to_see_more') }}
                    </div>
                </div>
            </div>

            <!-- Description on the right -->
            <div class="w-1/2 p-6">
                <p class="text-gray-700 mb-4 dark:text-white">{{ $room->description }}</p>
                <p class="text-lg font-semibold mb-2 dark:text-white">{{ __('messages.price') }}: {{ number_format($room->price_per_person, 2) }} {{ __('messages.per_person_per_night') }}</p>
                <p class="text-gray-600 mb-4 dark:text-white">{{ __('messages.capacity') }}: {{ $room->capacity }}</p>
                <!-- Amenities -->
                <h3 class="text-lg font-bold mt-4 dark:text-white">{{ __('amenities.Amenities')}}:</h3>
                <ul class="list-disc list-inside dark:text-white">
                    @foreach($room->amenities as $amenity)
                        <li>{{ __('amenities.' . $amenity->name) }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-4">{{ __('messages.booking_room') }}</h2>
        <form action="{{ route('room.reserve', $room->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 dark:bg-gray-800">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="guest_name">
                    {{ __('messages.guest_name') }}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-700" id="guest_name" type="text" name="guest_name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="guest_email">
                    {{ __('messages.guest_email') }}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-700" id="guest_email" type="email" name="guest_email" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="check_in">
                    {{ __('messages.check_in') }}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-700" id="check_in" type="date" name="check_in" value="{{ $checkIn ? $checkIn->format('Y-m-d') : '' }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="check_out">
                    {{ __('messages.check_out') }}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-700" id="check_out" type="date" name="check_out" value="{{ $checkOut ? $checkOut->format('Y-m-d') : '' }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="guests_number">
                    {{ __('messages.guests_number') }}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-700" id="guests_number" type="number" name="guests_number" min="1" max="{{ $room->capacity }}" value="1" required>
            </div>
            <div class="mb-6">
                <p class="text-lg font-bold">{{ __('messages.total_price') }}: <span id="total_price">0.00</span> PLN</p>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    {{ __('messages.reserve') }}
                </button>
            </div>
        </form>
        <div class="mt-8">
            <h3 class="text-xl font-bold mb-4">Average Rating: {{ number_format($room->averageRating(), 1) }}</h3>
        
            @foreach($room->reviews as $review)
                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded">
                    <p><strong>Rating:</strong> {{ number_format($review->rating, 1) }}</p>
                    @if($review->comment)
                        <p><strong>Comment:</strong> {{ $review->comment }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');
            const guestsNumberInput = document.getElementById('guests_number');
            const totalPriceSpan = document.getElementById('total_price');
            const pricePerPerson = {{ $room->price_per_person }};

            function calculateTotalPrice() {
                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);
                const guestsNumber = parseInt(guestsNumberInput.value) || 1;

                if (checkIn && checkOut && checkOut > checkIn) {
                    const nights = (checkOut - checkIn) / (1000 * 60 * 60 * 24);
                    const totalPrice = pricePerPerson * guestsNumber * nights;
                    totalPriceSpan.textContent = totalPrice.toFixed(2);
                } else {
                    totalPriceSpan.textContent = '0.00';
                }
            }

            checkInInput.addEventListener('change', calculateTotalPrice);
            checkOutInput.addEventListener('change', calculateTotalPrice);
            guestsNumberInput.addEventListener('input', calculateTotalPrice);

            // Oblicz cenę przy ładowaniu strony
            calculateTotalPrice();
        });
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
<div>
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

    <div class="mb-4">
        <label for="sortOrder" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
            {{ __('messages.sort_by_price') }}
        </label>
        <select wire:model="sortOrder" id="sortOrder" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="default">{{ __('messages.default_order') }}</option>
            <option value="asc">{{ __('messages.price_ascending') }}</option>
            <option value="desc">{{ __('messages.price_descending') }}</option>
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($rooms as $room)
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
                    <p class="font-bold mb-4 text-gray-600 dark:text-white">Average Rating: {{ number_format($room->averageRating(), 1) }}</p>
                    <a href="{{ route('room.show', ['id' => $room->id, 'check_in' => $checkIn->format('Y-m-d'), 'check_out' => $checkOut->format('Y-m-d')]) }}"
                    class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('messages.details_and_booking') }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <script>
        // Initialize Swiper
        document.querySelectorAll('.swiper-container').forEach(container => {
            const swiperWrapper = container.querySelector('.swiper-wrapper');
            const slidesCount = swiperWrapper.children.length;

            new Swiper(container, {
                loop: slidesCount > 1,
                pagination: {
                    el: '.swiper-pagination',
                },
                navigation: slidesCount > 1 ? {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                } : false,
            });
        });
    </script>
</div>
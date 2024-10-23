@extends('layouts.app')
@section('title', __('messages.search_room'))
@livewireStyles
@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 dark:text-white">{{ __('messages.search_room') }}</h1>
        @livewire('room-search')
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
@livewireScripts
@section('scripts')
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
            dropdown.classList.toggle('opacity-0');
            dropdown.classList.toggle('scale-y-0');
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdown');
            if (!event.target.closest('#dropdown') && !event.target.closest('button')) {
                dropdown.classList.add('hidden');
                dropdown.classList.add('opacity-0');
                dropdown.classList.add('scale-y-0');
            }
        });

        document.querySelectorAll('#dropdown input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('click', function(event) {
                event.stopPropagation();
            });
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
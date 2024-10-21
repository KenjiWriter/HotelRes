@extends('layouts.app')
@section('title', 'Wyniki wyszukiwania')

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
        <h1 class="text-3xl font-bold mb-8">Wyniki wyszukiwania</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($rooms as $room)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
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
                            Przesuń, aby zobaczyć więcej zdjęć
                        </div>
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-2">{{ $room->name }}</h2>
                        <p class="text-gray-700 mb-4">{{ Str::limit($room->description, 100) }}</p>
                        <p class="text-lg font-semibold">Cena: {{ number_format($room->price_per_person, 2) }} PLN / osoba / noc</p>
                        <a href="{{ route('room.show', ['id' => $room->id, 'check_in' => $checkIn->format('Y-m-d'), 'check_out' => $checkOut->format('Y-m-d')]) }}"
                            class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Szczegóły i rezerwacja
                        </a>
                    </div>
                </div>
            @endforeach
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
        });
    </script>
@endsection
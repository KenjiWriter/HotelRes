@extends('layouts.app')
@section('title', __('messages.search_results'))

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
        <h1 class="text-3xl font-bold mb-8 dark:text-white">{{ __('messages.search_results') }}</h1>
        @livewire('search-results', ['rooms' => $rooms, 'checkIn' => $checkIn, 'checkOut' => $checkOut])
    </div>
@endsection

@section('scripts')
@endsection

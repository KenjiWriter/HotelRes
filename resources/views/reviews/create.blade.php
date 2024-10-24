@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Rate Your Stay</h1>

    <form action="{{ route('review.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room->id }}">
        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="rating">
                Rating (1.0 - 5.0)
            </label>
            <select name="rating" id="rating" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @for ($i = 1; $i <= 5; $i += 0.5)
                    <option value="{{ number_format($i, 1) }}">{{ number_format($i, 1) }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="comment">
                Comment
            </label>
            <textarea name="comment" id="comment" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Submit Review
            </button>
        </div>
    </form>
</div>
@endsection
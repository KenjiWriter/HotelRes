<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        return view('reviews.create', [
            'room' => Room::findOrFail($request->room_id),
            'reservation' => Reservation::findOrFail($request->reservation_id),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        Review::create([
            'room_id' => $request->room_id,
            'reservation_id' => $request->reservation_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('home')->with('success', 'Thank you for your review!');
    }
}

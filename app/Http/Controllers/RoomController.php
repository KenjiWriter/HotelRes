<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Mail\ReviewRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;

class RoomController extends Controller
{
    public function show(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $checkIn = $request->query('check_in') ? Carbon::parse($request->query('check_in')) : null;
        $checkOut = $request->query('check_out') ? Carbon::parse($request->query('check_out')) : null;

        return view('rooms.show', compact('room', 'checkIn', 'checkOut'));
    }

    public function reserve(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $cancellationCode = mt_rand(10000, 99999);

        $validatedData = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests_number' => 'required|integer|min:1|max:' . $room->capacity,
        ]);

        // Sprawdź dostępność pokoju
        $isAvailable = $room->isAvailable($validatedData['check_in'], $validatedData['check_out']);

        if (!$isAvailable) {
            return back()->with('error', 'Pokój nie jest dostępny w wybranym terminie.');
        }

        // Oblicz całkowitą cenę
        $totalPrice = $room->calculateTotalPrice(
            $validatedData['check_in'],
            $validatedData['check_out'],
            $validatedData['guests_number']
        );

        // Utwórz rezerwację
        $reservation = $room->reservations()->create([
            'guest_name' => $validatedData['guest_name'],
            'guest_email' => $validatedData['guest_email'],
            'check_in' => $validatedData['check_in'],
            'check_out' => $validatedData['check_out'],
            'guests_number' => $validatedData['guests_number'],
            'total_price' => $totalPrice,
            'cancellation_code' => $cancellationCode,
        ]);

        Mail::to($reservation->guest_email)->send(new ReservationConfirmation($reservation));
        // Mail::to($reservation->guest_email)->send(new ReviewRequest($reservation));

        return redirect()->route('reservation.confirmation', $reservation->id)
            ->with('success', __('messages.reservation_completed'));
    }

    public function uploadImage(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/rooms'), $imageName);

            $room->images()->create([
                'image_path' => 'images/rooms/' . $imageName
            ]);

            return back()->with('success', 'Zdjęcie zostało dodane.');
        }

        return back()->with('error', 'Wystąpił błąd podczas przesyłania zdjęcia.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        ]);

        // TODO: Wysłać e-mail z potwierdzeniem

        return redirect()->route('reservation.confirmation', $reservation->id)
            ->with('success', 'Rezerwacja została pomyślnie utworzona.');
    }
}
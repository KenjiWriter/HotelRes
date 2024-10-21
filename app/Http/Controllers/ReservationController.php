<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function confirmation($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservations.confirmation', compact('reservation'));
    }

    public function showCancelForm($id, Request $request)
    {
        $reservation = Reservation::findOrFail($id);
        $code = $request->query('code', '');
    
        return view('reservations.cancel', compact('reservation', 'code'));
    }
    
    public function cancelReservation(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
    
        $request->validate([
            'cancellation_code' => 'required|numeric',
        ]);
    
        if ($request->input('cancellation_code') != $reservation->cancellation_code) {
            return back()->withErrors(['cancellation_code' => 'Invalid cancellation code.']);
        }
    
        if (now()->diffInHours($reservation->check_in) <= 48) {
            return back()->withErrors(['cancellation_code' => 'Cannot cancel within 48 hours of check-in.']);
        }
    
        $reservation->delete();
    
        return redirect()->route('home')->with('success', 'Reservation cancelled successfully.');
    }
}
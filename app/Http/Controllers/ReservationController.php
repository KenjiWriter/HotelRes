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
}
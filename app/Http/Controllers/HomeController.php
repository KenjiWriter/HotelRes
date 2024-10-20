<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function search(Request $request)
    {
        $validatedData = $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
        ]);

        return redirect()->route('search.results', $validatedData);
    }

    public function searchResults(Request $request)
    {
        $searchParams = $request->all();

        if (empty($searchParams)) {
            return redirect()->route('home')->with('error', 'Brak parametrów wyszukiwania. Proszę wypełnić formularz.');
        }

        $query = Room::query();

        // Filtrowanie po liczbie gości
        $query->where('capacity', '>=', $searchParams['guests']);

        // Filtrowanie po cenie
        if (!empty($searchParams['price_min'])) {
            $query->where('price', '>=', $searchParams['price_min']);
        }
        if (!empty($searchParams['price_max'])) {
            $query->where('price', '<=', $searchParams['price_max']);
        }

        // Sprawdzanie dostępności w wybranych datach
        $checkIn = Carbon::parse($searchParams['check_in']);
        $checkOut = Carbon::parse($searchParams['check_out']);

        $query->whereDoesntHave('reservations', function ($q) use ($checkIn, $checkOut) {
            $q->where(function ($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in', [$checkIn, $checkOut])
                  ->orWhereBetween('check_out', [$checkIn, $checkOut])
                  ->orWhere(function ($q) use ($checkIn, $checkOut) {
                      $q->where('check_in', '<=', $checkIn)
                        ->where('check_out', '>=', $checkOut);
                  });
            });
        });

        $rooms = $query->get();

        if ($rooms->isEmpty()) {
            return redirect()->route('home')->with('error', 'Nie znaleziono pokoi spełniających kryteria. Proszę spróbować ponownie z innymi parametrami.');
        }

        return view('search_results', compact('rooms', 'checkIn', 'checkOut'));
    }
}
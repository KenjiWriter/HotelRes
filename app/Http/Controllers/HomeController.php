<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $suggestedRooms = Room::whereDoesntHave('reservations', function ($query) use ($today) {
            $query->where('check_in', '<=', $today)
                  ->where('check_out', '>=', $today);
        })->inRandomOrder()->take(6)->get();
        return view('home', compact('suggestedRooms'));
    }

    public function search(Request $request)
    {
        $validatedData = $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
            'amenities' => 'nullable',
        ]);

        return redirect()->route('search.results', $validatedData);
    }

    public function searchResults(Request $request)
    {
        $searchParams = $request->all();
    
        if (empty($searchParams)) {
            return redirect()->route('home')->with('error', __('messages.no_search_parameters'));
        }
    
        $query = Room::query();
    
        // Filter by number of guests
        $query->where('capacity', '>=', $searchParams['guests']);
    
        // Filter by price
        if (!empty($searchParams['price_min'])) {
            $query->where('price_per_person', '>=', $searchParams['price_min']);
        }
        if (!empty($searchParams['price_max'])) {
            $query->where('price_per_person', '<=', $searchParams['price_max']);
        }
    
        // Filter by amenities
        if (!empty($searchParams['amenities'])) {
            $amenities = is_array($searchParams['amenities']) ? $searchParams['amenities'] : [$searchParams['amenities']];
            foreach ($amenities as $amenityId) {
                $query->whereHas('amenities', function ($q) use ($amenityId) {
                    $q->where('amenities.id', $amenityId);
                });
            }
        }
    
        // Check availability for selected dates
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
            return redirect()->route('home')->with('error', __('messages.no_rooms_found'));
        }
    
        return view('search_results', compact('rooms', 'checkIn', 'checkOut'));
    }
}
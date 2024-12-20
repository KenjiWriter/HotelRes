<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\RoomImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomsController extends Controller
{
    public function index()
    {
        $rooms = Room::withCount('reservations')
            ->with('reviews')
            ->get()
            ->map(function ($room) {
                $weeklyReservations = $room->reservations()
                    ->whereBetween('check_in', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count();

                $yearlyReservations = $room->reservations()
                    ->whereBetween('check_in', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear()
                    ])->count();

                return [
                    'id' => $room->id,
                    'name' => $room->name,
                    'capacity' => $room->capacity,
                    'price_per_person' => $room->price_per_person,
                    'is_available' => $room->is_available,
                    'total_reservations' => $room->reservations_count,
                    'weekly_reservations' => $weeklyReservations,
                    'yearly_reservations' => $yearlyReservations,
                    'average_rating' => $room->averageRating()
                ];
            });

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        // Walidacja danych
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer',
            'price_per_person' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Walidacja zdjęć
        ]);

        // Tworzenie nowego pokoju
        $room = Room::create($request->only('name', 'description', 'capacity', 'price_per_person', 'is_available'));

        // Zapisz obrazy
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public'); // Przechowywanie w publicznym dysku
                RoomImage::create(['room_id' => $room->id, 'image_path' => $path]);
            }
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully');
    }

    public function edit($id)
    {
        $room = Room::with('images')->findOrFail($id);
        return view('admin.rooms.edit', compact('room'));
    }

    public function update($request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer',
            'price_per_person' => 'required|numeric',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $room = Room::findOrFail($id);
        
        $room->update([
            'name' => $request->name,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'price_per_person' => $request->price_per_person,
            'is_available' => $request->has('is_available'),
        ]);

        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Pokój został zaktualizowany');
    }

    public function deleteImage($imageId)
    {
        $image = RoomImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Zdjęcie zostało usunięte');
    }

    public function destroy($id)
    {
        try {
            $room = Room::findOrFail($id);
            
            // Usuń wszystkie zdjęcia pokoju
            foreach ($room->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
            
            // Usuń pokój
            $room->delete();
            
            return redirect()->route('admin.rooms.index')
                ->with('success', 'Pokój został pomyślnie usunięty');
        } catch (\Exception $e) {
            return redirect()->route('admin.rooms.index')
                ->with('error', 'Wystąpił błąd podczas usuwania pokoju');
        }
    }


}

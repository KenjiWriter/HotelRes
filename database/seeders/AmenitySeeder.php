<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    public function run()
    {
        $amenities = [
            'WiFi',
            'Separate_kitchen',
            'Bathtub',
            'Jacuzzi',
            'Balcony',
            'Television',
            'Air_conditioning',
            'Safe',
            'Mini_bar',
            'Room_service',
            'Parking',
            'Swimming_pool',
            'Gym',
            'Spa'
        ];

        foreach ($amenities as $amenity) {
            Amenity::create(['name' => $amenity]);
        }
    }
}
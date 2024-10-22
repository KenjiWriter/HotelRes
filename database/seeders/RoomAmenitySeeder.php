<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Amenity;
use Faker\Factory as Faker;

class RoomAmenitySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $amenities = Amenity::all();

        Room::all()->each(function ($room) use ($faker, $amenities) {
            // Attach 1 to 3 random amenities to each room
            $room->amenities()->attach(
                $amenities->random($faker->numberBetween(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
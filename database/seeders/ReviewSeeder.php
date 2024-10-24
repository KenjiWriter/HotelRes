<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Room;
use App\Models\Reservation;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $rooms = Room::all();

        foreach ($rooms as $room) {
            for ($i = 0; $i < 3; $i++) {
                // Assuming each room has at least one reservation
                // $reservation = Reservation::where('room_id', $room->id)->inRandomOrder()->first();

                // if ($reservation) {
                    Review::create([
                        'room_id' => $room->id,
                        'reservation_id' => 17,
                        'rating' => $faker->randomFloat(1, 1, 5),
                        'comment' => $faker->sentence,
                    ]);
                // }
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            Room::create([
                'name' => $faker->unique()->word . ' Room',
                'description' => $faker->paragraph,
                'capacity' => $faker->numberBetween(1, 6),
                'price' => $faker->randomFloat(2, 50, 500),
                'is_available' => true,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // AmenitySeeder::class,
            // RoomAmenitySeeder::class,
            ReviewSeeder::class,
            // RoomSeeder::class,
        ]);
    }
}

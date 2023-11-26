<?php

namespace Database\Seeders;

use Database\Factories\RoomsFactory;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Room::factory(10)->create();
    }
}
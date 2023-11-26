<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'facilities' => $this->faker->words(3, true),
            'capacity' => $this->faker->numberBetween(1,6),
            'size' => $this->faker->numberBetween(20, 80),
            'price' => $this->faker->numberBetween(200, 500),
            'status' => $this->faker->randomElement(['available', 'booked']),
            'images_path' => 'storage/placeholder.webp'
        ];
    }
}

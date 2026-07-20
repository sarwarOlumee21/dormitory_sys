<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'room_number' => fake()->unique()->numberBetween(100, 999),
            'capacity' => fake()->numberBetween(1, 4),
            'room_type' => fake()->randomElement(['تک‌نفره', 'دو نفره', 'سه نفره', 'آپارتمان']),
            'status' => fake()->randomElement(['فعال', 'خالی', 'پر']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Resident;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Resident>
 */
class ResidentFactory extends Factory
{
    protected $model = Resident::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'resident_code' => 'RES-' . fake()->unique()->numberBetween(1000, 9999),
            'name' => fake()->name(),
            'father_name' => fake()->firstNameMale(),
            'phone_number' => fake()->phoneNumber(),
            'city_name' => fake()->city(),
            'occupation' => fake()->jobTitle(),
            'work_phone' => fake()->phoneNumber(),
            'occupation_location' => fake()->address(),

            'guarantor_name' => fake()->name(),
            'guarantor_father_name' => fake()->firstNameMale(),
            'guarantor_phone' => fake()->phoneNumber(),
            'guarantor_occupation' => fake()->jobTitle(),
            'guarantor_occupation_location' => fake()->address(),

            'room_id' => Room::inRandomOrder()->value('id'),

            'status' => fake()->randomElement(['فعال', 'غیرفعال']),
        ];
    }
}
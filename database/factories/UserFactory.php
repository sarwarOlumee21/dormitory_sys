<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->numberBetween(10000, 99999),

            'name' => fake()->name(),

            'email' => fake()->unique()->safeEmail(),

            'number' => fake()->phoneNumber(),

            'role' => fake()->randomElement([
                'admin',
                'user',
                'student'
            ]),

            'username' => fake()->unique()->userName(),

            'email_verified_at' => now(),

            'password' => Hash::make('password'),

            'remember_token' => fake()->sha256(),

            'created_at' => now(),

            'updated_at' => now(),
        ];
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ایجاد یا بروزرسانی کاربر تست
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'code' => fake()->unique()->randomNumber(5, true),
                'number' => fake()->unique()->phoneNumber(),
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => \Illuminate\Support\Str::random(10),
                'username' => 'testuser',
                'role' => 'admin',
            ]
        );

        // ایجاد اتاق‌ها
        \App\Models\Room::factory()->count(20)->create();

        // ایجاد ساکنین نمونه
        $this->call(ResidentSeeder::class);
    }
}

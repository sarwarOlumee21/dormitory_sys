<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resident;

class ResidentSeeder extends Seeder
{

public function run(): void
{
    $desired = 50;
    $existing = Resident::count();
    if ($existing < $desired) {
        Resident::factory()->count($desired - $existing)->create();
    }
}
}

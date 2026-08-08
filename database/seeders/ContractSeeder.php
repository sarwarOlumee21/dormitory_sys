<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContractRegister;
use App\Models\Resident;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        $residents = Resident::all();
        $rooms = Room::all();

        foreach ($residents as $resident) {
            $roomId = $resident->room_id ?: ($rooms->random()->id ?? null);
            $amount = rand(1000, 5000);
            $data = [
                'resident_id' => $resident->id,
                'contract_date' => Carbon::now()->subMonths(rand(0,12))->toDateString(),
                'contract_amount' => $amount,
                'contract_status' => rand(0,10) > 1 ? 'فعال' : 'منقضی',
                'notes' => null,
            ];
            if (Schema::hasColumn('contracts', 'room_id')) {
                $data['room_id'] = $roomId;
            }

            ContractRegister::create($data);
        }
    }
}

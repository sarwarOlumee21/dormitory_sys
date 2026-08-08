<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\payment;
use App\Models\ContractRegister;
use App\Models\Resident;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $contracts = ContractRegister::with('resident')->get();

        foreach ($contracts as $contract) {
            // only attempt payments for active contracts
            if ($contract->contract_status !== 'فعال') {
                continue;
            }

            $chance = rand(1, 100);
            // full payment (~60% chance)
            if ($chance <= 60) {
                payment::create([
                    'residents_id' => $contract->resident_id,
                    'amount' => $contract->contract_amount,
                    'payment_date' => Carbon::now()->subDays(rand(0,60))->toDateString(),
                    'notes' => 'کامل',
                ]);
            }
            // partial (~25% chance)
            elseif ($chance <= 85) {
                $partial = intval($contract->contract_amount * (rand(30,90) / 100));
                payment::create([
                    'residents_id' => $contract->resident_id,
                    'amount' => $partial,
                    'payment_date' => Carbon::now()->subDays(rand(0,60))->toDateString(),
                    'notes' => 'جزئی',
                ]);
            }
            // none (~15% chance): no payment created
        }

        // create some extra standalone payments (not tied to contracts) for variety
        $residents = Resident::inRandomOrder()->take(8)->get();
        foreach ($residents as $r) {
            payment::create([
                'residents_id' => $r->id,
                'amount' => rand(500, 4000),
                'payment_date' => Carbon::now()->subDays(rand(0,120))->toDateString(),
                'notes' => 'قابل بررسی',
            ]);
        }
    }
}

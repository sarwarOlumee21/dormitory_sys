<?php

namespace Database\Seeders;

use App\Models\ContractRegister;
use App\Models\MaintenanceRequest;
use App\Models\RequestType;
use App\Models\Resident;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class FakeDormitorySeeder extends Seeder
{
    public function run(): void
    {
        $rooms = collect();
        for ($index = 1; $index <= 5; $index++) {
            $rooms->push(Room::firstOrCreate(
                ['room_number' => 'FAKE-' . (100 + $index)],
                [
                    'capacity' => 4,
                    'room_type' => $index % 2 === 0 ? 'دو نفره' : 'آپارتمان',
                    'status' => 'فعال',
                    'notes' => 'اتاق نمونه فیک',
                ]
            ));
        }

        $users = collect();
        for ($index = 1; $index <= 20; $index++) {
            $number = str_pad((string) $index, 2, '0', STR_PAD_LEFT);
            $users->push(User::firstOrCreate(
                ['email' => "fake.user{$number}@example.com"],
                [
                    'code' => "FAKE-U-{$number}",
                    'name' => "کاربر فیک {$number}",
                    'number' => "07000000{$number}",
                    'role' => 'user',
                    'username' => "fake_user_{$number}",
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                ]
            ));
        }

        $residents = collect();
        for ($index = 1; $index <= 30; $index++) {
            $number = str_pad((string) $index, 2, '0', STR_PAD_LEFT);
            $residents->push(Resident::firstOrCreate(
                ['resident_code' => "FAKE-R-{$number}"],
                [
                    'name' => "ساکن فیک {$number}",
                    'father_name' => "پدر ساکن {$number}",
                    'phone_number' => "07900000{$number}",
                    'city_name' => 'کابل',
                    'occupation' => 'دانشجو',
                    'room_id' => $rooms[($index - 1) % 5]->id,
                    'status' => 'فعال',
                ]
            ));
        }

        $paymentNotes = ['کامل', 'جزئی', 'قابل بررسی'];
        $contractStatuses = ['فعال', 'فعال', 'منقضی'];
        foreach ($residents as $index => $resident) {
            $amount = 2500 + (($index % 6) * 500);
            $contract = ContractRegister::firstOrCreate(
                ['resident_id' => $resident->id, 'notes' => 'قرارداد فیک'],
                [
                    'contract_date' => Carbon::now()->subMonths($index % 12)->toDateString(),
                    'contract_amount' => $amount,
                    'contract_status' => $contractStatuses[$index % count($contractStatuses)],
                ]
            );

            $paymentAmount = match ($index % 3) {
                0 => $amount,
                1 => (int) ($amount * 0.6),
                default => (int) ($amount * 0.35),
            };

            DB::table('payments')->updateOrInsert(
                ['residents_id' => $resident->id, 'notes' => 'پرداخت فیک'],
                [
                    'amount' => $paymentAmount,
                    'payment_date' => Carbon::now()->subDays($index * 2)->toDateString(),
                    'created_at' => $contract->created_at ?? now(),
                    'updated_at' => now(),
                ]
            );
        }

        foreach ($residents->take(10) as $index => $resident) {
            DB::table('visitors')->updateOrInsert(
                ['guest_id_number' => 'FAKE-G-' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)],
                [
                    'resident_id' => $resident->id,
                    'guest_name' => "مهمان فیک " . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                    'guest_phone' => '07800000' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                    'check_in_at' => Carbon::now()->subDays($index + 1),
                    'check_out_possible_at' => Carbon::now()->addDays(1),
                    'purpose' => 'دیدار با ساکن',
                    'attendance_status' => $index % 2 === 0 ? 'داخل خوابگاه' : 'خارج شده',
                    'room_number' => $resident->room->room_number,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $requestTypes = collect();
        foreach (['تعمیر برق', 'تعمیر آب', 'نظافت', 'تجهیزات', 'سایر'] as $name) {
            $requestTypes->push(RequestType::firstOrCreate(
                ['name' => $name],
                ['description' => 'نوع درخواست فیک']
            ));
        }

        foreach ($users->take(5) as $index => $user) {
            MaintenanceRequest::firstOrCreate(
                ['description' => 'درخواست فیک شماره ' . ($index + 1)],
                [
                    'user_id' => $user->id,
                    'room_id' => $rooms[$index % 5]->id,
                    'priority' => ['کم', 'متوسط', 'فوری'][$index % 3],
                    'status' => 'جدید',
                    'is_active' => true,
                    'request_types_id' => $requestTypes[$index]->id,
                ]
            );
        }

        $this->command?->info('Fake dormitory data is ready: 5 rooms, 20 users, 30 residents, 30 contracts, 30 payments, 10 visitors, and 5 requests.');
    }
}

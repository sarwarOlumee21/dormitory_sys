<?php

namespace Tests\Feature;

use App\Models\Resident;
use App\Models\Room;
use App\Models\Visitors;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class ResidentReportTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (!Schema::hasTable('rooms')) {
            Schema::create('rooms', function (Blueprint $table) {
                $table->id();
                $table->string('room_number')->unique();
                $table->unsignedTinyInteger('capacity')->default(1);
                $table->string('status')->default('فعال');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('residents')) {
            Schema::create('residents', function (Blueprint $table) {
                $table->id();
                $table->string('resident_code')->nullable();
                $table->string('name');
                $table->foreignId('room_id')->nullable();
                $table->string('status')->default('فعال');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('visitors')) {
            Schema::create('visitors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('resident_id')->nullable();
                $table->string('guest_name');
                $table->string('room_number')->nullable();
                $table->dateTime('check_in_at')->nullable();
                $table->dateTime('check_out_at')->nullable();
                $table->string('attendance_status')->default('داخل خوابگاه');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('contracts')) {
            Schema::create('contracts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('resident_id')->nullable();
                $table->foreignId('room_id')->nullable();
                $table->date('contract_date')->nullable();
                $table->decimal('contract_amount', 14, 2)->default(0.00);
                $table->string('contract_status')->default('فعال');
                $table->timestamps();
            });
        }
    }

    public function test_resident_report_statistics_are_calculated_and_rendered(): void
    {
        $roomA = Room::create([
            'room_number' => '101',
            'capacity' => 2,
            'status' => 'فعال',
        ]);

        $roomB = Room::create([
            'room_number' => '102',
            'capacity' => 1,
            'status' => 'فعال',
        ]);

        Resident::create([
            'name' => 'علی رضایی',
            'resident_code' => 'R-1001',
            'room_id' => $roomA->id,
            'status' => 'فعال',
        ]);

        Resident::create([
            'name' => 'سارا احمدی',
            'resident_code' => 'R-1002',
            'room_id' => $roomB->id,
            'status' => 'فعال',
        ]);

        Visitors::create([
            'guest_name' => 'مهمان اول',
            'resident_id' => 1,
            'room_number' => '101',
            'check_in_at' => now(),
            'attendance_status' => 'داخل خوابگاه',
        ]);

        Visitors::create([
            'guest_name' => 'مهمان دوم',
            'resident_id' => 2,
            'room_number' => '102',
            'check_in_at' => now(),
            'attendance_status' => 'داخل خوابگاه',
        ]);

        $response = $this->withoutMiddleware()->get('/report.resident_report');

        $response->assertOk();
        $response->assertSeeInOrder(['مجموع اقامت‌کنندگان', '2']);
        $response->assertSeeInOrder(['مجموع مهمان‌ها', '2']);
        $response->assertSeeInOrder(['مجموع اتاق‌ها', '2']);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Resident;
use App\Models\Room;
use App\Models\User;
use App\Models\Visitors;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitorLeaveTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitors_can_be_marked_as_left_and_date_is_saved(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create(['room_number' => 101]);
        $resident = Resident::create([
            'name' => 'علی محمدی',
            'family' => 'محمدی',
            'national_code' => '1234567890',
            'phone_number' => '09120000000',
            'room_id' => $room->id,
            'status' => 'active',
            'contract_start_date' => '2026-01-01',
            'contract_end_date' => '2027-01-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $visitor = Visitors::create([
            'resident_id' => $resident->id,
            'guest_name' => 'مهمان تست',
            'guest_phone' => '09121111111',
            'guest_id_number' => '9876543210',
            'check_in_at' => '2026-08-28 10:00:00',
            'check_out_possible_at' => '2026-08-29 10:00:00',
            'room_number' => $room->id,
            'purpose' => 'بازدید',
            'attendance_status' => 'داخل خوابگاه',
        ]);

        $this->actingAs($user)
            ->post(route('visitors.leave'), [
                'visitor_id' => $visitor->id,
                'check_out_at' => '2026-08-29',
            ]);

        $visitor->refresh();

        $this->assertSame('2026-08-29', $visitor->check_out_at->format('Y-m-d'));
        $this->assertSame('خارج خوابگاه', $visitor->attendance_status);
    }
}

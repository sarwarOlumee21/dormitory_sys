<?php

namespace Tests\Feature;

use App\Models\Resident;
use App\Models\Room;
use App\Models\User;
use App\Models\Visitors;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VisitorUserRoomControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_pages_receive_rooms_residents_and_saved_visitors(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create(['room_number' => '701']);
        $resident = $this->resident($room);
        $visitor = Visitors::create([
            'resident_id' => $resident->id,
            'guest_name' => 'مهمان موجود',
            'guest_id_number' => 'G-701',
            'room_number' => $room->id,
            'check_in_at' => '2026-09-03 09:00:00',
            'attendance_status' => 'داخل خوابگاه',
        ]);

        $this->actingAs($admin)->get(route('visitors.register'))
            ->assertOk()
            ->assertViewIs('visitors.visitor_register')
            ->assertViewHas('residents', fn ($residents) => $residents->contains('id', $resident->id))
            ->assertViewHas('rooms', fn ($rooms) => $rooms->contains('id', $room->id));

        $this->actingAs($admin)->get(route('visitors.list'))
            ->assertOk()
            ->assertViewIs('visitors.visitor_list')
            ->assertViewHas('visitors', fn ($visitors) => $visitors->contains('id', $visitor->id));
    }

    public function test_visitor_validation_rejects_invalid_dates_and_relations(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('visitors.store'), [
            'resident_id' => 99999,
            'guest_name' => '',
            'guest_id_number' => '',
            'check_in_at' => 'not-a-date',
            'check_out_possible_at' => '2026-09-01',
            'room_number' => 99999,
        ])->assertSessionHasErrors([
            'resident_id', 'guest_name', 'guest_id_number', 'check_in_at',
            'room_number',
        ]);
    }

    public function test_visitor_leave_validation_does_not_change_existing_record(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create();
        $resident = $this->resident($room);
        $visitor = Visitors::create([
            'resident_id' => $resident->id,
            'guest_name' => 'مهمان داخل',
            'guest_id_number' => 'G-702',
            'room_number' => $room->id,
            'check_in_at' => '2026-09-03 09:00:00',
            'attendance_status' => 'داخل خوابگاه',
        ]);

        $this->actingAs($admin)->post(route('visitors.leave'), [
            'visitor_id' => $visitor->id,
            'check_out_at' => 'invalid-date',
        ])->assertSessionHasErrors('check_out_at');

        $this->assertDatabaseHas('visitors', [
            'id' => $visitor->id,
            'attendance_status' => 'داخل خوابگاه',
            'check_out_at' => null,
        ]);
    }

    public function test_room_controller_validates_unique_numbers_and_positive_capacity(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create(['room_number' => '703']);

        $this->actingAs($admin)->post(route('rooms.store'), [
            'room_number' => '703',
            'capacity' => 0,
        ])->assertSessionHasErrors(['room_number', 'capacity']);

        $this->actingAs($admin)->put(route('rooms.update', $room->id), [
            'room_number' => '703',
            'capacity' => 0,
        ])->assertSessionHasErrors('capacity');
    }

    public function test_user_controller_validates_roles_and_hashes_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('users.store'), [
            'code' => 'U-INVALID',
            'name' => 'کاربر نامعتبر',
            'email' => 'invalid-role@test.local',
            'role' => 'student',
            'username' => 'invalid-role',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'number' => '0700000000',
        ])->assertSessionHasErrors('role');

        $this->actingAs($admin)->post(route('users.store'), [
            'code' => 'U-VALID',
            'name' => 'کاربر معتبر',
            'email' => 'valid-user@test.local',
            'role' => 'user',
            'username' => 'valid-user',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'number' => '0700000001',
        ])->assertRedirect(route('users.userRegister'));

        $created = User::where('email', 'valid-user@test.local')->firstOrFail();
        $this->assertNotSame('password123', $created->password);
        $this->assertTrue(Hash::check('password123', $created->password));
    }

    public function test_visitor_user_and_room_routes_require_an_authorized_staff_role(): void
    {
        $this->get(route('visitors.list'))->assertRedirect(route('login'));
        $this->get(route('rooms.list'))->assertRedirect(route('login'));
        $this->get(route('users.userList'))->assertRedirect(route('login'));

        $regularUser = User::factory()->create(['role' => 'user']);
        $this->actingAs($regularUser)->get(route('visitors.list'))->assertForbidden();
        $this->actingAs($regularUser)->get(route('rooms.list'))->assertForbidden();
        $this->actingAs($regularUser)->get(route('users.userList'))->assertForbidden();
    }

    private function resident(Room $room): Resident
    {
        return Resident::factory()->create(['room_id' => $room->id]);
    }
}
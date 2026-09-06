<?php

namespace Tests\Feature;

use App\Models\ContractRegister;
use App\Models\ContractRules;
use App\Models\Meal;
use App\Models\MealSchedule;
use App\Models\Resident;
use App\Models\Room;
use App\Models\User;
use App\Models\Visitors;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AllControllersTest extends TestCase
{
    use RefreshDatabase;

    public function test_authentication_controller_handles_login_and_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.test',
            'username' => 'admin-test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $this->get(route('login'))->assertOk()->assertViewIs('auth.login');
        $this->post(route('loginform'), ['login' => $user->email, 'password' => 'password123'])
            ->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_resident_controller_lists_filters_and_updates_residents(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create(['capacity' => 2]);
        $resident = $this->resident($room, ['name' => 'ساکن آزمایشی']);

        $this->actingAs($admin)->get(route('home'))->assertOk()->assertViewIs('home');
        $this->actingAs($admin)->get(route('resident.register'))
            ->assertOk()->assertViewIs('resident.resident_register');
        $this->actingAs($admin)->get(route('resident.list'))
            ->assertOk()->assertViewIs('resident.resident_list');
        $this->actingAs($admin)->get(route('resident.list.details', $resident->id))
            ->assertOk()->assertViewIs('resident.resident_list_details');
        $this->actingAs($admin)->get(route('resident.list.edit', $resident->id))
            ->assertOk()->assertViewIs('resident.resident_edit');

        $this->actingAs($admin)->post(route('resident.update', $resident->id), $this->residentData($room, [
            'resident_code' => $resident->resident_code,
            'name' => 'نام به‌روزشده',
        ]))->assertRedirect(route('resident.list.details', $resident->id));

        $this->assertDatabaseHas('residents', ['id' => $resident->id, 'name' => 'نام به‌روزشده']);

        $this->actingAs($admin)->post(route('resident.store'), $this->residentData($room, [
            'resident_code' => 'RES-NEW',
            'name' => 'ساکن جدید',
        ]))->assertRedirect(route('resident.list'))
            ->assertSessionHas('success');
        $this->assertDatabaseHas('residents', ['resident_code' => 'RES-NEW', 'name' => 'ساکن جدید']);
    }

    public function test_room_controller_calculates_occupancy_and_updates_room(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create(['capacity' => 2]);
        $this->resident($room);

        $this->actingAs($admin)->get(route('rooms.register'))->assertOk()->assertViewIs('rooms.room_register');
        $this->actingAs($admin)->get(route('rooms.edit', $room->id))
            ->assertOk()->assertViewIs('rooms.room_edit');
        $list = $this->actingAs($admin)->get(route('rooms.list'));
        $list->assertOk()->assertViewHas('rooms', function ($rooms) use ($room) {
            $listed = $rooms->firstWhere('id', $room->id);
            return $listed && $listed->current_capacity === 1 && $listed->room_status === 'دارای ظرفیت';
        });

        $this->actingAs($admin)->put(route('rooms.update', $room->id), [
            'room_number' => (string) $room->room_number,
            'capacity' => 3,
            'notes' => 'به‌روزرسانی تست',
        ])->assertRedirect(route('rooms.list'))
            ->assertSessionHas('success');
        $this->assertDatabaseHas('rooms', ['id' => $room->id, 'capacity' => 3]);

        $this->actingAs($admin)->post(route('rooms.store'), [
            'room_number' => 'ROOM-NEW',
            'capacity' => 1,
            'notes' => 'اتاق جدید',
        ])->assertRedirect(route('rooms.list'))
            ->assertSessionHas('success');
        $this->assertDatabaseHas('rooms', ['room_number' => 'ROOM-NEW', 'capacity' => 1]);
    }

    public function test_visitor_controller_stores_and_closes_a_visit(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create();
        $resident = $this->resident($room);

        $this->actingAs($admin)->get(route('visitors.register'))->assertOk();
        $this->actingAs($admin)->post(route('visitors.store'), [
            'resident_id' => $resident->id,
            'guest_name' => 'مهمان تست',
            'guest_id_number' => 'G-100',
            'guest_phone' => '0700000000',
            'check_in_at' => '2026-09-03 10:00:00',
            'check_out_possible_at' => '2026-09-03 18:00:00',
            'room_number' => $room->id,
            'purpose' => 'دیدار',
        ])->assertRedirect(route('visitors.register'));

        $visitor = Visitors::firstOrFail();
        $this->actingAs($admin)->get(route('visitors.list'))->assertOk();
        $this->actingAs($admin)->post(route('visitors.leave'), [
            'visitor_id' => $visitor->id,
            'check_out_at' => '2026-09-03 17:00:00',
        ])->assertSessionHas('success');
        $this->assertDatabaseHas('visitors', ['id' => $visitor->id, 'attendance_status' => 'خارج خوابگاه']);
    }

    public function test_contract_controller_stores_rules_contract_payment_and_toggles_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create();
        $resident = $this->resident($room);

        $this->actingAs($admin)->get(route('contracts.register'))->assertOk();
        $this->actingAs($admin)->get(route('contracts.rules'))->assertOk();
        $this->actingAs($admin)->post(route('contracts.rules.save'), ['contract_rules' => 'قوانین تست'])
            ->assertSessionHas('success');
        $this->assertDatabaseHas('contract_rules', ['contract_rules' => 'قوانین تست']);

        $this->actingAs($admin)->post(route('contracts.store'), [
            'resident_id' => $resident->id,
            'contract_date' => '2026-09-01',
            'contract_amount' => 1000,
            'notes' => 'قرارداد تست',
        ])->assertSessionHas('success');
        $contract = ContractRegister::firstOrFail();

        $this->actingAs($admin)->get(route('contracts.list'))->assertOk();
        $this->actingAs($admin)->get(route('contracts.show', $contract->id))->assertOk();
        $this->actingAs($admin)->get(route('contracts.edit', $contract->id))->assertOk();
        $this->actingAs($admin)->post(route('contracts.toggle', $contract->id))->assertSessionHas('success');
        $this->assertDatabaseHas('contracts', ['id' => $contract->id, 'contract_status' => 'غيرفعال']);

        $this->actingAs($admin)->put(route('contracts.update', $contract->id), [
            'resident_id' => $resident->id,
            'contract_date' => '2026-09-02',
            'contract_amount' => 1250,
            'contract_status' => 'فعال',
            'notes' => 'قرارداد ویرایش‌شده',
        ])->assertRedirect(route('contracts.show', $contract->id))
            ->assertSessionHas('success');
        $this->assertDatabaseHas('contracts', ['id' => $contract->id, 'contract_amount' => 1250]);

        $this->actingAs($admin)->post(route('contracts.payment.store'), [
            'resident_id' => $resident->id,
            'amount' => 250,
            'payment_date' => '2026-09',
            'notes' => 'پرداخت تست',
        ])->assertSessionHas('success');
        $this->assertDatabaseHas('payments', ['residents_id' => $resident->id, 'amount' => 250, 'payment_date' => '2026-09-01']);
    }

    public function test_user_controller_registers_lists_edits_and_updates_users(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('users.userRegister'))->assertOk();
        $this->actingAs($admin)->post(route('users.store'), [
            'code' => 'U-100', 'name' => 'کاربر تست', 'email' => 'user@test.local',
            'role' => 'staff', 'username' => 'user-test', 'password' => 'password123',
            'password_confirmation' => 'password123', 'number' => '0700111222',
        ])->assertRedirect(route('users.userRegister'));

        $created = User::where('email', 'user@test.local')->firstOrFail();
        $this->assertTrue(Hash::check('password123', $created->password));
        $this->actingAs($admin)->get(route('users.userList'))->assertOk();
        $this->actingAs($admin)->get(route('users.userEdit', $created->id))->assertOk();
        $this->actingAs($admin)->put(route('users.userUpdate', $created->id), [
            'code' => 'U-100', 'name' => 'کاربر ویرایش‌شده', 'email' => 'user@test.local',
            'role' => 'staff', 'username' => 'user-test', 'number' => '0700111222',
        ])->assertRedirect(route('users.userList'));
        $this->assertDatabaseHas('users', ['id' => $created->id, 'name' => 'کاربر ویرایش‌شده']);
    }

    public function test_announcement_kitchen_and_report_controllers_render_and_persist(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create();
        $this->resident($room);

        $this->actingAs($admin)->get(route('announcements.register'))->assertOk();
        $this->actingAs($admin)->get(route('announcements.list'))->assertOk();
        $this->actingAs($admin)->get(route('mealplan'))->assertOk();
        $this->actingAs($admin)->get(route('registerMealPlan'))->assertOk();
        $this->actingAs($admin)->get(route('mealFoods'))->assertOk();
        $this->actingAs($admin)->post(route('mealFoods.store'), [
            'name' => 'غذای تست', 'description' => 'توضیح', 'meal_type' => 'lunch',
        ])->assertRedirect(route('mealFoods'));
        $meal = Meal::firstOrFail();
        $this->actingAs($admin)->post(route('registerMealPlan/store'), [
            'meal_plan' => ['1' => ['breakfast' => $meal->id]],
        ])->assertRedirect(route('registerMealPlan'));
        $this->assertDatabaseHas('meal_schedules', ['day_of_week' => 1, 'meals_id' => $meal->id, 'status' => 'active']);

        $this->actingAs($admin)->get(route('reports.index'))->assertOk();
        $this->actingAs($admin)->get(route('report.resident_report'))->assertOk();
    }

    private function resident(Room $room, array $overrides = []): Resident
    {
        return Resident::factory()->create(array_merge(['room_id' => $room->id], $overrides));
    }

    private function residentData(Room $room, array $overrides = []): array
    {
        return array_merge([
            'resident_code' => 'RES-TEST', 'name' => 'ساکن تست', 'father_name' => 'پدر تست',
            'phone_number' => '0700000000', 'city_name' => 'کابل', 'occupation' => 'دانشجو',
            'work_phone' => '0700000001', 'occupation_location' => 'دانشگاه',
            'guarantor_name' => 'ضامن تست', 'guarantor_father_name' => 'پدر ضامن',
            'guarantor_phone' => '0700000002', 'guarantor_occupation' => 'کارمند',
            'guarantor_occupation_location' => 'شرکت', 'room_id' => $room->id,
        ], $overrides);
    }
}
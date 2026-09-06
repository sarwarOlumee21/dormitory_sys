<?php

namespace Tests\Feature;

use App\Models\MaintenanceRequest;
use App\Models\RequestType;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceControllerFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_maintenance_forms_are_available_to_authorized_roles(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->get(route('maintenance.request'))
            ->assertOk()
            ->assertViewIs('maintenance.maintenance_request')
            ->assertViewHas('rooms')
            ->assertViewHas('requestTypes');

        $this->actingAs($user)->get(route('maintenance.requestType'))
            ->assertOk()
            ->assertViewIs('maintenance.maintenance_request_type');
    }

    public function test_maintenance_forms_reject_guests_and_wrong_roles(): void
    {
        $this->get(route('maintenance.request'))->assertRedirect(route('login'));

        $student = User::factory()->create(['role' => 'student']);
        $this->actingAs($student)->get(route('maintenance.list'))->assertForbidden();
        $this->actingAs($student)->get(route('maintenance.follow_up_request'))->assertForbidden();
    }

    public function test_request_type_can_be_created_and_validation_is_enforced(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->post(route('maintenance.requestType.save'), [
            'name' => 'تعمیر آسانسور',
            'description' => 'خرابی تجهیزات',
        ])->assertRedirect(route('maintenance.request'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('request_types', [
            'name' => 'تعمیر آسانسور',
            'description' => 'خرابی تجهیزات',
        ]);

        $this->actingAs($user)->post(route('maintenance.requestType.save'), [])
            ->assertSessionHasErrors(['name']);
    }

    public function test_request_is_created_for_authenticated_user_even_when_user_id_is_spoofed(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $otherUser = User::factory()->create(['role' => 'user']);
        $room = Room::factory()->create();
        $requestType = RequestType::create(['name' => 'تعمیر']);

        $this->actingAs($user)->post(route('maintenance.request.save'), [
            'user_id' => $otherUser->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'priority' => 'زیاد',
            'description' => 'خرابی شیر آب',
        ])->assertRedirect(route('maintenance.request'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('maintenance_requests', [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'status' => 'جدید',
            'is_active' => 1,
        ]);
        $this->assertDatabaseMissing('maintenance_requests', ['user_id' => $otherUser->id]);
    }

    public function test_request_validation_rejects_unknown_relations_and_missing_fields(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->post(route('maintenance.request.save'), [
            'user_id' => $user->id,
            'room_id' => 99999,
            'request_types_id' => 99999,
        ])->assertSessionHasErrors(['room_id', 'request_types_id', 'priority']);
    }

    public function test_user_can_view_own_request_but_not_another_users_request(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $otherUser = User::factory()->create(['role' => 'user']);
        $room = Room::factory()->create();
        $requestType = RequestType::create(['name' => 'تعمیر']);
        $maintenanceRequest = MaintenanceRequest::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'priority' => 'متوسط',
            'status' => 'جدید',
            'is_active' => true,
        ]);

        $this->actingAs($user)->get(route('maintenance.show', $maintenanceRequest))
            ->assertOk()
            ->assertViewHas('isManager', false);

        $this->actingAs($otherUser)->get(route('maintenance.show', $maintenanceRequest))
            ->assertForbidden();
    }

    public function test_manager_can_update_request_and_read_notification(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $user = User::factory()->create(['role' => 'user']);
        $room = Room::factory()->create();
        $requestType = RequestType::create(['name' => 'تعمیر']);
        $maintenanceRequest = MaintenanceRequest::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'priority' => 'کم',
            'status' => 'جدید',
            'is_active' => true,
        ]);

        $this->actingAs($manager)->put(route('maintenance.updateDetails', $maintenanceRequest), [
            'status' => 'تکمیل شده',
            'admin_comment' => 'انجام شد',
        ])->assertRedirect(route('maintenance.show', $maintenanceRequest))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('maintenance_requests', [
            'id' => $maintenanceRequest->id,
            'status' => 'تکمیل شده',
            'admin_comment' => 'انجام شد',
            'is_active' => 0,
        ]);

        $this->actingAs($manager)->get(route('maintenance.notification.read', $maintenanceRequest))
            ->assertRedirect(route('maintenance.list'));
        $this->assertDatabaseHas('maintenance_requests', [
            'id' => $maintenanceRequest->id,
        ]);
        $this->assertNotNull($maintenanceRequest->fresh()->notification_read_at);
    }
}
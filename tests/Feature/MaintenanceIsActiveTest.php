<?php

namespace Tests\Feature;

use App\Models\MaintenanceRequest;
use App\Models\RequestType;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceIsActiveTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactive_requests_are_hidden_from_lists_and_disabled_when_status_is_finished_or_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $room = Room::factory()->create();
        $requestType = RequestType::create(['name' => 'تعمیر']);

        $activeRequest = MaintenanceRequest::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'priority' => 'متوسط',
            'description' => 'درخواست تعمیر برای تست',
            'status' => 'در حال بررسی',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('maintenance_requests', [
            'id' => $activeRequest->id,
            'is_active' => 1,
            'status' => 'در حال بررسی',
        ]);

        $this->assertSame(1, MaintenanceRequest::query()->where('is_active', true)->count());

        $this->actingAs($admin)
            ->put(route('maintenance.updateDetails', $activeRequest), [
                'status' => 'تکمیل شده',
                'admin_comment' => 'درخواست تکمیل شد.',
            ]);

        $activeRequest->refresh();

        $this->assertSame('تکمیل شده', $activeRequest->status);
        $this->assertSame(0, (int) $activeRequest->is_active);
        $this->assertSame(0, MaintenanceRequest::query()->where('is_active', true)->count());
        $this->assertDatabaseHas('maintenance_requests', [
            'id' => $activeRequest->id,
            'is_active' => 0,
            'status' => 'تکمیل شده',
        ]);
    }

    public function test_user_follow_up_page_displays_all_statuses_including_in_progress(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $room = Room::factory()->create();
        $requestType = RequestType::create(['name' => 'تعمیر']);

        MaintenanceRequest::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'priority' => 'متوسط',
            'description' => 'درخواست در حال پیگیری',
            'status' => 'جدید',
            'is_active' => true,
        ]);

        MaintenanceRequest::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'priority' => 'متوسط',
            'description' => 'درخواست تکمیل شده',
            'status' => 'تکمیل شده',
            'is_active' => false,
        ]);

        MaintenanceRequest::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'priority' => 'کم',
            'description' => 'درخواست رد شده',
            'status' => 'رد شد',
            'is_active' => false,
        ]);

        $responseInProgress = $this->actingAs($user)
            ->get(route('maintenance.follow_up_request', ['status' => 'در حال پیگیری']));
        $responseInProgress->assertOk();
        $responseInProgress->assertViewHas('maintenanceRequests', function ($requests) {
            return $requests->count() === 1 && in_array($requests->first()->status, ['جدید', 'در حال پیگیری', 'در حال بررسی'], true);
        });

        $responseDone = $this->actingAs($user)
            ->get(route('maintenance.follow_up_request', ['status' => 'تکمیل شده']));
        $responseDone->assertOk();
        $responseDone->assertViewHas('maintenanceRequests', function ($requests) {
            return $requests->count() === 1 && $requests->first()->status === 'تکمیل شده';
        });

        $responseRejected = $this->actingAs($user)
            ->get(route('maintenance.follow_up_request', ['status' => 'رد شد']));
        $responseRejected->assertOk();
        $responseRejected->assertViewHas('maintenanceRequests', function ($requests) {
            return $requests->count() === 1 && $requests->first()->status === 'رد شد';
        });

        $responseDone->assertViewHas('stats', function ($stats) {
            return $stats['in_progress'] === 1 && $stats['done'] === 1 && $stats['rejected'] === 1;
        });
    }

    public function test_admin_list_displays_all_statuses_including_in_progress(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $room = Room::factory()->create();
        $requestType = RequestType::create(['name' => 'تعمیر']);

        MaintenanceRequest::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'priority' => 'متوسط',
            'description' => 'درخواست در حال پیگیری مدیر',
            'status' => 'جدید',
            'is_active' => true,
        ]);

        MaintenanceRequest::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'priority' => 'متوسط',
            'description' => 'درخواست تکمیل شده مدیر',
            'status' => 'تکمیل شده',
            'is_active' => false,
        ]);

        MaintenanceRequest::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'priority' => 'کم',
            'description' => 'درخواست رد شده مدیر',
            'status' => 'رد شد',
            'is_active' => false,
        ]);

        $responseInProgress = $this->actingAs($admin)
            ->get(route('maintenance.list', ['status' => 'در حال پیگیری']));
        $responseInProgress->assertOk();
        $responseInProgress->assertViewHas('maintenanceRequests', function ($requests) {
            return $requests->count() === 1 && in_array($requests->first()->status, ['جدید', 'در حال پیگیری', 'در حال بررسی'], true);
        });

        $responseDone = $this->actingAs($admin)
            ->get(route('maintenance.list', ['status' => 'تکمیل شده']));
        $responseDone->assertOk();
        $responseDone->assertViewHas('maintenanceRequests', function ($requests) {
            return $requests->count() === 1 && $requests->first()->status === 'تکمیل شده';
        });

        $responseRejected = $this->actingAs($admin)
            ->get(route('maintenance.list', ['status' => 'رد شد']));
        $responseRejected->assertOk();
        $responseRejected->assertViewHas('maintenanceRequests', function ($requests) {
            return $requests->count() === 1 && $requests->first()->status === 'رد شد';
        });
    }
}

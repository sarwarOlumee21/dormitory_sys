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
                'status' => 'تأیید شد',
                'admin_comment' => 'درخواست تایید شد.',
            ]);

        $activeRequest->refresh();

        $this->assertSame('تأیید شد', $activeRequest->status);
        $this->assertSame(0, (int) $activeRequest->is_active);
        $this->assertSame(0, MaintenanceRequest::query()->where('is_active', true)->count());
        $this->assertDatabaseHas('maintenance_requests', [
            'id' => $activeRequest->id,
            'is_active' => 0,
            'status' => 'تأیید شد',
        ]);
    }
}

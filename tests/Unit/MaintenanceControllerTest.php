<?php

namespace Tests\Unit;

use App\Http\Controllers\MaintenanceController;
use App\Models\MaintenanceRequest;
use App\Models\RequestType;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class MaintenanceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_details_deactivates_completed_and_rejected_requests(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $maintenanceRequest = $this->makeRequest($admin);
        $controller = new MaintenanceController();

        $controller->updateDetails(Request::create('/', 'PUT', [
            'status' => 'رد شد',
            'admin_comment' => 'نیاز به تعویض کامل دارد',
        ]), $maintenanceRequest);

        $this->assertDatabaseHas('maintenance_requests', [
            'id' => $maintenanceRequest->id,
            'status' => 'رد شد',
            'admin_comment' => 'نیاز به تعویض کامل دارد',
            'is_active' => 0,
        ]);
    }

    public function test_update_details_keeps_non_terminal_requests_active(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);
        $this->actingAs($staff);
        $maintenanceRequest = $this->makeRequest($staff);
        $controller = new MaintenanceController();

        $controller->updateDetails(Request::create('/', 'PUT', [
            'status' => 'در حال بررسی',
        ]), $maintenanceRequest);

        $this->assertDatabaseHas('maintenance_requests', [
            'id' => $maintenanceRequest->id,
            'status' => 'در حال بررسی',
            'is_active' => 1,
        ]);
    }

    public function test_update_details_is_restricted_to_managerial_roles(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $maintenanceRequest = $this->makeRequest($user);
        $controller = new MaintenanceController();

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $controller->updateDetails(Request::create('/', 'PUT', ['status' => 'تکمیل شده']), $maintenanceRequest);
    }

    private function makeRequest(User $user): MaintenanceRequest
    {
        $room = Room::factory()->create();
        $requestType = RequestType::create(['name' => 'تعمیر']);

        return MaintenanceRequest::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'request_types_id' => $requestType->id,
            'priority' => 'متوسط',
            'status' => 'جدید',
            'is_active' => true,
        ]);
    }
}
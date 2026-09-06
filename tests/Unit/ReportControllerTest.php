<?php

namespace Tests\Unit;

use App\Models\ContractRegister;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Visitors;
use App\Models\payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_calculates_payment_statuses_totals_and_latest_payment_data(): void
    {
        $room = Room::factory()->create(['room_number' => '501', 'capacity' => 3]);
        $full = $this->resident($room, 'R-FULL', 'رضا کامل');
        $partial = $this->resident($room, 'R-PARTIAL', 'سارا ناقص');
        $none = $this->resident($room, 'R-NONE', 'مریم بدون پرداخت');

        $this->contract($full, 1000);
        $this->contract($partial, 1000);
        $this->contract($none, 1000);
        $this->payment($full, 1000, '2026-09-05');
        $this->payment($partial, 400, '2026-09-10');
        $this->payment($partial, 100, '2026-08-10');

        $response = $this->withoutMiddleware()->get('/reports?month=2026-09');

        $response->assertOk()->assertViewIs('reports.index');
        $response->assertViewHas('items', function ($items) use ($full, $partial, $none) {
            $byId = collect($items)->keyBy('id');

            return $byId[$full->id]['status'] === 'full'
                && $byId[$partial->id]['status'] === 'partial'
                && $byId[$none->id]['status'] === 'none'
                && $byId[$partial->id]['paid'] === 400.0
                && $byId[$partial->id]['remaining'] === 600.0
                && $byId[$partial->id]['payment_count'] === 2
                && $byId[$partial->id]['last_payment_date'] === '2026-09-10';
        });
        $response->assertViewHas('totals', [
            'contracts' => 3000.0,
            'paid' => 1400.0,
            'remaining' => 1600.0,
        ]);
        $response->assertViewHas('counts', ['full' => 1, 'partial' => 1, 'none' => 1]);
        $response->assertViewHas('month', '2026-09');
    }

    public function test_index_applies_name_code_and_payment_status_filters(): void
    {
        $room = Room::factory()->create();
        $matching = $this->resident($room, 'R-MATCH', 'فرد مورد نظر');
        $other = $this->resident($room, 'R-OTHER', 'فرد دیگر');
        $this->contract($matching, 500);
        $this->contract($other, 500);
        $this->payment($matching, 500, '2026-09-01');

        $response = $this->withoutMiddleware()->get('/reports?month=2026-09&name=مورد&code=R-MATCH&payment_status=full');

        $response->assertOk()->assertViewHas('items', function ($items) use ($matching) {
            return count($items) === 1
                && $items[0]['id'] === $matching->id
                && $items[0]['status'] === 'full';
        });
        $response->assertViewHas('totalResults', 1);
    }

    public function test_index_uses_latest_payment_month_when_month_is_missing(): void
    {
        $room = Room::factory()->create();
        $resident = $this->resident($room, 'R-LATEST', 'پرداخت اخیر');
        $this->contract($resident, 700);
        $this->payment($resident, 700, '2026-07-18');

        $this->withoutMiddleware()->get('/reports')
            ->assertOk()
            ->assertViewHas('month', '2026-07');
    }

    public function test_resident_report_supports_person_type_and_room_status_filters(): void
    {
        $fullRoom = Room::factory()->create(['room_number' => '601', 'capacity' => 1]);
        $availableRoom = Room::factory()->create(['room_number' => '602', 'capacity' => 2]);
        $emptyRoom = Room::factory()->create(['room_number' => '603', 'capacity' => 2]);
        $resident = $this->resident($fullRoom, 'R-RESIDENT', 'ساکن گزارش');
        $guest = Visitors::create([
            'resident_id' => $resident->id,
            'guest_name' => 'مهمان گزارش',
            'guest_id_number' => 'G-REPORT',
            'room_number' => $availableRoom->room_number,
            'check_in_at' => '2026-09-02 10:00:00',
            'attendance_status' => 'داخل خوابگاه',
        ]);

        $residentResponse = $this->withoutMiddleware()->get('/report.resident_report?person_type=resident&room_status=full');
        $residentResponse->assertOk()->assertViewHas('items', function ($items) use ($resident) {
            return count($items) === 1 && $items[0]['type'] === 'resident' && $items[0]['code'] === $resident->resident_code;
        });
        $residentResponse->assertViewHas('totals', ['residents' => 1, 'guests' => 0, 'people' => 1]);
        $residentResponse->assertViewHas('roomTotals', ['total' => 3, 'full' => 1, 'available' => 2]);

        $guestResponse = $this->withoutMiddleware()->get('/report.resident_report?person_type=guest&name=مهمان&date_from=2026-09-01&date_to=2026-09-03');
        $guestResponse->assertOk()->assertViewHas('items', function ($items) use ($guest) {
            return count($items) === 1 && $items[0]['type'] === 'guest' && $items[0]['code'] === $guest->guest_id_number;
        });
        $guestResponse->assertViewHas('totals', ['residents' => 0, 'guests' => 1, 'people' => 1]);
        $this->assertNotNull($emptyRoom->id);
    }

    public function test_report_routes_are_restricted_to_management_roles(): void
    {
        $this->get('/reports')->assertRedirect(route('login'));

        $user = \App\Models\User::factory()->create(['role' => 'user']);
        $this->actingAs($user)->get('/reports')->assertForbidden();
        $this->actingAs($user)->get('/report.resident_report')->assertForbidden();
    }

    private function resident(Room $room, string $code, string $name): Resident
    {
        return Resident::create([
            'resident_code' => $code,
            'name' => $name,
            'room_id' => $room->id,
            'status' => 'فعال',
        ]);
    }

    private function contract(Resident $resident, float $amount): ContractRegister
    {
        return ContractRegister::create([
            'resident_id' => $resident->id,
            'contract_date' => '2026-09-01',
            'contract_amount' => $amount,
            'contract_status' => 'فعال',
        ]);
    }

    private function payment(Resident $resident, float $amount, string $date): payment
    {
        return payment::create([
            'residents_id' => $resident->id,
            'amount' => $amount,
            'payment_date' => $date,
        ]);
    }
}
<?php

namespace Tests\Feature;

use App\Models\ContractRegister;
use App\Models\Resident;
use App\Models\Room;
use App\Models\User;
use App\Models\payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\PaymentHistory;
use Tests\TestCase;

class PaymentHistoryDemoTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_starts_empty_and_livewire_selection_loads_database_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create(['room_number' => '101']);
        $resident = Resident::factory()->create([
            'name' => 'احمد محمدی',
            'resident_code' => 'RES-1001',
            'room_id' => $room->id,
        ]);
        $contract = ContractRegister::create([
            'resident_id' => $resident->id,
            'contract_date' => '2026-08-01',
            'contract_amount' => 5000,
        ]);
        payment::create([
            'residents_id' => $resident->id,
            'amount' => 3000,
            'payment_date' => '2026-08-10',
        ]);

        $this->actingAs($admin)->get(route('report.payments_history'))
            ->assertOk()
            ->assertViewIs('reports.payment_history_demo')
            ->assertSee('برای نمایش گزارش، ابتدا یک ساکن را جستجو و انتخاب کنید.')
            ->assertDontSee('CON-' . str_pad((string) $contract->id, 5, '0', STR_PAD_LEFT));

        Livewire::test(PaymentHistory::class)
            ->assertSet('selectedResidentId', null)
            ->set('search', 'RES-1001')
            ->assertSee('احمد محمدی')
            ->call('selectResident', $resident->id)
            ->assertSet('search', '')
            ->assertSet('selectedResidentId', $resident->id)
            ->assertSee('CON-' . str_pad((string) $contract->id, 5, '0', STR_PAD_LEFT))
            ->assertSee('2,000 افغانی');
    }

    public function test_livewire_payment_history_can_switch_to_another_resident(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $room = Room::factory()->create();
        $first = Resident::factory()->create(['room_id' => $room->id]);
        $second = Resident::factory()->create(['name' => 'سارا احمدی', 'room_id' => $room->id]);
        ContractRegister::create(['resident_id' => $first->id, 'contract_date' => '2026-08-01', 'contract_amount' => 1000]);
        ContractRegister::create(['resident_id' => $second->id, 'contract_date' => '2026-08-01', 'contract_amount' => 5000]);
        payment::create(['residents_id' => $second->id, 'amount' => 2500, 'payment_date' => '2026-08-10']);

        $this->actingAs($manager);
        Livewire::test(PaymentHistory::class)
            ->set('search', 'سارا')
            ->assertSee('سارا احمدی')
            ->call('selectResident', $second->id)
            ->assertSee('سارا احمدی')
            ->assertSee('2,500 افغانی');
    }

    public function test_payment_history_requires_management_access(): void
    {
        $this->get(route('report.payments_history'))->assertRedirect(route('login'));

        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user)->get(route('report.payments_history'))->assertForbidden();
    }

    public function test_payment_history_allocates_payments_across_all_contracts(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create();
        $resident = Resident::factory()->create(['room_id' => $room->id]);
        $firstContract = ContractRegister::create([
            'resident_id' => $resident->id,
            'contract_date' => '2026-01-01',
            'contract_amount' => 5000,
        ]);
        $secondContract = ContractRegister::create([
            'resident_id' => $resident->id,
            'contract_date' => '2026-02-01',
            'contract_amount' => 5000,
        ]);
        payment::create(['residents_id' => $resident->id, 'amount' => 3000, 'payment_date' => '2026-01-10']);
        payment::create(['residents_id' => $resident->id, 'amount' => 4000, 'payment_date' => '2026-02-10']);

        $this->actingAs($admin);
        Livewire::test(PaymentHistory::class)
            ->call('selectResident', $resident->id)
            ->assertViewHas('invoices', function ($invoices) use ($firstContract, $secondContract) {
                $invoices = collect($invoices)->keyBy('invoice');

                return $invoices['CON-' . str_pad((string) $firstContract->id, 5, '0', STR_PAD_LEFT)]['paid'] == 5000
                    && $invoices['CON-' . str_pad((string) $firstContract->id, 5, '0', STR_PAD_LEFT)]['balance'] == 0
                    && $invoices['CON-' . str_pad((string) $secondContract->id, 5, '0', STR_PAD_LEFT)]['paid'] == 2000
                    && $invoices['CON-' . str_pad((string) $secondContract->id, 5, '0', STR_PAD_LEFT)]['balance'] == 3000;
            });
    }
}
<?php

namespace Tests\Feature;

use App\Models\Resident;
use App\Models\payment;
use Tests\TestCase;

class PaymentStoreTest extends TestCase
{
    public function test_payment_can_be_saved_with_resident_id(): void
    {
        $resident = Resident::create([
            'name' => 'Test Resident',
            'guarantor_occupation_location' => 'Test Address',
        ]);

        $response = $this->withoutMiddleware()->post('/contracts/payment/store', [
            'resident_id' => $resident->id,
            'amount' => 2500,
            'payment_date' => '2026-07-05',
            'notes' => 'Test payment',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('payments', [
            'residents_id' => $resident->id,
            'amount' => '2500.00',
            'notes' => 'Test payment',
        ]);
    }
}

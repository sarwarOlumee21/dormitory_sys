<?php

namespace App\Livewire;

use App\Models\ContractRegister;
use App\Models\Resident;
use App\Models\payment;
use Carbon\Carbon;
use Livewire\Component;

class PaymentHistory extends Component
{
    public string $search = '';

    public ?int $selectedResidentId = null;

    public function selectResident(int $residentId): void
    {
        $this->selectedResidentId = $residentId;
        $this->search = '';
    }

    public function clearSelection(): void
    {
        $this->selectedResidentId = null;
    }

    public function render()
    {
        $residents = collect();

        if (trim($this->search) !== '') {
            $keyword = '%' . trim($this->search) . '%';
            $residents = Resident::with('room')
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', $keyword)
                        ->orWhere('resident_code', 'like', $keyword)
                        ->orWhereHas('room', fn ($roomQuery) => $roomQuery->where('room_number', 'like', $keyword));
                })
                ->orderBy('name')
                ->limit(10)
                ->get();
        }

        $selectedResident = null;
        $invoices = collect();
        $summary = ['total' => 0, 'paid' => 0, 'balance' => 0];

        if ($this->selectedResidentId) {
            $resident = Resident::with(['room', 'contracts' => function ($query) {
                $query->orderBy('contract_date')->orderBy('id');
            }])->find($this->selectedResidentId);

            if ($resident) {
                $payments = payment::where('residents_id', $resident->id)
                    ->orderBy('payment_date')->orderBy('id')->get();
                $remainingPayments = $payments->map(fn ($item) => [
                    'amount' => (float) $item->amount,
                    'date' => $item->payment_date,
                ])->values();

                $invoices = $resident->contracts->map(function ($contract) use ($remainingPayments) {
                    $total = (float) $contract->contract_amount;
                    $paid = 0;
                    $paidAt = null;

                    foreach ($remainingPayments as $paymentIndex => $paymentItem) {
                        if ($paymentItem['amount'] <= 0 || $paid >= $total) {
                            continue;
                        }

                        $allocated = min($paymentItem['amount'], $total - $paid);
                        $paid += $allocated;
                        $remainingPayments->put($paymentIndex, [
                            'amount' => $paymentItem['amount'] - $allocated,
                            'date' => $paymentItem['date'],
                        ]);
                        $paidAt = $paymentItem['date'];
                    }

                    $balance = max(0, $total - $paid);

                    return [
                        'period' => $contract->contract_date ? Carbon::parse($contract->contract_date)->format('Y-m') : '-',
                        'invoice' => 'CON-' . str_pad((string) $contract->id, 5, '0', STR_PAD_LEFT),
                        'total' => $total,
                        'paid' => $paid,
                        'balance' => $balance,
                        'paid_at' => $paidAt,
                        'status' => $balance === 0 ? 'پرداخت کامل' : ($paid > 0 ? 'پرداخت ناقص' : 'پرداخت نشده'),
                    ];
                })->values();

                $summary = [
                    'total' => $invoices->sum('total'),
                    'paid' => $payments->sum('amount'),
                    'balance' => max(0, $invoices->sum('total') - $payments->sum('amount')),
                ];

                $selectedResident = [
                    'id' => $resident->id,
                    'name' => $resident->name,
                    'code' => $resident->resident_code,
                    'room' => $resident->room?->room_number ?? '-',
                ];
            }
        }

        return view('livewire.payment-history', compact('residents', 'selectedResident', 'invoices', 'summary'));
    }
}

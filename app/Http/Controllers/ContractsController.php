<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\ContractRules;
use App\Models\Room;
use App\Models\Resident;
use App\Models\ContractRegister;
use App\Models\payment;

class ContractsController extends Controller
{
    public function ContractsRegister(Request $request)
    {
        $residents = Resident::all();
        $rooms = Room::all();
        return view('contracts.contracts_register', compact('rooms'), compact('residents'));
    }

    public function ContractsRules(Request $request)
    {
        return view('contracts.contracts_rules');
    }


    public function contractStore(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'resident_id' => 'required|exists:residents,id',
            'contract_date' => 'required|date',
            'contract_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        if (!$validatedData) {
            return redirect()->back()->with('error', 'Invalid data. Please check your input.');
        }
        $store = ContractRegister::create($validatedData);
        if (!$store) {
            return redirect()->back()->with('error', 'Failed to register contract. Please try again.');
        }
        return redirect()->back()->with('success', 'Contract registered successfully.');

        // Logic for storing the contract would go here
    }

    public function ContractsList()
    {
        $contracts = ContractRegister::with(['room', 'resident'])->simplePaginate(10);

        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();

        $paymentQuery = payment::query()->whereBetween('payment_date', [$startOfMonth, $endOfMonth]);

        if (Schema::hasColumn('payments', 'residents_id') && Schema::hasColumn('payments', 'resident_id')) {
            $paymentQuery->selectRaw("CASE WHEN residents_id IS NOT NULL THEN residents_id ELSE resident_id END as resident_key, SUM(amount) as total_amount")
                ->groupByRaw("CASE WHEN residents_id IS NOT NULL THEN residents_id ELSE resident_id END");
        } elseif (Schema::hasColumn('payments', 'residents_id')) {
            $paymentQuery->selectRaw('residents_id as resident_key, SUM(amount) as total_amount')
                ->groupBy('residents_id');
        } elseif (Schema::hasColumn('payments', 'resident_id')) {
            $paymentQuery->selectRaw('resident_id as resident_key, SUM(amount) as total_amount')
                ->groupBy('resident_id');
        } else {
            $paymentQuery->selectRaw('0 as resident_key, SUM(amount) as total_amount')
                ->groupBy('resident_key');
        }

        $paymentTotals = $paymentQuery->pluck('total_amount', 'resident_key');

        return view('contracts.contracts_list', compact('contracts', 'paymentTotals'));
    }
    public function storeRules(Request $request)
    {
        $validatedData = $request->validate([
            'contract_rules' => 'required|string',
        ]);
        $contractRules = ContractRules::create($validatedData);
        if (!$contractRules) {
            return redirect()->back()->with('error', 'Failed to save contract rules. Please try again.');
        }


        return redirect()->back()->with('success', 'Contract rules saved successfully.');
    }


    public function storePayment(Request $request)
    {
        $validatedData = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $paymentData = [
            'amount' => $validatedData['amount'],
            'payment_date' => $validatedData['payment_date'],
            'notes' => $validatedData['notes'] ?? null,
        ];

        if (Schema::hasColumn('payments', 'residents_id')) {
            $paymentData['residents_id'] = $validatedData['resident_id'];
        }

        if (Schema::hasColumn('payments', 'resident_id')) {
            $paymentData['resident_id'] = $validatedData['resident_id'];
        }

        $pay = payment::create($paymentData);
        if (!$pay) {
            return redirect()->back()->with('error', 'Failed to record payment. Please try again.');
        }

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }
}
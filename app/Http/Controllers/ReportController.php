<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\payment;
use App\Models\Resident;
use App\Models\ContractRegister;
use App\Models\Visitors;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // گرفتن اطلاعات فیلتر از URL
        $name = $request->get('name');
        $code = $request->get('code');
        $month = $request->get('month'); // expect YYYY-MM
        $payment_status = $request->get('payment_status'); // full|partial|none

        // if month not provided, use latest payment month in DB
        if (empty($month)) {
            $latestDate = payment::whereNotNull('payment_date')->orderBy('payment_date', 'desc')->value('payment_date');
            if ($latestDate) {
                $month = Carbon::parse($latestDate)->format('Y-m');
            } else {
                $month = Carbon::now()->format('Y-m');
            }
        }

        // build residents query with optional filters
        $residentsQuery = Resident::with(['room', 'latestContract']);

        if (!empty($name)) {
            $residentsQuery->where('name', 'like', "%{$name}%");
        }

        if (!empty($code)) {
            $residentsQuery->where('resident_code', 'like', "%{$code}%");
        }

        $residents = $residentsQuery->get();

        // determine payments resident key column (residents_id OR resident_id)
        if (Schema::hasColumn('payments', 'residents_id')) {
            $payKey = 'residents_id';
        } elseif (Schema::hasColumn('payments', 'resident_id')) {
            $payKey = 'resident_id';
        } else {
            $payKey = 'residents_id';
        }

        // aggregate payments for selected month
        try {
            [$y, $m] = explode('-', $month);
        } catch (\Throwable $e) {
            $y = Carbon::now()->format('Y');
            $m = Carbon::now()->format('m');
        }
        $paymentsQuery = payment::selectRaw("{$payKey} as resident_key, SUM(amount) as paid")
            ->groupBy($payKey)
            ->whereYear('payment_date', $y)
            ->whereMonth('payment_date', $m);

        $payments = $paymentsQuery->pluck('paid', 'resident_key')->toArray();

        $items = [];
        $totals = ['contracts' => 0, 'paid' => 0, 'remaining' => 0];
        $counts = ['full' => 0, 'partial' => 0, 'none' => 0];

        foreach ($residents as $r) {
            $contract = $r->latestContract;
            $contract_amount = $contract ? (float) $contract->contract_amount : 0;
            $paid = 0;
            // payments key might be null/0 if none
            $key = $r->id;
            if (isset($payments[$key])) {
                $paid = (float) $payments[$key];
            }

            $remaining = $contract_amount - $paid;

            $status = 'none';
            if ($contract_amount > 0 && $paid >= $contract_amount) {
                $status = 'full';
            } elseif ($paid > 0 && $paid < $contract_amount) {
                $status = 'partial';
            }

            $totals['contracts'] += $contract_amount;
            $totals['paid'] += $paid;
            $totals['remaining'] += max(0, $remaining);
            $counts[$status]++;

            $items[] = [
                'id' => $r->id,
                'name' => $r->name,
                'resident_code' => $r->resident_code,
                'room_number' => $r->room ? $r->room->room_number : null,
                'contract_amount' => $contract_amount,
                'paid' => $paid,
                'remaining' => max(0, $remaining),
                'status' => $status,
                'payment_count' => $r->payments->count(),
                'last_payment_date' => $r->payments->max('payment_date'),
            ];
        }

        // apply payment_status filter (full|partial|none)
        if (!empty($payment_status) && in_array($payment_status, ['full', 'partial', 'none'])) {
            $items = array_values(array_filter($items, function ($it) use ($payment_status) {
                return $it['status'] === $payment_status;
            }));
        }

        $totalResults = count($items);

        return view('reports.index', compact('items', 'totals', 'counts', 'totalResults', 'name', 'code', 'month', 'payment_status'));
    }
    // public function residentReport()
    // {
    //     // Sample data for the resident report
    //     $residents = [
    //         ['name' => 'علی رضایی', 'room' => '۱۰۱', 'status' => 'فعال', 'last_payment' => '۱۴۰۴/۰۶/۰۵'],
    //         ['name' => 'سارا احمدی', 'room' => '۱۰۲', 'status' => 'قرارداد جاری', 'last_payment' => '۱۴۰۴/۰۶/۰۳'],
    //         ['name' => 'مریم صفری', 'room' => '۱۰۵', 'status' => 'فعال', 'last_payment' => '۱۴۰۴/۰۶/۰۷'],
    //         ['name' => 'مهدی صادقی', 'room' => '۱۰۸', 'status' => 'جدید', 'last_payment' => '۱۴۰۴/۰۶/۰۱'],
    //     ];

    //     return view('reports.resident_reports', compact('residents'));
    // }
    // public function paymentReport()
    // {
    //     // Sample data for the payment report
    //     $payments = [
    //         ['resident' => 'علی رضایی', 'month' => 'حمل ۱۴۰۴', 'amount' => '۱۵۶,۰۰۰', 'status' => 'پرداخت شده'],
    //         ['resident' => 'سارا احمدی', 'month' => 'جوزا ۱۴۰۴', 'amount' => '۱۶۸,۰۰۰', 'status' => 'پرداخت شده'],
    //         ['resident' => 'مریم صفری', 'month' => 'سرطان ۱۴۰۴', 'amount' => '۱۴۲,۰۰۰', 'status' => 'معوق'],
    //         ['resident' => 'مهدی صادقی', 'month' => 'اسد ۱۴۰۴', 'amount' => '۱۳۸,۰۰۰', 'status' => 'در حال بررسی'],
    //     ];

    //     return view('reports.payment_reports', compact('payments'));
    // }
}

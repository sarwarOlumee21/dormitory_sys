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
use App\Models\Room;

class ReportController extends Controller
{
    public function paymentHistory(Request $request)
    {
        return view('reports.payment_history_demo');
    }

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
    public function residentReport(Request $request)
    {
        $personType = $request->get('person_type');
        $nameFilter = $request->get('name');
        $roomNumberFilter = $request->get('room_number');
        $roomStatusFilter = $request->get('room_status');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $residents = Resident::with(['room', 'latestContract'])->get();
        $rooms = Room::all();

        $roomCount = $rooms->count();
        $allGuestCount = Visitors::whereNull('check_out_at')->count();

        $residentItems = $residents->filter(function ($resident) use ($nameFilter, $roomNumberFilter, $personType, $dateFrom, $dateTo) {
            if (!empty($nameFilter) && stripos($resident->name, $nameFilter) === false) {
                return false;
            }

            if (!empty($roomNumberFilter) && ($resident->room?->room_number ?? '') !== (string) $roomNumberFilter) {
                return false;
            }

            if (!empty($dateFrom) && ($resident->created_at?->format('Y-m-d') < $dateFrom)) {
                return false;
            }

            if (!empty($dateTo) && ($resident->created_at?->format('Y-m-d') > $dateTo)) {
                return false;
            }

            return $personType !== 'guest';
        })->map(function ($resident) {
            $room = $resident->room;
            $roomCapacity = $room?->capacity ?? 0;
            $roomOccupied = $room ? $room->residents()->count() : 0;

            return [
                'name' => $resident->name,
                'type' => 'resident',
                'code' => $resident->resident_code,
                'room_number' => $room?->room_number,
                'room_capacity' => $roomCapacity,
                'room_occupied' => $roomOccupied,
                'check_in_date' => $resident->created_at?->format('Y-m-d'),
                'phone' => $resident->phone_number,
                'resident_code' => $resident->resident_code,
            ];
        })->values()->all();

        $guestItems = Visitors::with('resident', 'room')->whereNull('check_out_at')->get()->filter(function ($visitor) use ($nameFilter, $roomNumberFilter, $personType, $dateFrom, $dateTo) {
            $name = $visitor->guest_name ?? '';
            $roomNumber = $visitor->room_number ?? $visitor->resident?->room?->room_number;
            $visitDate = $visitor->check_in_at?->format('Y-m-d');

            if (!empty($nameFilter) && stripos($name, $nameFilter) === false) {
                return false;
            }

            if (!empty($roomNumberFilter) && (string) $roomNumber !== (string) $roomNumberFilter) {
                return false;
            }

            if (!empty($dateFrom) && $visitDate < $dateFrom) {
                return false;
            }

            if (!empty($dateTo) && $visitDate > $dateTo) {
                return false;
            }

            return $personType !== 'resident';
        })->map(function ($visitor) {
            $room = $visitor->room;
            $roomCapacity = $room?->capacity ?? 0;
            $roomOccupied = $room ? $room->residents()->count() : 0;

            return [
                'name' => $visitor->guest_name,
                'type' => 'guest',
                'code' => $visitor->guest_id_number,
                'room_number' => $visitor->room_number ?? $visitor->resident?->room?->room_number,
                'room_capacity' => $roomCapacity,
                'room_occupied' => $roomOccupied,
                'check_in_date' => $visitor->check_in_at?->format('Y-m-d'),
                'phone' => $visitor->guest_phone,
                'guest_code' => $visitor->guest_id_number,
            ];
        })->values()->all();

        $filteredItems = match ($personType) {
            'resident' => $residentItems,
            'guest' => $guestItems,
            default => array_merge($residentItems, $guestItems),
        };

        $residentCount = $personType === 'guest' ? 0 : count($residentItems);
        $guestCount = $personType === 'resident' ? 0 : count($guestItems);

        $totals = [
            'residents' => $residentCount,
            'guests' => $guestCount,
            'people' => $residentCount + $guestCount,
        ];

        $roomTotals = [
            'total' => $roomCount,
            'full' => $rooms->filter(function ($room) {
                $occupied = $room->residents()->count();
                return $room->capacity > 0 && $occupied >= $room->capacity;
            })->count(),
            'available' => $rooms->filter(function ($room) {
                $occupied = $room->residents()->count();
                return $room->capacity > 0 && $occupied < $room->capacity;
            })->count(),
        ];

        if ($roomStatusFilter === 'full' || $roomStatusFilter === 'available' || $roomStatusFilter === 'empty') {
            $filteredItems = array_values(array_filter($filteredItems, function ($item) use ($roomStatusFilter) {
                $occupied = $item['room_occupied'] ?? 0;
                $capacity = $item['room_capacity'] ?? 0;

                if ($roomStatusFilter === 'full') {
                    return $capacity > 0 && $occupied >= $capacity;
                }

                if ($roomStatusFilter === 'available') {
                    return $capacity > 0 && $occupied < $capacity && $occupied > 0;
                }

                return $capacity > 0 && $occupied === 0;
            }));
        }

        $totalResults = count($filteredItems);
        $reportDate = now()->format('Y-m-d');

        return view('reports.resident_report', compact(
            'residents',
            'rooms',
            'roomCount',
            'totals',
            'roomTotals',
            'totalResults',
            'reportDate',
            'personType',
            'nameFilter',
            'roomNumberFilter',
            'roomStatusFilter'
        ))->with('items', $filteredItems)
          ->with('residentCount', $residentCount)
          ->with('guestCount', $guestCount)
          ->with('allGuestCount', $allGuestCount)
          ->with('person_type', $personType)
          ->with('name', $nameFilter)
          ->with('room_number', $roomNumberFilter)
          ->with('room_status', $roomStatusFilter)
          ->with('date_from', $dateFrom)
          ->with('date_to', $dateTo);
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

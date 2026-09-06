<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestType;
use App\Models\Room;
use App\Models\Resident;
use App\Models\MaintenanceRequest;

class MaintenanceController extends Controller
{
    public function maintenanceRequest()
    {
        $rooms = Room::all();
        $requestTypes = RequestType::all();

        return view('maintenance.maintenance_request', compact('rooms', 'requestTypes'));
    }

    public function requestType()
    {
        return view('maintenance.maintenance_request_type');
    }

    public function saveRequestType(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:600',
        ]);
       $save = RequestType::create($data);
       
        if ($save) {
            $request->session()->flash('success', 'نوع درخواست با موفقیت ثبت شد.');
        } else {
            $request->session()->flash('error', 'خطا در ثبت نوع درخواست.');
        }

        return redirect()->route('maintenance.request');

    }
    public function saveRequest(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'request_types_id' => 'required|exists:request_types,id',
            'priority' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
        ]);

        $data['user_id'] = auth()->id();

        $save = MaintenanceRequest::create($data);
        if ($save) {
            $request->session()->flash('success', 'درخواست تعمیر با موفقیت ثبت شد.');
        } else {
            $request->session()->flash('error', 'خطا در ثبت درخواست تعمیر.');
        }

        return redirect()->route('maintenance.request');
    }

    public function list(Request $request)
    {
        $selectedStatus = $request->get('status', 'در حال پیگیری');
        $allowedStatuses = ['در حال پیگیری', 'تکمیل شده', 'رد شد'];

        if (!in_array($selectedStatus, $allowedStatuses, true)) {
            $selectedStatus = 'در حال پیگیری';
        }

        $statusValues = match ($selectedStatus) {
            'در حال پیگیری' => ['جدید', 'در حال پیگیری', 'در حال بررسی'],
            'تکمیل شده' => ['تکمیل شده'],
            'رد شد' => ['رد شد'],
            default => ['جدید', 'در حال پیگیری', 'در حال بررسی'],
        };

        $maintenanceRequests = MaintenanceRequest::with(['user', 'requestType', 'room'])
            ->whereIn('status', $statusValues)
            ->when($selectedStatus === 'در حال پیگیری', function ($query) {
                $query->where('is_active', true);
            }, function ($query) {
                $query->where(function ($innerQuery) {
                    $innerQuery->where('is_active', true)
                        ->orWhereIn('status', ['تکمیل شده', 'رد شد']);
                });
            })
            ->orderByDesc('created_at')
            ->get();

        return view('maintenance.maintenance_list', compact('maintenanceRequests', 'selectedStatus'));
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->load(['user', 'requestType', 'room']);
        $isManager = in_array(auth()->user()->role, ['admin', 'manager', 'staff']);

        abort_unless($isManager || $maintenanceRequest->user_id === auth()->id(), 403);

        return view('maintenance.request_show', compact('maintenanceRequest', 'isManager'));
    }

    public function updateDetails(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        abort_unless(in_array(auth()->user()->role, ['admin', 'manager', 'staff']), 403);

        $validated = $request->validate([
            'status' => 'required|string|max:50',
            'admin_comment' => 'nullable|string|max:2000',
        ]);

        $status = $validated['status'];
        $validated['is_active'] = in_array($status, ['تکمیل شده', 'رد شد'], true) ? false : true;

        $maintenanceRequest->update($validated);

        return redirect()->route('maintenance.show', $maintenanceRequest)
            ->with('success', 'وضعیت و کامنت درخواست ذخیره شد.');
    }

    public function markNotificationRead(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->update([
            'notification_read_at' => now(),
        ]);

        return redirect()->route('maintenance.list');
    }

    public function follow_up(Request $request)
    {
        $userId = auth()->id();
        $selectedStatus = $request->get('status', 'در حال پیگیری');
        $allowedStatuses = ['در حال پیگیری', 'تکمیل شده', 'رد شد'];

        if (!in_array($selectedStatus, $allowedStatuses, true)) {
            $selectedStatus = 'در حال پیگیری';
        }

        $statusValues = match ($selectedStatus) {
            'در حال پیگیری' => ['جدید', 'در حال پیگیری', 'در حال بررسی'],
            'تکمیل شده' => ['تکمیل شده'],
            'رد شد' => ['رد شد'],
            default => ['جدید', 'در حال پیگیری', 'در حال بررسی'],
        };

        $maintenanceRequests = MaintenanceRequest::with(['user', 'requestType', 'room'])
            ->when($userId, function ($query, $userId) {
                $query->where('user_id', $userId);
            }, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->whereIn('status', $statusValues)
            ->when($selectedStatus === 'در حال پیگیری', function ($query) {
                $query->where('is_active', true);
            }, function ($query) {
                $query->where(function ($innerQuery) {
                    $innerQuery->where('is_active', true)
                        ->orWhereIn('status', ['تکمیل شده', 'رد شد']);
                });
            })
            ->orderByDesc('created_at')
            ->get();

        $stats = [
            'all' => MaintenanceRequest::where('user_id', $userId)->count(),
            'in_progress' => MaintenanceRequest::where('user_id', $userId)->whereIn('status', ['جدید', 'در حال پیگیری', 'در حال بررسی'])->where('is_active', true)->count(),
            'done' => MaintenanceRequest::where('user_id', $userId)->where('status', 'تکمیل شده')->count(),
            'rejected' => MaintenanceRequest::where('user_id', $userId)->where('status', 'رد شد')->count(),
        ];

        return view('maintenance.follow_up_request', compact('maintenanceRequests', 'stats', 'selectedStatus'));
    }
}

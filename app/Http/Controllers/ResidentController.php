<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Resident;
use App\Models\Room;
use App\Models\ContractRegister;
use App\Models\MaintenanceRequest;
use App\Models\Visitors;
use App\Models\payment;

class ResidentController extends Controller
{
    public function index()
    {
        $residentCount = Resident::count();
        $roomCount = Room::count();
        $totalCapacity = (int) Room::sum('capacity');
        $occupiedCount = Resident::whereNotNull('room_id')->count();
        $availableCapacity = max($totalCapacity - $occupiedCount, 0);
        $capacityPercentage = $totalCapacity > 0
            ? min((int) round(($occupiedCount / $totalCapacity) * 100), 100)
            : 0;
        $activeContractCount = ContractRegister::where('contract_status', 'فعال')->count();
        $paymentCount = payment::count();
        $paymentTotal = (float) payment::sum('amount');
        $visitorCount = Visitors::where('attendance_status', 'داخل خوابگاه')
            ->whereNull('check_out_at')
            ->count();
        $openMaintenanceCount = MaintenanceRequest::where('is_active', true)->count();

        $recentRequests = MaintenanceRequest::with(['requestType', 'room', 'user'])
            ->when(auth()->user()->role === 'user', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->take(5)
            ->get();

        return view('home', compact(
            'recentRequests',
            'residentCount',
            'roomCount',
            'totalCapacity',
            'occupiedCount',
            'availableCapacity',
            'capacityPercentage',
            'activeContractCount',
            'paymentCount',
            'paymentTotal',
            'visitorCount',
            'openMaintenanceCount'
        ));
    }

    public function ResidentRegister()
    {
        $rooms = Room::all();
        $residents = Resident::all();

        $rooms = $rooms->filter(function ($room) use ($residents) {

            $residentCount = $residents
                ->where('room_id', $room->id)
                ->count();

            // ظرفیت باقی‌مانده
            $room->remaining_capacity = $room->capacity - $residentCount;

            // فقط اتاق‌هایی که ظرفیت خالی دارند
            return $residentCount < $room->capacity;
        });

        return view('resident.resident_register', compact('rooms'));
    }

    public function ResidentList()
    {
        $residents = Resident::with('room')->simplePaginate(10);

        return view('resident.resident_list', compact('residents'));
    }

    public function ResidentListDetails($id)
    {
        $residentDetails = Resident::with('room')->findOrFail($id);

        return view('resident.resident_list_details', compact('residentDetails'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'resident_code' => 'required|unique:residents,resident_code',
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'city_name' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'work_phone' => 'nullable|string|max:20',
            'occupation_location' => 'nullable|string|max:255',
            'guarantor_name' => 'required|string|max:255',
            'guarantor_father_name' => 'required|string|max:255',
            'guarantor_phone' => 'required|string|max:20',
            'guarantor_occupation' => 'nullable|string|max:255',
            'guarantor_occupation_location' => 'nullable|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'resident_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_card_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'guarantor_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        foreach (['resident_image', 'id_card_image', 'guarantor_image'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('residents', 'public');
                $validatedData[str_replace('_image', '_image_url', $field)] = '/storage/' . $path;
            }
        }

        $resident = Resident::create($validatedData);

        if (!$resident) {
            return redirect()->back()->with('error', 'ثبت ساکن انجام نشد. لطفاً دوباره تلاش کنید.');
        }

        return redirect()->route('resident.list')->with('success', 'ساکن با موفقیت ثبت شد.');
    }
    public function ResidentListEdit($id)
    {
        $resident = Resident::with('room')->findOrFail($id);
        $rooms = Room::all();

        return view('resident.resident_edit', compact('resident', 'rooms'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'resident_code' => 'required|unique:residents,resident_code,' . $id,
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'city_name' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'work_phone' => 'nullable|string|max:20',
            'occupation_location' => 'nullable|string|max:255',
            'guarantor_name' => 'required|string|max:255',
            'guarantor_father_name' => 'required|string|max:255',
            'guarantor_phone' => 'required|string|max:20',
            'guarantor_occupation' => 'nullable|string|max:255',
            'guarantor_occupation_location' => 'nullable|string|max:255',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $resident = Resident::findOrFail($id);
        $updated = $resident->update($validatedData);

        if (!$updated) {
            return redirect()->back()->with('error', 'به‌روزرسانی ساکن انجام نشد. لطفاً دوباره تلاش کنید.');
        }

        return redirect()->route('resident.list.details', ['id' => $resident->id])->with('success', 'اطلاعات ساکن با موفقیت بروزرسانی شد.');
    }
}

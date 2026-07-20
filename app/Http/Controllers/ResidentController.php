<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Room;

class ResidentController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function ResidentRegister()
    {
        $rooms = Room::all();
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
        ]);

        $resident = Resident::create($validatedData);

        if (! $resident) {
            return redirect()->back()->with('error', 'ثبت ساکن انجام نشد. لطفاً دوباره تلاش کنید.');
        }

        return redirect()->route('resident.list')->with('success', 'ساکن با موفقیت ثبت شد.');
    }
}

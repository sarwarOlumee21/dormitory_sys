<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestType;
use App\Models\Resident;
use App\Models\MaintenanceRequest;

class MaintenanceController extends Controller
{
    public function maintenanceRequest()
    {
        $residents = Resident::with('room')->get(); // Assuming you have a Resident model
        $requestTypes = RequestType::all(); // Assuming you have a RequestType model
        return view('maintenance.maintenance_request', compact('residents', 'requestTypes'));
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
            'resident_id' => 'required|exists:residents,id',
            'room_id' => 'required|exists:rooms,id',
            'request_types_id' => 'required|exists:request_types,id',
            'priority' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
        ]);
        // Save the maintenance request to the database
        $save = MaintenanceRequest::create($data);
        if ($save) {
            $request->session()->flash('success', 'درخواست تعمیر با موفقیت ثبت شد.');
        } else {
            $request->session()->flash('error', 'خطا در ثبت درخواست تعمیر.');
        }

        return redirect()->route('maintenance.request');
    }

    public function list()
    {
        $maintenanceRequests = MaintenanceRequest::with(['resident', 'requestType','room'])->get();
        return view('maintenance.maintenance_list',compact('maintenanceRequests'));
    }
}

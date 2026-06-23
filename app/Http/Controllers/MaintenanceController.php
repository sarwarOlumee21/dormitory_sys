<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function register()
    {
        return view('maintenance.maintenance_register');
    }

    public function request(Request $request)
    {
        $requestTypes = $request->session()->get('maintenance_request_types', []);
        return view('maintenance.maintenance_request', compact('requestTypes'));
    }

    public function saveRequestType(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:600',
            'is_active' => 'nullable|boolean',
        ]);

        $requestTypes = $request->session()->get('maintenance_request_types', []);
        $requestTypes[] = [
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => $request->has('is_active'),
            'created_at' => now()->format('Y/m/d'),
        ];
        $request->session()->put('maintenance_request_types', $requestTypes);

        return redirect()->route('maintenance.request')->with('status', 'نوعیت درخواست با موفقیت ذخیره شد.');
    }

    public function list()
    {
        return view('maintenance.maintenance_list');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Visitors;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function register()
    {
        $residents = Resident::all();
        $rooms = Room::all();
        // $rooms = $residents->pluck('room')->unique();
        return view('visitors.visitor_register', compact('residents','rooms'));
    }

    public function list()
    {
        $visitors = Visitors::with('resident', 'room')->get();

        return view('visitors.visitor_list',compact('visitors'));
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'guest_name' => 'required|string|max:255',
            'guest_id_number' => 'required|string|max:255',
            'guest_phone' => 'nullable|string|max:255',
            'check_in_at' => 'required|date',
            'check_out_at' => 'nullable|date|after_or_equal:check_in_at',
            'room_number' => 'required|exists:rooms,id',
            'purpose' => 'nullable|string|max:500',
        ]);

        // Create a new visitor record in the database
        Visitors::create($validatedData);

        // Redirect back with a success message
        return redirect()->route('visitors.register')->with('success', 'بازدیدکننده با موفقیت ثبت شد.');
    }
}

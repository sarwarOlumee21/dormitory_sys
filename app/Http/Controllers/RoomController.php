<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function RoomRegister(){
        return view('rooms.room_register');
    }
    public function RoomList(){
        $rooms = Room::all();
        $count = $rooms->count();
        $activeRooms = Room::where('status', 'available')->count();

        return view('rooms.room_list', compact('rooms', 'count', 'activeRooms'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_number' => 'required|unique:rooms,room_number',
            'capacity' => 'required|integer|min:1',
            'room_type' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $room = Room::create($validatedData);
        if (!$room) {
            return redirect()->back()->with('error', 'Failed to register room. Please try again.');
        }

        return redirect()->route('rooms.list')->with('success', 'Room registered successfully.');
    }
}

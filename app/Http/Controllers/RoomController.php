<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Room;
use App\Models\Resident;

class RoomController extends Controller
{
    public function RoomRegister(){
        return view('rooms.room_register');
    }
    public function RoomList(){
  $rooms = Room::all();
$resident = Resident::all();

$rooms = $rooms->map(function ($room) use ($resident) {

    // تعداد Resident های داخل این اتاق
    $currentCapacity = $resident
        ->where('room_id', $room->id)
        ->count();

    // ظرفیت فعلی اتاق
    $room->current_capacity = $currentCapacity;

    // وضعیت اتاق
    if ($currentCapacity == 0) {

        $room->room_status = 'خالی';

    } elseif ($currentCapacity >= $room->capacity) {

        $room->room_status = 'پر';

    } elseif ($currentCapacity < $room->capacity) {

        $room->room_status = 'دارای ظرفیت';

    }

    return $room;
});
        return view('rooms.room_list', compact('rooms'));
    }
    public function RoomEdit($id)
    {
        $room = Room::findOrFail($id);

        return view('rooms.room_edit', compact('room'));
    }
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validatedData = $request->validate([
            'room_number' => ['required', 'string', Rule::unique('rooms', 'room_number')->ignore($id)],
            'capacity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ]);

        $updated = $room->update($validatedData);

        if (!$updated) {
            return redirect()->back()->with('error', 'به‌روزرسانی اتاق انجام نشد. لطفاً دوباره تلاش کنید.');
        }

        return redirect()->route('rooms.list')->with('success', 'اطلاعات اتاق با موفقیت بروزرسانی شد.');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_number' => 'required|unique:rooms,room_number',
            'capacity' => 'required|integer|min:1',
            // 'room_type' => 'required|string',
            'notes' => 'nullable|string',
            // 'status' => 'required|in:available,occupied,maintenance',
        ]);

        $room = Room::create($validatedData);
        if (!$room) {
            return redirect()->back()->with('error', 'Failed to register room. Please try again.');
        }

        return redirect()->route('rooms.list')->with('success', 'Room registered successfully.');
    }
}

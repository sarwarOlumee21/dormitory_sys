<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function register()
    {
        return view('announcements.announcement_register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:250',
            'category' => 'nullable|string|max:100',
            'publish_date' => 'nullable|date',
            'expire_date' => 'nullable|date|after_or_equal:publish_date',
            'status' => 'required|string|in:فعال,پیش‌نویس,منقضی',
            'content' => 'required|string',
        ]);

        Announcement::create($data);

        return redirect()->route('announcements.list')->with('success', 'اعلان با موفقیت منتشر شد.');
    }

    public function list()
    {
        $announcements = Announcement::latest()->paginate(10);

        return view('announcements.announcement_list', compact('announcements'));
    }
}

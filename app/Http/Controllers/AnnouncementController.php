<?php

namespace App\Http\Controllers;

class AnnouncementController extends Controller
{
    public function register()
    {
        return view('announcements.announcement_register');
    }

    public function list()
    {
        return view('announcements.announcement_list');
    }
}

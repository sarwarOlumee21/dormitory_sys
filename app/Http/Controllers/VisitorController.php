<?php

namespace App\Http\Controllers;
use App\Models\Resident;

class VisitorController extends Controller
{
    public function register()
    {
        $residents = Resident::all();
        return view('visitors.visitor_register', compact('residents'));
    }

    public function list()
    {
        return view('visitors.visitor_list');
    }
}

<?php

namespace App\Http\Controllers;

class VisitorController extends Controller
{
    public function register()
    {
        return view('visitors.visitor_register');
    }

    public function list()
    {
        return view('visitors.visitor_list');
    }
}

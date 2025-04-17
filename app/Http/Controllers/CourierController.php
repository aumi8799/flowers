<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function index()
    {
        return view('courier.dashboard');
    }
}

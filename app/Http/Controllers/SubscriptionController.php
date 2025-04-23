<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        // Gauti visas aktyvias prenumeratas prisijungusiam vartotojui
        $subscriptions = Auth::user()->subscriptions;

        // Grąžinti į peržiūros puslapį su prenumeratomis
        return view('subscriptions.index', compact('subscriptions'));
    }
}

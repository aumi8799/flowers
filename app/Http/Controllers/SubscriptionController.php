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
        $subscriptions = Subscription::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(5); // arba kiekviename puslapyje rodomų įrašų skaičius


        // Grąžinti į peržiūros puslapį su prenumeratomis
        return view('subscriptions.index', compact('subscriptions'));
    }
}

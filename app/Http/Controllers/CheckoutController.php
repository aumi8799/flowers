<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $total = $request->input('total') ?? 0;
        return view('checkout', compact('total'));
    }

    public function success()
    {
        return view('checkout_success');
    }
}

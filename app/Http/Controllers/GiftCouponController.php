<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiftCoupon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class GiftCouponController extends Controller
{
    public function index()
    {
        return view('giftcoupons');
    }

   public function purchase(Request $request)
{
    $request->validate([
        'value' => 'required|numeric|min:1',
    ]);

    $giftCoupon = [
        'type' => 'giftcoupon',
        'name' => 'Dovanų kuponas',
        'price' => $request->value,
        'quantity' => 1,
    ];

    $cart = session()->get('cart', []);
    $cart[] = $giftCoupon;
    session()->put('cart', $cart);

    return redirect()->route('cart.view')->with('success', 'Dovanų kuponas pridėtas į krepšelį!');
}

    
}

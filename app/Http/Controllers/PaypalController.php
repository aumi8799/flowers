<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class PayPalController extends Controller
{
    public function success(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect('/')->with('error', 'Krepšelis tuščias.');
        }

        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Norėdami pirkti, turite būti prisijungę.');
        }

        // Sukuriam naują užsakymą
        $order = new Order();
        $order->user_id = Auth::id();
        $order->status = 'apmokėtas';
        $order->delivery_city = session('delivery_city', 'Nežinomas miestas'); // <-- nauja eilutė!
        $order->total_price = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $order->save();
        

        // Pridedam visus produktus prie order_items
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Išvalom krepšelį
        session()->forget('cart');

        return view('checkout_success');
    }

    public function cancel()
    {
        return redirect('/cart')->with('error', 'Mokėjimas atšauktas.');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $total = $request->query('total'); 
        $city = $request->query('city');
        $orderId = $request->query('order_id');

        if (!$orderId) {
            session([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'delivery_address' => $request->delivery_address,
                'postal_code' => $request->postal_code,
                'delivery_city' => $request->city,
                'notes' => $request->notes,
                'total_price' => $request->total,
                'video' => $request->delivery_video,
            ]);
        }
    
        return view('checkout', [
            'total' => $total,
            'city' => $city,
            'order_id' => $orderId ?? null
        ]);
    }
    
    public function success()
    {
        return view('checkout_success');
    }
}

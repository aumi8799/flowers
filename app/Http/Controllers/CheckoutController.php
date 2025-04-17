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
                'total_price' => $total,
                'delivery_city' => $city
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

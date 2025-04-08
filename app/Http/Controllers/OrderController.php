<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function myOrders(Request $request)
    {
        $query = Order::where('user_id', auth()->id());

        if ($request->has('status') && in_array($request->status, ['rezervuotas', 'apmokėtas', 'pristatytas', 'atšauktas'])) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderByDesc('created_at')->get();

        return view('orders', compact('orders'));
    }
}

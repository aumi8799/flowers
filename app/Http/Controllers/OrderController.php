<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function reserve(Request $request)
    {
    
        // Sukuriame naują užsakymą
        $order = new Order();
        $order->user_id = auth()->id(); 
        $order->delivery_city = $request->delivery_city;
        $order->total_price = $request->total_price;
        $order->status = 'rezervuotas'; 
        $order->save();

        // Grąžiname į užsakymų puslapį su pranešimu
        return redirect()->route('orders.index')->with('success', 'Užsakymas rezervuotas!');
    }

    // Rodome užsakymus vartotojui
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

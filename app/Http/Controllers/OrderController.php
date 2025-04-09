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
    
        // Įrašome prekes į order_items lentelę
        $cart = session()->get('cart', []);
        foreach ($cart as $productId => $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }
    
        // Išvalome krepšelį
        session()->forget('cart');
    
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
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);
    
        return view('orders.show', compact('order'));
    }
    

    // Atšaukiame rezervaciją
    public function destroy(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Negalite atšaukti šio užsakymo.');
        }

        if ($order->status === 'atšauktas' || $order->status === 'pristatytas') {
            return redirect()->route('orders.index')->with('error', 'Šio užsakymo atšaukti nebegalima.');
        }

        $order->status = 'atšauktas';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Užsakymas sėkmingai atšauktas.');
    }

    // Redaguoti užsakymą
    public function edit(Order $order)
        {
            if ($order->user_id !== auth()->id()) {
                abort(403, 'Neturite teisės redaguoti šio užsakymo.');
            }

            if ($order->status !== 'rezervuotas') {
                return redirect()->route('orders.index')->with('error', 'Tik rezervuotus užsakymus galima redaguoti.');
            }

            return view('orders.edit', compact('order'));
        }

    // Redaguoti rezervaciją

    public function update(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Negalite redaguoti šio užsakymo.');
        }

        if ($order->status !== 'rezervuotas') {
            return redirect()->route('orders.show', $order->id)->with('error', 'Tik rezervuotus užsakymus galima redaguoti.');
        }

        $request->validate([
            'delivery_city' => 'required|integer',
            'quantities' => 'required|array',
        ]);

        // Atnaujinti pristatymo miestą
        $order->delivery_city = $request->delivery_city;

        $total = 0;

        // Atnaujinti prekių kiekius ir perskaičiuoti bendrą sumą
        foreach ($order->items as $item) {
            if (isset($request->quantities[$item->id])) {
                $item->quantity = $request->quantities[$item->id];
                $item->save();

                $total += $item->quantity * $item->price;
            }
        }

        $order->total_price = $total;
        $order->save();

        return redirect()->route('orders.show', $order->id)->with('success', 'Užsakymas atnaujintas sėkmingai!');
    }


}
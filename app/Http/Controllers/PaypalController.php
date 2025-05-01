<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderPaidConfirmationMail;
use Illuminate\Support\Facades\Mail;

class PayPalController extends Controller
{
    public function success(Request $request)
    {
        $cart = session('cart', []);
        $orderId = $request->query('order_id');
    
        if ($orderId) {
            $order = Order::where('id', $orderId)
                        ->where('user_id', Auth::id())
                        ->where('status', 'rezervuotas')
                        ->first();
    
            if (!$order) {
                return redirect('/')->with('error', 'Užsakymas nerastas arba negalima jo apmokėti.');
            }
    
            $order->status = 'apmokėtas';
            $order->save();
    
            // Patvirtinimo laiškas
            Mail::to(Auth::user()->email)->send(new OrderPaidConfirmationMail($order));
    
            return view('checkout_success');
        }
    
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
        $order->first_name = session('first_name');
        $order->last_name = session('last_name');
        $order->phone = session('phone');
        $order->email = session('email');
        $order->delivery_address = session('delivery_address');
        $order->postal_code = session('postal_code');
        $order->delivery_date = session('delivery_date');
        $order->delivery_time = session('delivery_time');
        $order->delivery_city = session('delivery_city');
        $order->notes = session('notes');
        $order->total_price = session('total_price');
        $order->video = session('video');
        $order->save();
    
        // Pridedame produktus ir individualias puokštes
        foreach ($cart as $item) {
            if (isset($item['type']) && $item['type'] === 'product') {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            } elseif (isset($item['type']) && $item['type'] === 'custom_bouquet') {
                \App\Models\CustomBouquet::where('id', $item['id'])->update([
                    'order_id' => $order->id,
                ]);
            }
        }
    
        // Sukuriame subscriptions (jei yra)
        foreach ($cart as $item) {
            if (isset($item['type']) && $item['type'] === 'subscription') {
                \App\Models\Subscription::create([
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'category' => $item['category'],
                    'size' => $item['size'],
                    'duration' => $item['duration'],
                    'price' => $item['price'],
                    'start_date' => now(),
                    'status' => 'aktyvi',
                ]);
            }
        }
        foreach ($cart as $item) {
            if (isset($item['postcard']) && !empty($item['postcard'])) {
                \App\Models\Postcard::create([
                    'order_id' => $order->id,
                    'template' => $item['postcard']['template'] ?? 'numatytas',
                    'message' => $item['postcard']['message'] ?? '',
                    'method' => $item['postcard']['method'] ?? null,
                    'file_path' => $item['postcard']['file_path'] ?? null,
                ]);
            }
        }
        
        // Įkeliam user į order, kad nevežtų klaidos blade šablone
        $order->load('user');
    
        // Siunčiam patvirtinimo laišką
        Mail::to(Auth::user()->email)->send(new OrderPaidConfirmationMail($order));
    
        // Išvalom sesiją
        session()->forget([
            'cart', 'first_name', 'last_name', 'phone', 'email',
            'delivery_address', 'postal_code','delivery_date','delivery_time', 'delivery_city',
            'notes', 'total_price', 'delivery_video'
        ]);
    
        return view('checkout_success');
    }
    

    public function cancel()
    {
        return redirect('/cart')->with('error', 'Mokėjimas atšauktas.');
    }

}

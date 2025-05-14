<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderPaidConfirmationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\GiftCoupon;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\LoyaltyPoint;
use App\Services\InvoiceService;

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

            $earnedPoints = (int) $order->total_price;
            $alreadyGiven = LoyaltyPoint::where('user_id', $order->user_id)
                ->where('description', 'like', '%#' . $order->id . '%')
                ->exists();

            if (!$alreadyGiven) {
                LoyaltyPoint::create([
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'points' => $earnedPoints,
                    'description' => 'Apmokėtas rezervuotas užsakymas #' . $order->id,
                ]);

                $order->user->increment('total_points', $earnedPoints);
            }

            // Siunčiam faktūrą su PDF
            $invoicePath = (new InvoiceService())->generateInvoicePdf($order);
            Mail::to(Auth::user()->email)->send(new OrderPaidConfirmationMail($order, $invoicePath));

            return view('checkout_success');
        }

        if (empty($cart)) {
            return redirect('/')->with('error', 'Krepšelis tuščias.');
        }

        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Norėdami pirkti, turite būti prisijungę.');
        }

        // Naujo užsakymo kūrimas
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

        // Pridedami krepšelio elementai
  // Pridedami krepšelio elementai
foreach ($cart as $item) {
    $orderItem = null;

    if (isset($item['type']) && $item['type'] === 'product') {
        $orderItem = \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    } elseif ($item['type'] === 'custom_bouquet') {
        $orderItem = \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'custom_bouquet_id' => $item['id'],
            'quantity' => $item['quantity'] ?? 1,
            'price' => $item['price'],
        ]);

        \App\Models\CustomBouquet::where('id', $item['id'])->update([
            'order_id' => $order->id,
        ]);
    } elseif ($item['type'] === 'giftcoupon') {
        $coupon = GiftCoupon::create([
            'code' => strtoupper(Str::random(10)),
            'value' => $item['price'],
            'used' => false,
            'order_id' => $order->id,
        ]);

        $pdf = Pdf::loadView('pdf.gift_coupon', compact('coupon'));
        $pdfPath = 'giftcoupons/coupon_' . $coupon->code . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        Mail::raw("Dėkojame už įsigytą dovanų kuponą!", function ($message) use ($coupon, $pdfPath) {
            $message->to(Auth::user()->email)
                    ->subject('Jūsų dovanų kuponas')
                    ->attach(storage_path('app/public/' . $pdfPath));
        });
    }

    // Jei yra atvirukas, priskiriam prie šio orderItem
    if (isset($item['postcard']) && $orderItem) {
        \App\Models\Postcard::create([
            'order_id' => $order->id,
            'order_item_id' => $orderItem->id,
            'template' => $item['postcard']['template'] ?? 'numatytas',
            'message' => $item['postcard']['message'] ?? '',
            'method' => $item['postcard']['method'] ?? null,
            'file_path' => $item['postcard']['file_path'] ?? null,
        ]);
    }
}


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

        if (session('gift_coupon_code')) {
            $coupon = GiftCoupon::where('code', session('gift_coupon_code'))->first();
            if ($coupon && !$coupon->used) {
                $coupon->used = true;
                $coupon->used_in_order_id = $order->id;
                $coupon->save();
            }
        }

        $usedPoints = session('loyalty_points_used', 0);
        if ($usedPoints > 0) {
            LoyaltyPoint::create([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'points' => -$usedPoints,
                'description' => 'Naudota užsakymui #' . $order->id,
                'used_loyalty_points' => 1,
            ]);
        }

        $order->load('user');

        // Siunčiam patvirtinimo laišką su faktūra
        $invoicePath = (new InvoiceService())->generateInvoicePdf($order);
        Mail::to(Auth::user()->email)->send(new OrderPaidConfirmationMail($order, $invoicePath));

        // Išvalom sesiją
        session()->forget([
            'cart', 'first_name', 'last_name', 'phone', 'email',
            'delivery_address', 'postal_code','delivery_date','delivery_time', 'delivery_city',
            'notes', 'total_price', 'delivery_video','gift_coupon_code', 'gift_coupon_discount',
            'loyalty_points_used', 'loyalty_discount','user_points'
        ]);

        // Lojalumo taškai
        $earnedPoints = (int) $order->total_price;
        LoyaltyPoint::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'points' => $earnedPoints,
            'description' => 'Apmokėtas užsakymas #' . $order->id,
        ]);

        $user = \App\Models\User::find($order->user_id);
        $user->increment('total_points', $earnedPoints);

        return view('checkout_success');
    }

    public function cancel()
    {
        return redirect('/cart')->with('error', 'Mokėjimas atšauktas.');
    }
}
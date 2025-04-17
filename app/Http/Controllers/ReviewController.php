<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;

class ReviewController extends Controller
{
    public function create(Order $order)
{
    // Tik jei tai mano užsakymas ir statusas pristatytas
    if ($order->user_id !== auth()->id() || $order->status !== 'pristatytas') {
        abort(403);
    }

    // Jei jau parašytas atsiliepimas – redirect
    if ($order->review) {
        return redirect()->route('orders.show', $order->id)
                         ->with('info', 'Jūs jau palikote atsiliepimą.');
    }

    return view('reviews.create', compact('order'));
}

public function store(Request $request, Order $order)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:1000',
    ]);

    Review::create([
        'user_id' => auth()->id(),
        'order_id' => $order->id,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return redirect()->route('orders.show', $order->id)->with('success', 'Atsiliepimas sėkmingai išsaugotas!');
}
public function showAll()
{
    $reviews = Review::with('user')->latest()->get();
    return view('reviews.show', compact('reviews'));
}

}

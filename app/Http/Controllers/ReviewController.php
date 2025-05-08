<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

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
public function showAll(Request $request)
{
    $rating = $request->query('rating');

    // Užklausa su galimu filtru
    $query = Review::with('user')->latest();
    if ($rating) {
        $query->where('rating', $rating);
    }

    $reviews = $query->paginate(6)->appends(['rating' => $rating]);

    // Skaičiavimai su visais atsiliepimais (nefiltruotais)
    $allReviews = Review::all();
    $averageRating = round($allReviews->avg('rating'), 1);
    $ratingCounts = $allReviews->groupBy('rating')->map->count();
    $totalReviews = $allReviews->count();

    return view('reviews.show', compact('reviews', 'averageRating', 'ratingCounts', 'totalReviews', 'rating'));
}

}

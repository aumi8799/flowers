<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postcard;
use App\Models\Order;

class PostcardController extends Controller
{
    public function create($orderId)
    {
        return view('postcard.create', ['orderId' => $orderId]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'template' => 'required|string',
            'message' => 'required|string|max:255',
        ]);

        Postcard::create([
            'order_id' => $request->order_id,
            'template' => $request->template,
            'message' => $request->message,
        ]);

        return redirect()->route('orders.show', $request->order_id)
            ->with('success', 'Atvirukas pridėtas!');
    }
}

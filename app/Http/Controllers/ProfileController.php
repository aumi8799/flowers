<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Review;
use App\Models\CustomBouquet;
use App\Models\Subscription;

class ProfileController extends Controller
{
    public function summary()
    {
        $user = Auth::user();

        return view('addresses', [
            'totalPoints' => $user->total_points ?? 0,
            'ordersCount' => Order::where('user_id', $user->id)->count(),
            'reviewsCount' => Review::where('user_id', $user->id)->count(),
        ]);
    }
}

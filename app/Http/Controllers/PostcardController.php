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
}

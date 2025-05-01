<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function addToCart(Request $request)
{
    $cart = session()->get('cart', []);

    $productId = $request->id;
    $name = $request->name;
    $price = $request->price;
    $quantity = $request->quantity;
    $image = $request->image;

    $path_to_file = null;

    // Įkeliam failą (jei yra)
    if ($request->hasFile('postcard_file')) {
        $file = $request->file('postcard_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/postcards'), $fileName);
        $path_to_file = 'uploads/postcards/' . $fileName;
    }

    // Sukuriam unikalų įrašo raktą
    $uniqueKey = Str::uuid()->toString();

    // Sukuriam pagrindinį įrašą
    $cart[$uniqueKey] = [
        'id' => $productId,
        'type' => 'product',
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $image,
    ];

    // Jei pridėtas atvirukas
    if ($request->has('add_postcard') && $request->add_postcard == '1') {
        $cart[$uniqueKey]['postcard'] = [
            'method' => $request->postcard_method ?? 'simple',
            'template' => $request->postcard_template ?? null,
            'message' => $request->postcard_message ?? '',
            'uploaded_file' => $path_to_file,
        ];
    }

    session()->put('cart', $cart);

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Prekė pridėta į krepšelį!',
            'cartCount' => count($cart),
        ]);
    }

    return redirect()->back()->with('success', 'Prekė pridėta į krepšelį!');
}

    public function addSubscriptionToCart(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'size' => 'required|string',
            'duration' => 'required|integer|min:1',
        ]);
    
        $basePrice = 30;
        $sizePrices = ['XS' => 0, 'S' => 5, 'M' => 10, 'L' => 15, 'XL' => 20];
        $size = $request->size;
        $duration = $request->duration;
    
        $finalPrice = ($basePrice + $sizePrices[$size]) * $duration;
    
        $subscription = [
            'name' => 'Puokščių prenumerata',
            'category' => $request->category,
            'size' => $size,
            'duration' => $duration,
            'price' => $finalPrice,
            'quantity' => 1,
            'type' => 'subscription',
        ];
    
        $cart = session()->get('cart', []);
        $cart['subscription'] = $subscription; // Tik viena prenumerata vienu metu
        session()->put('cart', $cart);
    
        return redirect()->route('cart.view')->with('success', 'Prenumerata pridėta į krepšelį!');
    }
    public function removeSubscriptionFromCart()
{
    $cart = session()->get('cart', []);

    if (isset($cart['subscription'])) {
        unset($cart['subscription']);
        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Prenumerata pašalinta iš krepšelio.');
}

    // Peržiūrėti krepšelį
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // Pašalinti prekę iš krepšelio
    public function removeFromCart($key)
{
    $cart = session()->get('cart', []);
    if (isset($cart[$key])) {
        unset($cart[$key]);
        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Prekė pašalinta iš krepšelio.');
}


    // Ištuštinti krepšelį
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Krepšelis ištuštintas.');
    }
}


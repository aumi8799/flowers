<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        $productId = $request->id;
        $name = $request->name;
        $price = $request->price;
        $quantity = $request->quantity; // Naudojame kiekių reikšmę iš užklausos
        $image = $request->image;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity; // Pridedame pasirinkta kiekį
        } else {
            $cart[$productId] = [
                "name" => $name,
                "price" => $price,
                "quantity" => $quantity, 
                "image" => $request->image,
            ];
        }
        
        session()->put('cart', $cart);
        
        // Grąžinti atsakymą į front-end su Ajax
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
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
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


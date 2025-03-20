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



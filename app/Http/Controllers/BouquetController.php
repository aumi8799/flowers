<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CustomBouquet;
use Illuminate\Support\Str;

class BouquetController extends Controller
{
    // Rodo puokštės kūrimo formą
    public function create()
    {
        // Ištraukiame visas skintas gėles
        $flowers = Product::where('category', 'skintos_geles')->get();

        // Išskiriame unikalias gėlių rūšis (type)
        $flowerTypes = $flowers->pluck('type')->unique()->filter()->values()->toArray();

        return view('bouquet.create', compact('flowers', 'flowerTypes'));
    }

    // Saugo pasirinktą puokštę
    public function store(Request $request)
    {
        $bouquetData = json_decode($request->input('bouquet'), true);

        if (!$bouquetData || empty($bouquetData)) {
            return redirect()->back()->with('error', 'Negalite užsakyti tuščios puokštės.');
        }

        // Sugeneruojame unikalų kodą
        $uniqueCode = 'PUOKSTE-' . strtoupper(Str::random(6));

        // Sukuriame naują CustomBouquet įrašą
        $customBouquet = CustomBouquet::create([
            'code' => $uniqueCode,
            'bouquet_data' => json_encode($bouquetData), // <-- LABAI SVARBU!
            'total_price' => array_sum(array_map(function ($flower) {
                return $flower['price'] * $flower['quantity'];
            }, $bouquetData)),
        ]);

        // Įdedame puokštę į krepšelį (sesijoje)
        $cart = session()->get('cart', []);

        $cart[] = [
            'type' => 'custom_bouquet',
            'id' => $customBouquet->id,
            'name' => 'Individuali puokštė',
            'price' => $customBouquet->total_price,
            'quantity' => 1,
        ];

        session()->put('cart', $cart);

        // Nukreipiam į krepšelį
        return redirect()->route('cart.view')->with('success', 'Puokštė sėkmingai pridėta į krepšelį!');

    }
}
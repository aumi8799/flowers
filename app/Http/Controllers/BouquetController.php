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

    public function store(Request $request)
    {
        $bouquetData = json_decode($request->input('bouquet'), true);
    
        if (!$bouquetData || empty($bouquetData)) {
            return redirect()->back()->with('error', 'Negalite užsakyti tuščios puokštės.');
        }
    
        $uniqueCode = 'PUOKSTE-' . strtoupper(Str::random(6));
    
        $customBouquet = CustomBouquet::create([
            'code' => $uniqueCode,
            'bouquet_data' => json_encode($bouquetData),
            'total_price' => array_sum(array_map(function ($flower) {
                return $flower['price'] * $flower['quantity'];
            }, $bouquetData)),
        ]);
    
        // Jei buvo įkeltas failas
        $path_to_file = null;
        if ($request->hasFile('postcard_file')) {
            $file = $request->file('postcard_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/postcards'), $fileName);
            $path_to_file = 'uploads/postcards/' . $fileName;
        }
    
        $cart = session()->get('cart', []);
    
        $item = [
            'type' => 'custom_bouquet',
            'id' => $customBouquet->id,
            'name' => 'Individuali puokštė',
            'price' => $customBouquet->total_price,
            'quantity' => 1,
        ];
    
        if ($request->has('add_postcard') && $request->add_postcard == '1') {
            $item['postcard'] = [
                'method' => $request->postcard_method ?? 'simple',
                'template' => $request->postcard_template,
                'message' => $request->postcard_message,
                'uploaded_file' => $path_to_file,
            ];
        }
    
        $cart[] = $item;
        session()->put('cart', $cart);
    
        return redirect()->route('cart.view')->with('success', 'Puokštė sėkmingai pridėta į krepšelį!');
    }
    
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Kiti metodai...

    public function show($id)
    {
        // Paimkite konkretų produktą pagal ID
        $product = Product::findOrFail($id);

        // Grąžinkite į blade, kad parodytumėte produktą
        return view('product.show', compact('product'));
    }
}

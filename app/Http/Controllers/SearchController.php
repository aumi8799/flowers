<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query'); // Paieškos užklausa
    
        $products = Product::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', '%' . $query . '%')
                                 ->orWhere('description', 'like', '%' . $query . '%');
        })->get();
    
        return view('search.results', compact('products', 'query'));
    }    
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // Bendras filtravimo metodas su kainų diapazonu ir puslapio parametru
    protected function filterByPrice(Request $request, $category = null)
    {
        $query = Product::query();

        if ($category) {
            $query->where('category', $category);
        }

        // Filtravimas pagal minimalią kainą
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }

        // Filtravimas pagal maksimalią kainą
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Puslapio parametras (pagal numatytuosius nustatymus 10 elementų per puslapį)
        return $query->paginate(10);
    }

    // Pagrindinis katalogo puslapis su filtravimu
    public function index(Request $request)
    {
        $products = $this->filterByPrice($request);

        return view('catalog.index', compact('products'));
    }

    // Skintos gėlės puslapis su filtravimu
    public function skintosGeles(Request $request)
    {
        $products = $this->filterByPrice($request, 'skintos_geles');

        return view('catalog.skintos-geles', compact('products'));
    }

    // Puokštės puslapis su filtravimu
    public function puokstes(Request $request)
    {
        $products = $this->filterByPrice($request, 'puokstes');

        return view('catalog.puokstes', compact('products'));
    }

    // Gėlės dėžutėje puslapis su filtravimu
    public function gelesDezuteje(Request $request)
    {
        $products = $this->filterByPrice($request, 'geles_dezuteje');

        return view('catalog.geles-dezuteje', compact('products'));
    }

    // Miegančios rožės puslapis su filtravimu
    public function mieganciosRoze(Request $request)
    {
        $products = $this->filterByPrice($request, 'miegancios_rozes');

        return view('catalog.miegancios-rozes', compact('products'));
    }

}

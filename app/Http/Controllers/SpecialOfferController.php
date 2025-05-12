<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialOffer;

class SpecialOfferController extends Controller
{
    public function apply(Request $request)
    {
        $code = strtoupper(trim($request->discount_code));

        $offer = SpecialOffer::where('code', $code)
            ->where(function ($q) {
                $q->whereNull('valid_until')
                ->orWhere('valid_until', '>=', now());
            })
            ->first();

        if ($offer) {
            session()->put('special_discount_code', $offer->code);
            session()->put('special_discount_value', $offer->discount); // Pvz: 0.20

            return back()->with('discount_code_success', 'Nuolaidos kodas pritaikytas!');
        }

        return back()->with('discount_code_error', 'Šis kodas negalioja arba jau pasibaigęs.');
    }

    public function remove()
    {
        session()->forget(['special_discount_code', 'special_discount_value']);
        return back()->with('discount_code_success', 'Nuolaidos kodas pašalintas.');
    }

    public function index()
    {
        $offers = SpecialOffer::where(function($query) {
            $query->whereNull('valid_until')
                ->orWhere('valid_until', '>=', now());
        })->get();

        return view('special_offers.index', compact('offers'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoyaltyPoint;


class LoyaltyController extends Controller
{
    public function apply(Request $request)
    {
        $user = auth()->user();
        $usedPoints = (int) $request->input('used_points');
        // Validacija
        if ($usedPoints < 1 || $usedPoints > $user->total_points) {
            return redirect()->back()->with('coupon_error', 'Neteisingas taškų kiekis.');
        }

        // Skaičiavimai
        $discount = $usedPoints * 0.10;

        // Bendrų taškų kiekio sumažinimas
        $user->total_points -= $usedPoints;
        $user->save();

        // Įrašom į sesiją, kad nuolaida veiktų
        session([
            'loyalty_discount' => $discount,
            'loyalty_points_used' => $usedPoints
        ]);

        return redirect()->back();
    }

}

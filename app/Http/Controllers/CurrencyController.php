<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;


class CurrencyController extends Controller
{
    public function getRates()
    {
        $rates = Currency::getRates();
        return response()->json(['rates' => $rates]);
    }

    public function convert(Request $request)
    {
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $rates = Currency::getRates();

        if (isset($rates[$currency])) {
            $rate = $rates[$currency];
            $convertedAmount = $amount * $rate;
            return response()->json(['converted' => $convertedAmount]);
        }

        return response()->json(['error' => 'Invalid currency'], 400);
    }
}

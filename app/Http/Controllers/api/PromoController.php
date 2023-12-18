<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    function readAll()
    {
        $promo = Promo::with('shop')->get();

        return response()->json([
            'data' => $promo
        ], 200);
    }

    function readLimit()
    {
        $promo = Promo::orderBy('created_at', 'desc')
            ->limit(5)
            ->with('shop')
            ->get();

        if (count($promo) > 0) {
            return response()->json([
                'data' => $promo
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
                'data' => $promo
            ], 404);
        }
    }
}

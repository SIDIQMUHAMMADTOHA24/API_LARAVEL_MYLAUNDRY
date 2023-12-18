<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    function readAll()
    {
        $shop = Shop::all();

        return response()->json([
            'data' => $shop
        ], 200);
    }

    function readRecommendationLimit()
    {
        $shop = Shop::orderBy('rate', 'desc')
            ->limit(5)
            ->get();

        if (count($shop) > 0) {
            return response()->json([
                'data' => $shop
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
                'data' => $shop
            ], 404);
        }
    }

    function searchByCity($name)
    {
        $shop = Shop::where('city', 'like', '%' . $name . '%')
            ->orderBy('name')
            ->get();

        if (count($shop) > 0) {
            return response()->json([
                'data' => $shop
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
                'data' => $shop
            ], 404);
        }
    }
}

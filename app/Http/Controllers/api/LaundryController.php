<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
    function readAll()
    {
        $laundry = Laundry::with('user', 'shop')->get();

        return response()->json([
            'data' => $laundry
        ], 200);
    }

    function whereUserId($id)
    {
        $laundries = Laundry::where('user_id', '=', $id)
            ->with('user', 'shop')
            ->orderBy('created_at', 'desc')
            ->get();

        if (count($laundries) > 0) {
            return response()->json([
                'data' => $laundries
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
                'data' => $laundries
            ], 404);
        }
    }

    function claim(Request $request)
    {

        $laundry = Laundry::where([
            ['id', '=', $request->id],
            ['claim_code', '=', $request->claim_code],
        ])->first();

        if (!$laundry) {
            return response()->json([
                'message' => 'not found',
            ], 404);
        }

        if ($laundry->user_id != 0) {
            return response()->json([
                'message' => 'laundry has been claim',
            ], 400);
        }

        $laundry->user_id = $request->user_id;
        $update = $laundry->save();

        if ($update) {
            return response()->json([
                'data' => $update
            ], 201);
        } else {
            return response()->json([
                'message' => 'can not be update',
            ], 500);
        }
    }
}

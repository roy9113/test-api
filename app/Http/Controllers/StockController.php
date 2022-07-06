<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{

    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'product_id' => 'required',
            'on_hand' => 'required',
            'taken' => 'required',
            'production_date' => 'required',
        ]);

        try
        {
            $stock = Stock::create(
                $request->only(['product_id', 'on_hand', 'taken', 'production_date'])
            );

            return response()->json($stock, 201);
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return response()->json([
                'error' => $e    // In production, do not show this error details
            ], 500);
        }
    }
}

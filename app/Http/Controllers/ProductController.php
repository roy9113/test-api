<?php

namespace App\Http\Controllers;

use App\Models\Product;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        try
        {
            $product = Product::create(
                $request->only(['code', 'name', 'description'])
            );

            return response()->json($product, 201);
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            Log::error('Create Product Failed', [
                'context' => $e
            ]);

            return response()->json([
                'error' => $e    // In production, do not show this error details
            ], 500);
        }
    }

    /**
     * Pass second optional parameter as 1, it will show stocks
     */
    public function show(Request $request, $id, $getStock = null)
    {
        $product = Product::find($id);
        $stocks = [];

        if ($product)
        {
            if ($getStock == 1)
            {
                if (isset($product->stock) && count($product->stock) > 0)
                {
                    foreach ($product->stock as $stock)
                    {
                        $stocks[] = [
                            'id' => $stock->id,
                            'product_id' => $stock->product_id,
                            'on_hand' => $stock->on_hand,
                            'taken' => $stock->taken,
                            'production_date' => $stock->production_date,
                            'created_at' => $stock->created_at,
                            'updated_at' => $stock->updated_at
                        ];
                    }
                }
            }

            return response()->json([
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'description' => $product->description,
                'deleted_at' => $product->deleted_at,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'stocks' => $stocks
            ], 202);
        }

        Log::info('Product not found', [
            'id' => $id
        ]);

        return response()->json([
            'message' => 'Product was not found'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        try
        {
            $product = Product::find($id);

            $product->update($request->only([
                'code',
                'name',
                'description'
            ]));

            return response()->json($product, 202);
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            Log::error('Update Product Failed', [
                'context' => $e,
                'id' => $id
            ]);

            return response()->json([
                'error' => $id   // In production, do not show this error details
            ], 500);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product)
        {
            try
            {
                $product->delete();
                return response()->json([
                    'success' => 'Product successfully deleted'
                ], 202);
            }
            catch (\Illuminate\Database\QueryException $e)
            {
                Log::error('Product delete failed', [
                    'context' => $id
                ]);

                return response()->json([
                    'error' => $e    // In production, do not show this error details
                ], 500);
            }
        }

        return response()->json('Product was not found', 404);
    }
}

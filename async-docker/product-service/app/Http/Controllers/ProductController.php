<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateProductStock;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json([
            'status'  => 'Success',
            'message' => 'Products retrieved successfully',
            'data'    => Product::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'  => 'required|unique:products',
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'status'  => 'Success',
            'message' => 'Product created successfully',
            'data'    => $product
        ], 201);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'Product not found',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => 'Success',
            'message' => 'Product found',
            'data'    => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'Product not found',
                'data'    => null
            ], 404);
        }

        $product->update($request->all());

        return response()->json([
            'status'  => 'Success',
            'message' => 'Product updated successfully',
            'data'    => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'Product not found',
                'data'    => null
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status'  => 'Success',
            'message' => 'Product deleted successfully',
            'data'    => null
        ]);
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'product_quantity' => 'required|integer|min:1',
        ]);

        // Dispatch job ke Redis queue (asinkron)
        UpdateProductStock::dispatch($id, $request->product_quantity);

        return response()->json([
            'status'  => 'Success',
            'message' => 'Stock update queued successfully',
            'data'    => null
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json([
            'status'  => 'Success',
            'message' => 'Orders retrieved successfully',
            'data'    => Order::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'  => 'required',
            'user_id'     => 'required',
            'total_price' => 'required|numeric',
            'quantity'    => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'product_id'  => $request->product_id,
            'user_id'     => $request->user_id,
            'status'      => $request->status ?? 'pending',
            'total_price' => $request->total_price,
            'quantity'    => $request->quantity,
        ]);

        // Kirim job ke Redis queue (asinkron) untuk update stok
        Http::post(env('PRODUCT_SERVICE_URL') . '/products/' . $request->product_id . '/update-stock', [
            'product_quantity' => $request->quantity,
        ]);

        return response()->json([
            'status'  => 'Success',
            'message' => 'Order created successfully',
            'data'    => $order
        ], 201);
    }

    public function show($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'Order not found',
                'data'    => null
            ], 404);
        }

        // Ambil detail product dari product-service
        $product = Http::get(env('PRODUCT_SERVICE_URL') . '/products/' . $order->product_id);

        // Ambil detail user dari user-service
        $user = Http::get(env('USER_SERVICE_URL') . '/users/' . $order->user_id);

        $data = $order->toArray();
        $data['product'] = $product->json('data');
        $data['user']    = $user->json('data');

        return response()->json([
            'status'  => 'Success',
            'message' => 'Order found',
            'data'    => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'Order not found',
                'data'    => null
            ], 404);
        }

        $order->update($request->all());

        return response()->json([
            'status'  => 'Success',
            'message' => 'Order updated successfully',
            'data'    => $order
        ]);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'Order not found',
                'data'    => null
            ], 404);
        }

        $order->delete();

        return response()->json([
            'status'  => 'Success',
            'message' => 'Order deleted successfully',
            'data'    => null
        ]);
    }

    public function getByUser($userId)
    {
        $orders = Order::where('user_id', $userId)->get();

        return response()->json([
            'status'  => 'Success',
            'message' => 'Orders retrieved successfully',
            'data'    => $orders
        ]);
    }
}
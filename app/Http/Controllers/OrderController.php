<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with('user', 'orderDetails.product')->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'province' => 'required|string',
            'district' => 'required|string',
            'village' => 'required|string',
            'total_amount' => 'required|numeric',
            'order_date' => 'required|date',
            'status' => 'required|string',
        ]);

        $order = Order::create($validatedData);
        return response()->json($order, Response::HTTP_CREATED);

    } catch (ValidationException $e) {
        return response()->json([
            'errors' => $e->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422
    }
}

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with('user', 'orderDetails')->findOrFail($id);
        return response()->json($order);
    }

    public function getOrderByUser($id)
    {
        $orders = Order::with(['user', 'orderDetails.product'])
                   ->where('user_id', $id)
                   ->get();
        return response()->json($orders);
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'province' => 'sometimes|string',
            'district' => 'sometimes|string',
            'village' => 'sometimes|string',
            'total_amount' => 'sometimes|numeric',
            'order_date' => 'sometimes|date',
        ]);

        $order->update($validatedData);
        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'sometimes|string',
        ]);

        $order->update($validatedData);
        return response()->json($order);
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // แสดงคำสั่งซื้อทั้งหมด (Read)
    public function index()
    {
        return response()->json(Order::with('orderdetails.product')->get(), 200);
    }

    // สร้างคำสั่งซื้อใหม่ (Create)
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'order_date' => 'required|date',
        ]);

        // สร้างคำสั่งซื้อใหม่
        $order = Order::create($validatedData);

        return response()->json($order, 201);
    }

    // แสดงคำสั่งซื้อตาม ID (Read)
    public function show($id)
    {
        // ใช้ findOrFail แทน find เพื่อจะได้ error 404 เมื่อไม่พบข้อมูล
        $order = Order::with('orderdetails.product')->findOrFail($id);

        return response()->json($order, 200);
    }

    // อัปเดตคำสั่งซื้อ (Update)
    public function update(Request $request, $id)
    {
        // ใช้ findOrFail เพื่อให้เกิด error 404 หากไม่พบคำสั่งซื้อ
        $order = Order::findOrFail($id);

        // Validation
        $validatedData = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'total_amount' => 'sometimes|numeric|min:0',
            'order_date' => 'sometimes|date',
        ]);

        // อัปเดตคำสั่งซื้อ
        $order->update($validatedData);

        return response()->json($order, 200);
    }

    // ลบคำสั่งซื้อ (Delete)
    public function destroy($id)
    {
        // ใช้ findOrFail เพื่อให้เกิด error 404 หากไม่พบคำสั่งซื้อ
        $order = Order::findOrFail($id);

        // ลบคำสั่งซื้อ
        $order->delete();
        
        return response()->json(['message' => 'Order deleted'], 200);
    }
}

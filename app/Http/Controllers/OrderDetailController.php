<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    // แสดงรายการสินค้าในคำสั่งซื้อ (Read)
    public function index()
    {
        return response()->json(OrderDetail::with('product')->get(), 200);
    }

    // เพิ่มสินค้าในคำสั่งซื้อ (Create)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $orderdetail = OrderDetail::create($validatedData);

        return response()->json($orderdetail, 201);
    }

    // แสดงสินค้าในคำสั่งซื้อตาม ID (Read)
    public function show($id)
    {
        $orderdetail = OrderDetail::with('product')->find($id);
        if (!$orderdetail) {
            return response()->json(['message' => 'Order item not found'], 404);
        }

        return response()->json($orderdetail, 200);
    }

    // อัปเดตรายการสินค้าในคำสั่งซื้อ (Update)
    public function update(Request $request, $id)
    {
        $orderdetail = OrderDetail::find($id);
        if (!$orderdetail) {
            return response()->json(['message' => 'Order item not found'], 404);
        }

        $validatedData = $request->validate([
            'order_id' => 'sometimes|exists:orders,id',
            'product_id' => 'sometimes|exists:products,id',
            'quantity' => 'sometimes|integer|min:1',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $orderdetail->update($validatedData);

        return response()->json($orderdetail, 200);
    }

    // ลบสินค้าในคำสั่งซื้อ (Delete)
    public function destroy($id)
    {
        $orderdetail = OrderDetail::find($id);
        if (!$orderdetail) {
            return response()->json(['message' => 'Order item not found'], 404);
        }

        $orderdetail->delete();
        return response()->json(['message' => 'Order item deleted'], 200);
    }
}

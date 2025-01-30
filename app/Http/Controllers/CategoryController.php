<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // แสดงหมวดหมู่ทั้งหมด (Read)
    public function index()
    {
        return response()->json(Category::all(), 200);
    }

    // สร้างหมวดหมู่ใหม่ (Create)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validatedData);

        return response()->json($category, 201);
    }

    // แสดงหมวดหมู่ตาม ID (Read)
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category, 200);
    }

    // อัปเดตหมวดหมู่ (Update)
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);

        $category->update($validatedData);

        return response()->json($category, 200);
    }

    // ลบหมวดหมู่ (Delete)
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted'], 200);
    }
}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;




// //Product Routes
// Route::apiResource('products', ProductController::class);

Route::get('/products', [ProductController::class, 'index']); 
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);


// Category Routes
Route::get('/categories/index', [CategoryController::class, 'index']);
Route::post('/categories/store', [CategoryController::class, 'store']);
Route::get('/categories/show/{id}', [CategoryController::class, 'show']);
Route::put('/categories/update/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/destroy/{id}', [CategoryController::class, 'destroy']);

// Order Routes
Route::get('/orders/index', [OrderController::class, 'index']);
Route::post('/orders/store', [OrderController::class, 'store']);
Route::get('/orders/show/{id}', [OrderController::class, 'show']);
Route::get('/orders/user/{id}', [OrderController::class, 'getOrderByUser']);
Route::put('/orders/update/{id}', [OrderController::class, 'update']);
Route::put('/orders/updateStatus/{id}', [OrderController::class, 'updateStatus']);
Route::delete('/orders/destroy/{id}', [OrderController::class, 'destroy']);

// Order detail Routes
Route::get('/detail/index', [OrderDetailController::class, 'index']);
Route::post('/detail/store', [OrderDetailController::class, 'store']);
Route::get('/detail/show/{id}', [OrderDetailController::class, 'show']);
Route::put('/detail/update/{id}', [OrderDetailController::class, 'update']);
Route::delete('/detail/destroy/{id}', [OrderDetailController::class, 'destroy']);

// User Routes
Route::post('/users/login', [UserController::class, 'login']);
Route::post('/users/register', [UserController::class, 'register']);
Route::get('/users', [UserController::class, 'getAll']);

// Admin Routes
Route::post('/admins/register', [AdminController::class, 'register']);
Route::post('/admins/login', [AdminController::class, 'login']);;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/images', [ImageController::class, 'upload']); // อัปโหลดรูปภาพ
Route::get('/images/{product_id}', [ImageController::class, 'show']); // ดึงรูปภาพตาม product_id
Route::delete('/images/{id}', [ImageController::class, 'destroy']); // ลบรูปภาพ

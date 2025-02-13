<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ชื่อสินค้า
            $table->string('image_url'); // URL ของภาพสินค้า
            $table->decimal('price', 10, 2); // ราคาสินค้า
            $table->decimal('original_price', 10, 2)->nullable(); // ราคาต้นทุนของสินค้า
            $table->decimal('rating', 3, 2)->nullable(); // คะแนนรีวิวสินค้า
            $table->integer('review_count')->default(0); // จำนวนรีวิว
            $table->text('description')->nullable(); // รายละเอียดสินค้า
            $table->string('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}


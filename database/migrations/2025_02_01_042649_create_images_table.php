<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('filename'); // Image file name
            $table->string('path'); // File path in storage
            $table->string('mime_type')->nullable(); // Optional: Image MIME type (e.g., image/png)
            $table->integer('size')->nullable(); // Optional: File size in KB
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('images');
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->string('sku', 255)->nullable();
            $table->string('barcode', 255)->nullable();
            $table->integer('qty')->unsigned();
            $table->enum('status', [0, 1]);
            $table->enum('track_qty', [0, 1])->default(0);
            $table->enum('is_featured', [0, 1])->default(0);
            $table->unsignedBigInteger('category_id'); // Required category_id
            $table->unsignedBigInteger('sub_category_id')->nullable(); // Optional sub_category_id
            $table->unsignedBigInteger('brand_id')->nullable(); // Optional brand_id
            $table->timestamps();
            // Define foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade')->onUpdate('cascade');
            //$table->foreign('category_id')->references('id')->on('categories');
            //$table->foreign('sub_category_id')->references('id')->on('sub_categories');
            //$table->foreign('brand_id')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
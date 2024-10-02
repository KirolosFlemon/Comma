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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('color_id')->nullable();
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');

            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('set null');

            $table->unsignedBigInteger('material_id')->nullable();
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('set null');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');

            
            $table->decimal('additional_price')->default(0);
            $table->integer('inventory_number')->nullable();
            $table->boolean('out_of_stock')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};

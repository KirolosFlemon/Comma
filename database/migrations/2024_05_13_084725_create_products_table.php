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
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->boolean('best_seller')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('price_after_discount', 10, 2)->nullable();
            $table->string('sku')->unique()->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->softDeletes(); // This adds the 'deleted_at' column
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
};

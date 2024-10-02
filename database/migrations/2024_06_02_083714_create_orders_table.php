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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('status_id');
            $table->decimal('coupon_price', 8, 2)->nullable();
            $table->decimal('shipping_price', 8, 2)->nullable();
            $table->unsignedBigInteger('payment_type_id');
            $table->string('payment_status');
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->decimal('total', 8, 2);
            $table->decimal('grand_total', 8, 2);
            $table->text('notes')->nullable();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('address_id')->references('id')->on('addresses')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('statuses')->cascadeOnDelete();
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->cascadeOnDelete();
            $table->foreign('coupon_id')->references('id')->on('coupons')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

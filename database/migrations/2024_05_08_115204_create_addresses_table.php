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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('address')->nullable();
            $table->string('room_floor')->nullable();
            $table->string('notes')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')
                ->on('cities')->cascadeOnDelete();
            $table->softDeletes(); // This adds the 'deleted_at' column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};

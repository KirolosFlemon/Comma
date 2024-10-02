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
        // Drop existing primary key constraint on email column, if it exists
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->dropPrimary(['email']);
        });

        // Add new id column as primary key
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop id column and updated_at column
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('updated_at');
        });

        // Restore primary key constraint on email column
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->primary('email');
        });
    }
};

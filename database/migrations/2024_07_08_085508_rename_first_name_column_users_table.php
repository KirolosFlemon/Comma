<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE users CHANGE first_name name VARCHAR(191) NULL');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE users CHANGE name first_name  STRING(191) NULL');

        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->nullable();
        });
    }
};

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('offers')->insert([
            [
                'type' => 'amount_off_product',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'buy_x_get_y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'free_shipping',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 20;
        $this->command->getOutput()->progressStart($count);
        $faker = \Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'name_ar' => $faker->city,
                'name_en' => $faker->city,
                'postal_code' => $faker->postcode
            ];
        }
        \DB::table('cities')->insert($data);
        $this->command->getOutput()->progressAdvance();

    }
}

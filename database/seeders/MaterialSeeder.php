<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 20;
        $this->command->getOutput()->progressStart($count);
        $faker = \Faker\Factory::create();
        for ($index = 1; $index <= $count; $index++) {
            $material = new \App\Models\Material();
            $material->name_ar = $faker->company;
            $material->name_en = $faker->company;
            $material->save();
        }
        $this->command->getOutput()->progressAdvance();
    }
}

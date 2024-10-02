<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
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
            $color = new \App\Models\Color();
            $color->name_ar = $faker->company;
            $color->name_en = $faker->company;
            $color->image = $faker->imageUrl();
            $color->save();
        }
        $this->command->getOutput()->progressAdvance();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 20;
        $this->command->getOutput()->progressStart($count);

        // \App\Models\Brand::truncate();
        $faker = \Faker\Factory::create();
        for ($index = 1; $index <= $count; $index++) {
            $brand = new \App\Models\Brand();
            $brand->name_ar = $faker->company;
            $brand->name_en = $faker->company;
            $brand->save();
            $image = new \App\Models\BrandImage();
            $image->image = $faker->imageUrl();
            $image->brand_id = $brand->id;
            $image->save();
        }
        $this->command->getOutput()->progressAdvance();
    }
}

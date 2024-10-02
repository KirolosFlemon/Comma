<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
            $category = new \App\Models\Category();
            $category->name_ar = $faker->company;
            $category->name_en = $faker->company;
            $category->slug = \Illuminate\Support\Str::slug(\Faker\Factory::create()->word) . '-' . $index;

            $category->save();
            $image = new \App\Models\CategoryImage();
            $image->image = $faker->imageUrl();
            $image->category_id = $category->id;
            $image->save();

            
            // $subCategoryCount = rand(1, 5);
            for ($i = 1; $i <= $count; $i++) {
                $subCategory = new \App\Models\SubCategory();
                $subCategory->name_ar = $faker->company;
                $subCategory->name_en = $faker->company;
                $subCategory->slug = \Illuminate\Support\Str::slug(\Faker\Factory::create()->word) . '-' . $i . '-' . uniqid();

                $subCategory->save();
                $subCategory->category()->sync([$category->id]);
            }

        }
        $this->command->getOutput()->progressAdvance();
    }
}

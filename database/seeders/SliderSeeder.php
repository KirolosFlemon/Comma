<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
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
            $slider = new \App\Models\Slider();
            $slider->image = $faker->imageUrl();
            $slider->active = 0;
            $slider->save();
        }
        $this->command->getOutput()->progressAdvance();
    }
}

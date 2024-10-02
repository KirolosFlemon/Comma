<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
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
            $size = new \App\Models\Size();
            $size->size = $faker->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL']);
            $size->save();
        }
        $this->command->getOutput()->progressAdvance();
    }
}

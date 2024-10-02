<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
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
            $status = new \App\Models\Status();
            $status->name_ar = $faker->company;
            $status->name_en = $faker->company;
            $status->save();
        }
        $this->command->getOutput()->progressAdvance();
    }
}

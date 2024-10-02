<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
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
            $collection = new \App\Models\Collection();
            $collection->name_ar = $faker->company;
            $collection->name_en = $faker->company;

            $collection->save();
            $image = new \App\Models\CollectionImage();
            $image->image = $faker->imageUrl();
            $image->collection_id = $collection->id;
            $image->save();
        }
        $this->command->getOutput()->progressAdvance();
    }
}

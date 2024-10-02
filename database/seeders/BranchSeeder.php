<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('branches')->insert(
            $this->createRandomBranches(20)
        );
    }
    /**
     * Generates an array of random branches with specified count.
     *
     * @param int $count The number of branches to generate.
     * @return array The array of randomly generated branches.
     */
    private function createRandomBranches($count)
    {
        $this->command->getOutput()->progressStart($count);

        $faker = \Faker\Factory::create();
        $branches = [];
        for ($i = 0; $i < $count; $i++) {
           
            $branches[] = [
                'name_ar' => $faker->company,
                'name_en' => $faker->company,
                'address' => $faker->streetAddress,
                'lat' => $faker->latitude,
                'long' => $faker->longitude,
                'created_at' => now(),
                'updated_at' => now(),
            ];

        }
        $this->command->getOutput()->progressAdvance();
        return $branches;
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 20;
        $this->command->getOutput()->progressStart($count);

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < $count; $i++) {
            \DB::table('addresses')->insert([
                'address' => $faker->streetAddress,
                'lat' => $faker->latitude,
                'long' => $faker->longitude,
                'user_id' => rand(1, \DB::table('users')->count()),
                'city_id' => rand(1, \DB::table('cities')->count()),
                'room_floor' => rand(1, 10),
                'notes' => $faker->realText($maxNbChars = 50),
                'phone' => $faker->phoneNumber,
            ]);

            $this->command->getOutput()->progressAdvance();
        }

    }
}

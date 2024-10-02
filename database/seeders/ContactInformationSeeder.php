<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 20;
        $this->command->getOutput()->progressStart($count);
        $faker = \Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'name' => $faker->name(),
                'email' => $faker->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'message' => $faker->paragraph($nbSentences = 5),
            ];
        }
        \DB::table('contact_informations')->insert($data);
        $this->command->getOutput()->progressAdvance();

    }
}

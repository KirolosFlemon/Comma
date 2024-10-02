<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RolePermissionSeeder::class,
            CreateAdminUserSeeder::class,
            CitySeeder::class,
            BranchSeeder::class,
            BrandSeeder::class,
            AddressSeeder::class,
            CategorySeeder::class,
            CollectionSeeder::class,
            ColorSeeder::class,
            MaterialSeeder::class,
            SizeSeeder::class,
            StatusSeeder::class,
            SliderSeeder::class,
            ContactInformationSeeder::class,
            OffersSeeder::class,
        ]);
    }
}

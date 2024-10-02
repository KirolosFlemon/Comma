<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;


class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate([
            'email' => 'admin@demo.com',
        ], [
            'name' => 'Admin',
            'username' => ' Admin',
            'email' => 'admin@demo.com',
            'phone' => '0110279119',
            'password' => 12345678,
            'email_verified_at' => null,
            'image' => null,
            'type' => 1,

        ]);

        $user->assignRole('admin');
    }
}

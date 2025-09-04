<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'], // unique identifier
            [
                'first_name' => 'System',
                'middle_name' => null,
                'last_name' => 'Administrator',
                'username' => 'admin',
                'phone' => '0000000000', // dummy phone, kasi required unique
                'password' => Hash::make('tourismadmin'),
                'role' => 'admin',
                'phone_verified_at' => now(),
            ]
        );
    }
}

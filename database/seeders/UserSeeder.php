<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create Superadmin user
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@banksampah.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        // Create Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@banksampah.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Regular user
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
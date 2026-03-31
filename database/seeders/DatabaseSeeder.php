<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Buat Petugas
        User::firstOrCreate(
            ['email' => 'petugas@example.com'],
            [
                'name' => 'Petugas User',
                'password' => Hash::make('password123'),
                'role' => 'petugas',
            ]
        );

        // Buat User Biasa
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );
    }
}
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
            ['email' => 'admin@gnmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );

        // Buat Petugas
        User::firstOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'Petugas User',
                'password' => Hash::make('123456'),
                'role' => 'petugas',
            ]
        );

        // Buat User Biasa
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('123456'),
                'role' => 'user',
            ]
        );
    }
}
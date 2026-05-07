<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Team Lead
        User::create([
            'name' => 'hassan',
            'email' => 'hassan@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Junior Developers
        User::create([
            'name' => 'khalid',
            'email' => 'khalid@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'youssef',
            'email' => 'youssef@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'abderrahman',
            'email' => 'abderrahman@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
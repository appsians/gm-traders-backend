<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::updateOrCreate(
            ['email' => 'admin@admin.com'], // Condition to check existing user
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone' => '12345678900',
                'role' => 'admin', // Make sure your users table has a 'role' column
                'password' => Hash::make('password'), // Default password
            ]
        );
    }
    }


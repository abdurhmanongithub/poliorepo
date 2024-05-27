<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Constants;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'full_name' => 'Test User',
            'email' => 'admin@gmail.com',
            'user_type' => Constants::INTERNAL_USER,
            'password' => Hash::make('12345678')
        ]);
    }
}

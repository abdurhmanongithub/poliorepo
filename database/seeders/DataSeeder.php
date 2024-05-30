<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() == 0)
            User::create([
                'full_name' => 'Super Admin',
                'email' => 'super@gmail.com',
                'password' => bcrypt('password'),
            ]);
    }
}

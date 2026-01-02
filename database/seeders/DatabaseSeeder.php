<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'no_hp' => '08123456789',
            'is_active' => true,
            'is_admin' => true,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'username' => 'user',
            'no_hp' => '08123456780',
            'is_active' => true,
            'is_admin' => false,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
    }
}

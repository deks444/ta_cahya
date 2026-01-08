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
        // Create Admin/Superadmin
        User::factory()->create([
            'name' => 'Admin Sharefit',
            'username' => 'admin',
            'no_hp' => '08123456789',
            'is_active' => true,
            'is_admin' => true,
            'role' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        // Create Pelatih
        User::factory()->create([
            'name' => 'Pelatih Budi',
            'username' => 'pelatih',
            'no_hp' => '08123456780',
            'is_active' => true,
            'is_admin' => false,
            'role' => 'pelatih',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        // Create Atlit
        User::factory()->create([
            'name' => 'Atlit Andi',
            'username' => 'atlit',
            'no_hp' => '08123456781',
            'is_active' => true,
            'is_admin' => false,
            'role' => 'atlit',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        // Seed user points and achievements
        $this->call([
            UserPointsSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdditionalUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambahan Pelatih
        User::create([
            'name' => 'Pelatih Joko',
            'username' => 'pelatih2',
            'no_hp' => '08123456790',
            'is_active' => true,
            'is_admin' => false,
            'role' => 'pelatih',
            'password' => Hash::make('password'),
        ]);

        // Tambahan Atlit
        User::create([
            'name' => 'Atlit Susi',
            'username' => 'atlit2',
            'no_hp' => '08123456791',
            'is_active' => true,
            'is_admin' => false,
            'role' => 'atlit',
            'password' => Hash::make('password'),
        ]);

        $this->command->info('Data tambahan (Pelatih Joko & Atlit Susi) berhasil ditambahkan!');
    }
}

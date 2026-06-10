<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Seed akun petugas ke database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'petugas@sipes.com'],
            [
                'name'              => 'Petugas Kebersihan',
                'password'          => Hash::make('petugas123'),
                'role'              => 'petugas',
                'email_verified_at' => now(),
            ]
        );
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed akun admin langsung ke database.
     * Akun ini TIDAK bisa dibuat melalui form registrasi.
     */
    public function run(): void
    {
        // Buat akun admin jika belum ada (idempotent - aman dijalankan berkali-kali)
        User::firstOrCreate(
            ['email' => 'admin@sipes.com'],
            [
                'name'              => 'Admin SIPES',
                'password'          => Hash::make('admin123'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}

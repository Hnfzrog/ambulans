<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; // Pastikan ini ditambahkan
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder // Pastikan ada class di sini
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() // Fungsi ini harus berada di dalam class
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Super Admin
        User::create([
            'name' => 'Super Admin User',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);
    }
}

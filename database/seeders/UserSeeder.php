<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \App\Models\User::truncate();
        
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Seed the data
        $users = [
            [
                'name' => 'Muhrodin',
                'email' => 'muhroodinkru@gmail.com',
                'password' => Hash::make('@Bismillah123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Nursalim',
                'email' => 'nursalimkru@gmail.com',
                'password' => Hash::make('@Bismillah123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Muhson',
                'email' => 'muhsonkoordinator@gmail.com',
                'password' => Hash::make('@Bismillah123'),
                'role' => 'superadmin',
            ],
            [
                'name' => 'Ahmad Khotim',
                'email' => 'ahmadkhotimkru@gmail.com',
                'password' => Hash::make('@Bismillah123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Dwika Aulia Arief Prihastyo',
                'email' => 'dwikaauliaapkru@gmail.com',
                'password' => Hash::make('@Bismillah123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Andri Kurniawan',
                'email' => 'andrikurniawankru@gmail.com',
                'password' => Hash::make('@Bismillah123'),
                'role' => 'admin',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

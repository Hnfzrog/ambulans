<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pasien;
use App\Models\User;
use Carbon\Carbon; 

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Retrieve random users with appropriate roles for kru and koordinator
        $kru = User::where('role', 'admin')->inRandomOrder()->first();
        $koordinator = User::where('role', 'superAdmin')->inRandomOrder()->first();

        // Create sample pasien data with random kru and koordinator ids
        Pasien::create([
            'nama' => 'John Doe',
            'alamat' => '123 Main St',
            'tujuan' => 'Check-up',
            'keterangan' => 'Regular check-up',
            'photo' => null,
            'id_kru' => $kru ? $kru->id : null,
            'id_koordinator' => $koordinator ? $koordinator->id : null,
            'tanggal' => Carbon::now()->format('Y-m-d'),
        ]);

        Pasien::create([
            'nama' => 'Jane Smith',
            'alamat' => '456 Elm St',
            'tujuan' => 'Vaccination',
            'keterangan' => 'Annual flu shot',
            'photo' => null,
            'id_kru' => $kru ? $kru->id : null,
            'id_koordinator' => $koordinator ? $koordinator->id : null,
            'tanggal' => Carbon::now()->format('Y-m-d'),
        ]);
    }
}

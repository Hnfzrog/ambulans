<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Biaya;
use App\Models\User;
use Carbon\Carbon; 

class BiayaSeeder extends Seeder
{
    public function run()
    
    {
        $kru = User::where('role', 'admin')->inRandomOrder()->first();
        $koordinator = User::where('role', 'superAdmin')->inRandomOrder()->first();
        Biaya::create([
            'tanggal' => '2024-10-01',
            'keterangan' => 'Pembelian bahan baku',
            'uang_masuk' => 1000000,
            'uang_keluar' => 200000,
            'id_kru' => $kru ? $kru->id : null,
            'id_koordinator' => $koordinator ? $koordinator->id : null,
        ]);

        Biaya::create([
            'tanggal' => '2024-10-02',
            'keterangan' => 'Pembayaran listrik',
            'uang_masuk' => 0,
            'uang_keluar' => 500000,
            'id_kru' => $kru ? $kru->id : null,
            'id_koordinator' => $koordinator ? $koordinator->id : null,
        ]);

        // Add more records as needed
    }
}

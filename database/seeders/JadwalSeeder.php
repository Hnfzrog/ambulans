<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        Jadwal::create([
            'tanggal' => '2024-10-30',
            'pukul' => '10:00:00',
            'tujuan' => 'Jakarta',
        ]);

        Jadwal::create([
            'tanggal' => '2024-10-31',
            'pukul' => '12:00:00',
            'tujuan' => 'Bandung',
        ]);

        // Add more records as needed
    }
}

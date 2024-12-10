<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Carbon\Carbon;

class BiayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set the locale to Indonesian for Carbon
        Carbon::setLocale('id');

        // Path to the CSV file
        $csvFilePath = public_path('assets-csv/operasional.csv');

        $csv = Reader::createFromPath($csvFilePath, 'r');
        $csv->setHeaderOffset(0);

        // Mapping of Indonesian days and months to English
        $days = [
            'Senin' => 'Monday',
            'Selasa' => 'Tuesday',
            'Rabu' => 'Wednesday',
            'Kamis' => 'Thursday',
            'Jumat' => 'Friday',
            'Sabtu' => 'Saturday',
            'Ahad' => 'Sunday',
        ];

        $months = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        foreach ($csv as $row) {
            $dateString = strtr($row['tanggal'], array_merge($days, $months));

            // Replace periods and commas with spaces
            $dateString = str_replace([',', '.'], '', $dateString);

            try {
                $tanggal = Carbon::createFromFormat('l j F Y', $dateString)->format('Y-m-d');
            } catch (\Exception $e) {
                echo 'Error parsing date: ' . $e->getMessage() . PHP_EOL;
                continue;
            }

            // Clean and convert uang_masuk and uang_keluar values
            $uangMasuk = (int)str_replace('.', '', str_replace('Rp', '', $row['uang_masuk']));
            $uangKeluar = (int)str_replace('.', '', str_replace('Rp', '', $row['uang_keluar']));

            DB::table('biayas')->insert([
                'tanggal' => $tanggal,
                'keterangan' => $row['keterangan'],
                'uang_masuk' => $uangMasuk,
                'uang_keluar' => $uangKeluar,
                'id_kru' => $row['id_kru'],
                'id_koordinator' => $row['id_koordinator'],
            ]);
        }
    }
}

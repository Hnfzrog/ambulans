<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Carbon\Carbon; // Import Carbon

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set the locale to Indonesian for Carbon
        Carbon::setLocale('id');

        // Path to the CSV file
        $csvFilePath = public_path('assets-csv/pasiens.csv');

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
            // Debugging: Print the date string
            echo 'Parsing date: ' . $row['Tanggal'] . PHP_EOL;

            // Replace Indonesian day and month names with English equivalents
            $dateString = strtr($row['Tanggal'], array_merge($days, $months));

            try {
                // Parse and format the date using Carbon
                $tanggal = Carbon::createFromFormat('l, j F Y', $dateString)->format('Y-m-d');
            } catch (\Exception $e) {
                echo 'Error parsing date: ' . $e->getMessage() . PHP_EOL;
                continue;
            }

            DB::table('pasiens')->insert([
                'nama' => $row['nama'],
                'alamat' => $row['alamat'],
                'tujuan' => $row['tujuan'],
                'keterangan' => $row['keterangan'],
                'photo' => $row['photo'],
                'id_kru' => $row['id_kru'],
                'id_koordinator' => $row['id_koordinator'],
                'tanggal' => $tanggal, // Use the formatted date
            ]);
        }
    }
}

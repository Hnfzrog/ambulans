<?php
namespace App\Exports;

use App\Models\Pasien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use Carbon\Carbon;

class PatientsExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithDrawings
{
    protected $drawings = [];

    public function collection()
    {
        return Pasien::with(['kru', 'koordinator'])
            ->get()
            ->map(function ($patient, $index) {
                // Create hyperlink for the patient's photo if it exists
                $photoHyperlink = $patient->photo ? 'storage/' . $patient->photo : ''; // Adjust the path as needed

                return [
                    'no' => $index + 1,
                    'tanggal' => Carbon::parse($patient->tanggal)->translatedFormat('j F Y'),
                    'nama_kru' => optional($patient->kru)->name ?? 'N/A',
                    'nama_koordinator' => optional($patient->koordinator)->name ?? 'N/A',
                    'nama' => $patient->nama,
                    'alamat' => $patient->alamat,
                    'tujuan' => $patient->tujuan,
                    'keterangan' => $patient->keterangan,
                    'photo' => $photoHyperlink, // Store the hyperlink
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Kru',
            'Nama Koordinator',
            'Nama Pasien',
            'Alamat Pasien',
            'Tujuan',
            'Keterangan',
            'Dokumentasi'
        ];
    }

    public function title(): string
    {
        return 'Data Pasien Ambulans NU';
    }

    public function styles(Worksheet $sheet)
    {
        // Move header row to start from row 1
        $sheet->fromArray($this->headings(), null, 'A1');

        // Header row styling
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFEFEFEF'],
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Apply border styles to the entire table (starting from row 1)
        $sheet->getStyle('A1:I' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Adjust column widths for readability
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }

    public function drawings()
    {
        return $this->drawings; // No drawings needed anymore
    }

    public function map($patient): array
    {
        // Map the patient data to include hyperlinks
        return [
            'no' => $patient->no,
            'tanggal' => $patient->tanggal,
            'nama_kru' => $patient->nama_kru,
            'nama _koordinator' => $patient->nama_koordinator,
            'nama' => $patient->nama,
            'alamat' => $patient->alamat,
            'tujuan' => $patient->tujuan,
            'keterangan' => $patient->keterangan,
            'photo' => Hyperlink::create($patient->photo, $patient->photo), // Create hyperlink
        ];
    }
}
<?php

namespace App\Exports;

use App\Models\Jadwal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class JadwalExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function collection()
    {
        return Jadwal::with('kru')
            ->get()
            ->map(function ($jadwal) {
                return [
                    'tanggal' => Carbon::parse($jadwal->tanggal)->translatedFormat('j F Y'),
                    'pukul' => Carbon::parse($jadwal->pukul)->format('H:i'),
                    'tujuan' => $jadwal->tujuan,
                    'nama_kru' => optional($jadwal->kru)->name ?? 'N/A',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Pukul',
            'Tujuan',
            'Nama Kru'
        ];
    }

    public function title(): string
    {
        return 'Jadwal Operasional';
    }

    public function styles(Worksheet $sheet)
    {
        // Title row setup
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', 'Jadwal Operasional Ambulans NU');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Move header row to start from row 2
        $sheet->fromArray($this->headings(), null, 'A2');
        
        // Header row styling
        $sheet->getStyle('A2:D2')->applyFromArray([
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

        // Apply border styles to the entire table (starting from row 2)
        $sheet->getStyle('A2:D' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Adjust column widths for readability
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}

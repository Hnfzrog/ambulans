<?php

namespace App\Exports;

use App\Models\Biaya;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class BiayaExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function collection()
    {
        return Biaya::with(['kru', 'koordinator'])
            ->get()
            ->map(function ($operasional) {
                return [
                    'tanggal' => Carbon::parse($operasional->tanggal)->translatedFormat('j F Y'),
                    'nama_kru' => optional($operasional->kru)->name ?? 'N/A',
                    'nama_koordinator' => optional($operasional->koordinator)->name ?? 'N/A',
                    'keterangan' => $operasional->keterangan,
                    'uang_masuk' => $operasional->uang_masuk,
                    'uang_keluar' => $operasional->uang_keluar,
                    'saldo' => $operasional->uang_masuk - $operasional->uang_keluar,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Kru',
            'Nama Koordinator',
            'Keterangan',
            'Uang Masuk (Rp)',
            'Uang Keluar (Rp)',
            'Saldo (Rp)',
        ];
    }

    public function title(): string
    {
        return 'Biaya Operasional Ambulan MWC NU Kec. Salam';
    }

    public function styles(Worksheet $sheet)
    {
        // Title row setup
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'Biaya Operasional Ambulan MWC NU Kec. Salam');
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
        $sheet->getStyle('A2:G2')->applyFromArray([
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
        $sheet->getStyle('A2:G' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Adjust column widths for readability
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}

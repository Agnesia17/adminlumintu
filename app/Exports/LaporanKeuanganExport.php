<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LaporanKeuanganExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithColumnFormatting
{
    protected $laporanKeuangan;
    private $rowNumber = 0;

    public function __construct($laporanKeuangan)
    {
        $this->laporanKeuangan = $laporanKeuangan;
    }

    public function collection()
    {
        return $this->laporanKeuangan;
    }

    public function headings(): array
    {
        return ['No', 'Tanggal', 'Debit', 'Kredit'];
    }

    public function map($row): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $row['tanggal'],
            $row['pemasukan'],
            $row['pengeluaran']
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'C' => '#,##0',
            'D' => '#,##0',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $this->rowNumber + 1;

                // Style header
                $event->sheet->getStyle("A1:D1")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E2EFDA']
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ]
                    ]
                ]);

                // Style isi tabel
                $event->sheet->getStyle("A2:D{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ]
                    ]
                ]);
                $event->sheet->getColumnDimension('B')->setWidth(15);
                $event->sheet->getColumnDimension('C')->setWidth(25); // Kolom Pemasukan
                $event->sheet->getColumnDimension('D')->setWidth(25); // Kolom Pengeluaran
            }
        ];
    }
}

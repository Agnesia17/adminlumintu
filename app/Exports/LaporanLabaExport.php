<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class LaporanLabaExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithColumnFormatting
{
    protected $laporanLaba;
    protected $totalLabaKeseluruhan;
    private $rowNumber = 0;

    public function __construct($laporanLaba, $totalLabaKeseluruhan)
    {
        $this->laporanLaba = $laporanLaba;
        $this->totalLabaKeseluruhan = $totalLabaKeseluruhan;
    }

    public function collection()
    {
        return $this->laporanLaba;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Produk',
            'Harga Beli',
            'Harga Jual',
            'Jumlah/Kg',
            'Laba Bersih',
        ];
    }

    public function map($laba): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $laba->tanggal,
            $laba->nama_produk,
            $laba->product->harga_beli ?? 0,
            $laba->harga_jual,
            $laba->jumlah,
            ($laba->harga_jual - ($laba->product->harga_beli ?? 0)) * $laba->jumlah,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => '#,##0',
            'E' => '#,##0',
            'F' => '#,##0.00',
            'G' => '#,##0',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $lastRow = $this->rowNumber + 1;
                $lastColumn = 'G';

                // Set kolom width
                $sheet->getColumnDimension('A')->setWidth(5);  // No
                $sheet->getColumnDimension('B')->setWidth(15); // Tanggal
                $sheet->getColumnDimension('C')->setWidth(25); // Nama Produk
                $sheet->getColumnDimension('D')->setWidth(15); // Harga Beli
                $sheet->getColumnDimension('E')->setWidth(15); // Harga Jual
                $sheet->getColumnDimension('F')->setWidth(12); // Jumlah/Kg
                $sheet->getColumnDimension('G')->setWidth(15); // Laba Bersih

                // Style untuk header
                $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
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

                // Style untuk konten tabel
                $sheet->getStyle("A2:{$lastColumn}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ]
                    ]
                ]);

                // Tambahkan total laba keseluruhan
                $totalRow = $lastRow + 1;
                $sheet->setCellValue("A{$totalRow}", "Total Laba Keseluruhan");
                $sheet->mergeCells("A{$totalRow}:F{$totalRow}");
                $sheet->setCellValue("G{$totalRow}", $this->totalLabaKeseluruhan);

                // Style untuk baris total
                $sheet->getStyle("A{$totalRow}:G{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '9BC2E6']
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ]
                    ]
                ]);

                // Set alignment
                $sheet->getStyle("A1:G{$totalRow}")->getAlignment()->setVertical('center');
                $sheet->getStyle("A1:A{$lastRow}")->getAlignment()->setHorizontal('center'); // No
                $sheet->getStyle("B1:B{$lastRow}")->getAlignment()->setHorizontal('center'); // Tanggal
                $sheet->getStyle("C1:C{$lastRow}")->getAlignment()->setHorizontal('left');   // Nama Produk
                $sheet->getStyle("D1:G{$lastRow}")->getAlignment()->setHorizontal('right');  // Angka-angka
                $sheet->getStyle("A{$totalRow}")->getAlignment()->setHorizontal('left');     // Label Total
                $sheet->getStyle("G{$totalRow}")->getAlignment()->setHorizontal('right');    // Nilai Total

                // Format currency untuk kolom harga dan laba
                $currencyFormat = '#,##0';
                $sheet->getStyle("D2:E{$lastRow}")->getNumberFormat()->setFormatCode($currencyFormat);
                $sheet->getStyle("G2:G{$totalRow}")->getNumberFormat()->setFormatCode($currencyFormat);
            }
        ];
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class LaporanPenjualanExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithColumnFormatting
{
    protected $laporanPenjualan;
    protected $totalPenjualan;
    private $rowNumber = 0;

    public function __construct($laporanPenjualan, $totalPenjualan)
    {
        $this->laporanPenjualan = $laporanPenjualan;
        $this->totalPenjualan = $totalPenjualan;
    }

    public function collection()
    {
        return $this->laporanPenjualan;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Pembeli',
            'Nama Produk',
            'Harga Jual',
            'Jumlah/Kg',
            'Total',
        ];
    }

    public function map($penjualan): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $penjualan->tanggal,
            $penjualan->nama_pembeli,
            $penjualan->nama_produk,
            $penjualan->harga_jual,
            $penjualan->jumlah,
            $penjualan->total,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
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
                $sheet->getColumnDimension('C')->setWidth(25); // Nama Pembeli
                $sheet->getColumnDimension('D')->setWidth(25); // Nama Produk
                $sheet->getColumnDimension('E')->setWidth(15); // Harga Jual
                $sheet->getColumnDimension('F')->setWidth(12); // Jumlah/Kg
                $sheet->getColumnDimension('G')->setWidth(15); // Total

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

                // Tambahkan total penjualan
                $totalRow = $lastRow + 1;
                $sheet->setCellValue("A{$totalRow}", "Total Penjualan");
                $sheet->mergeCells("A{$totalRow}:F{$totalRow}");
                $sheet->setCellValue("G{$totalRow}", $this->totalPenjualan);

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
                $sheet->getStyle("C1:D{$lastRow}")->getAlignment()->setHorizontal('left');   // Nama Pembeli & Produk
                $sheet->getStyle("E1:G{$lastRow}")->getAlignment()->setHorizontal('right');  // Angka-angka
                $sheet->getStyle("A{$totalRow}")->getAlignment()->setHorizontal('left');     // Label Total
                $sheet->getStyle("G{$totalRow}")->getAlignment()->setHorizontal('right');    // Nilai Total

                // Format currency untuk kolom harga dan total
                $currencyFormat = '#,##0';
                $sheet->getStyle("E2:E{$lastRow}")->getNumberFormat()->setFormatCode($currencyFormat);
                $sheet->getStyle("G2:G{$totalRow}")->getNumberFormat()->setFormatCode($currencyFormat);
            }
        ];
    }
}
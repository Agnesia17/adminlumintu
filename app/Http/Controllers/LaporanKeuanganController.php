<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPembelian;
use App\Models\LaporanPenjualan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\LaporanKeuanganExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKeuanganController extends Controller
{
    //

    public function index(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $month = $request->month;
        $year = $request->year;

        $pembelianQuery = LaporanPembelian::query();
        $penjualanQuery = LaporanPenjualan::query();

        if ($startDate && $endDate) {
            $pembelianQuery->whereBetween('tanggal', [$startDate, $endDate]);
            $penjualanQuery->whereBetween('tanggal', [$startDate, $endDate]);
        } elseif ($month && $year) {
            $pembelianQuery->whereMonth('tanggal', $month)->whereYear('tanggal', $year);
            $penjualanQuery->whereMonth('tanggal', $month)->whereYear('tanggal', $year);
        }

        $pengeluaran = $pembelianQuery->selectRaw('tanggal, SUM(total) as total')
            ->groupBy('tanggal')->get()->keyBy('tanggal');

        $pemasukan = $penjualanQuery->selectRaw('tanggal, SUM(total) as total')
            ->groupBy('tanggal')->get()->keyBy('tanggal');

        $allDates = $pemasukan->keys()->merge($pengeluaran->keys())->unique()->sortDesc();

        $laporanKeuanganCollection = $allDates->map(function ($tanggal) use ($pemasukan, $pengeluaran) {
            return [
                'tanggal' => $tanggal,
                'pemasukan' => $pemasukan[$tanggal]->total ?? 0,
                'pengeluaran' => $pengeluaran[$tanggal]->total ?? 0,
            ];
        });

        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage();
        $currentItems = $laporanKeuanganCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $laporanKeuangan = new LengthAwarePaginator(
            $currentItems,
            $laporanKeuanganCollection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $totalPemasukanPerPage = $currentItems->sum('pemasukan');
        $totalPengeluaranPerPage = $currentItems->sum('pengeluaran');
        $years = range(now()->year, now()->year - 5);

        return view('admin.Laporan.keuangan', compact(
            'laporanKeuangan',
            'totalPemasukanPerPage',
            'totalPengeluaranPerPage',
            'years'
        ));
    }

    public function export(Request $request)
    {
        $laporanPembelian = \App\Models\LaporanPembelian::selectRaw('tanggal, SUM(total) as total_pengeluaran')
            ->groupBy('tanggal')->pluck('total_pengeluaran', 'tanggal');

        $laporanPenjualan = \App\Models\LaporanPenjualan::selectRaw('tanggal, SUM(total) as total_pemasukan')
            ->groupBy('tanggal')->pluck('total_pemasukan', 'tanggal');

        $tanggalGabungan = $laporanPembelian->keys()->merge($laporanPenjualan->keys())->unique()->sortDesc();

        $data = collect();

        foreach ($tanggalGabungan as $tanggal) {
            $data->push([
                'tanggal' => $tanggal,
                'pemasukan' => $laporanPenjualan[$tanggal] ?? 0,
                'pengeluaran' => $laporanPembelian[$tanggal] ?? 0,
            ]);
        }

        $filename = 'laporan-keuangan_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new LaporanKeuanganExport($data), $filename);
    }
}

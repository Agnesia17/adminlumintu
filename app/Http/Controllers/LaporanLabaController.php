<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPenjualan;
use App\Exports\LaporanLabaExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class LaporanLabaController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = LaporanPenjualan::with('product');
        $filteredQuery = clone $baseQuery;

        // Terapkan filter jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $baseQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $filteredQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('month') && $request->filled('year')) {
            $baseQuery->whereMonth('tanggal', $request->month)
                ->whereYear('tanggal', $request->year);
            $filteredQuery->whereMonth('tanggal', $request->month)
                ->whereYear('tanggal', $request->year);
        } elseif ($request->filled('year')) {
            $baseQuery->whereYear('tanggal', $request->year);
            $filteredQuery->whereYear('tanggal', $request->year);
        }

        // Data untuk tabel dengan pagination
        $laporanLaba = $baseQuery->paginate(10);

        // Total laba berdasarkan filter jika ada
        $totalLabaKeseluruhan = $filteredQuery->get()->sum(function ($laba) {
            return ($laba->harga_jual - ($laba->product->harga_beli ?? 0)) * $laba->jumlah;
        });

        // Get unique years for filter dropdown
        $years = LaporanPenjualan::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.Laporan.laba', compact('laporanLaba', 'totalLabaKeseluruhan', 'years'));
    }


    public function export(Request $request)
    {
        $query = LaporanPenjualan::with('product');
        $filterInfo = [];

        // Terapkan filter yang sama seperti di index
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $filterInfo[] = "periode_{$request->start_date}_sampai_{$request->end_date}";
        }

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('tanggal', $request->month)
                ->whereYear('tanggal', $request->year);
            $filterInfo[] = "bulan_{$request->month}_{$request->year}";
        } elseif ($request->filled('year')) {
            $query->whereYear('tanggal', $request->year);
            $filterInfo[] = "tahun_{$request->year}";
        }

        $laporanLaba = $query->get();

        $totalLabaKeseluruhan = $laporanLaba->sum(function ($laba) {
            return ($laba->harga_jual - ($laba->product->harga_beli ?? 0)) * $laba->jumlah;
        });

        // Buat nama file dengan informasi filter
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filterText = !empty($filterInfo) ? '_' . implode('_', $filterInfo) : '';
        $filename = "laporan-laba{$filterText}_{$timestamp}.xlsx";

        return Excel::download(new LaporanLabaExport($laporanLaba, $totalLabaKeseluruhan), $filename);
    }
}

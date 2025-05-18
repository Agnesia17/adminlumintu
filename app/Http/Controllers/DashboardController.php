<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPembelian;
use App\Models\LaporanPenjualan;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // menampilkan halaman awal ketika menuju halaman dashboard
    public function index()
    {
        // Menghitung total barang masuk hari ini
        $totalBarangMasuk = LaporanPembelian::whereDate('tanggal', today())
            ->sum('jumlah');

        // Menghitung detail barang masuk per produk
        $detailBarangMasuk = LaporanPembelian::whereDate('tanggal', today())
            ->selectRaw('nama_produk, SUM(jumlah) as total_jumlah')
            ->groupBy('nama_produk')
            ->get();

        // Menghitung total barang keluar hari ini
        $totalBarangKeluar = LaporanPenjualan::whereDate('tanggal', today())
            ->sum('jumlah');

        // Menghitung detail barang keluar per produk
        $detailBarangKeluar = LaporanPenjualan::whereDate('tanggal', today())
            ->selectRaw('nama_produk, SUM(jumlah) as total_jumlah')
            ->groupBy('nama_produk')
            ->get();

        // Total pembelian dalam Rupiah
        $totalPembelian = LaporanPembelian::whereDate('tanggal', today())
            ->sum('total');

        // Total penjualan dalam Rupiah
        $totalPenjualan = LaporanPenjualan::whereDate('tanggal', today())
            ->sum('total');

        // menampilkan view dashboard dengan membawah data
        return view('admin.dashboard', compact(
            'totalBarangMasuk',
            'detailBarangMasuk',
            'totalBarangKeluar',
            'detailBarangKeluar',
            'totalPembelian',
            'totalPenjualan'
        ));
    }
    // fungsi untuk convert data laporan penjualan dan pembelian ke dalam chart
    public function getChartData(Request $request)
    {
        // mendapatkan data taun sekarang
        $year = $request->year ?? date('Y');
        $type = $request->type ?? 'both'; // default to showing both

        // query untuk mendapatkan data laporan penjualan yang ditotal perbulannya
        $penjualan = LaporanPenjualan::selectRaw('MONTH(tanggal) as month, SUM(total) as total')
            ->whereYear('tanggal', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();
        // query untuk mendapatkan data laporan pembelian yang ditotal perbulannya
        $pembelian = LaporanPembelian::selectRaw('MONTH(tanggal) as month, SUM(total) as total')
            ->whereYear('tanggal', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // jia data kosong maka diisi list kosong
        $chartData = [
            'penjualan' => [],
            'pembelian' => []
        ];

        // jika tidak maka data diakumulasikan
        for ($i = 1; $i <= 12; $i++) {
            $chartData['penjualan'][$i] = $penjualan[$i] ?? 0;
            $chartData['pembelian'][$i] = $pembelian[$i] ?? 0;
        }
        // membawah data chart yang disimpan di JSON
        return response()->json($chartData);
    }
}

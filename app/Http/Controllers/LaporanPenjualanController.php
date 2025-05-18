<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LaporanPenjualan;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPenjualanExport;

class LaporanPenjualanController extends Controller
{
    // Menampilkan daftar laporan penjualan dengan filter dan paginasi
    public function index(Request $request)
    {
        // Membuat query dasar untuk laporan penjualan
        $baseQuery = LaporanPenjualan::query();
        // Mengkloning query untuk digunakan dalam filter
        $filteredQuery = clone $baseQuery;

        // Variabel untuk menandakan apakah filter aktif
        $isFilterActive = false;

        // Menerapkan filter berdasarkan rentang tanggal jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $baseQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $filteredQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $isFilterActive = true;
        }

        // Menerapkan filter berdasarkan bulan dan tahun, atau hanya tahun
        if ($request->filled('month') && $request->filled('year')) {
            $baseQuery->whereMonth('tanggal', $request->month)
                ->whereYear('tanggal', $request->year);
            $filteredQuery->whereMonth('tanggal', $request->month)
                ->whereYear('tanggal', $request->year);
            $isFilterActive = true;
        } elseif ($request->filled('year')) {
            $baseQuery->whereYear('tanggal', $request->year);
            $filteredQuery->whereYear('tanggal', $request->year);
            $isFilterActive = true;
        }

        // Mengambil data laporan penjualan dengan paginasi (10 data per halaman)
        $laporanPenjualan = $baseQuery->paginate(10);

        // Mengambil total jumlah produk yang terjual, dikelompokkan berdasarkan ID dan nama produk
        $totalProduk = LaporanPenjualan::select('id_product', 'nama_produk')
            ->selectRaw('SUM(jumlah) as total_jumlah')
            ->groupBy('id_product', 'nama_produk')
            ->get();

        // Mengambil daftar tahun unik dari kolom tanggal untuk filter
        $years = LaporanPenjualan::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Mengembalikan tampilan dengan data laporan, total produk, tahun, dan status filter
        return view('admin.Laporan.penjualan', compact('laporanPenjualan', 'totalProduk', 'years', 'isFilterActive'));
    }

    // Menampilkan formulir untuk menambah laporan penjualan baru
    public function create()
    {
        // Mengambil semua data produk untuk pilihan di formulir
        $products = Product::all();
        // Mengembalikan tampilan formulir untuk menambah laporan penjualan
        return view('admin.Laporan.add-penjualan', compact('products'));
    }

    // Menghapus laporan penjualan dari database
    public function destroy($id)
    {
        // Mencari laporan penjualan berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $laporanPenjualan = LaporanPenjualan::findOrFail($id);
        // Menghapus laporan penjualan dari database
        $laporanPenjualan->delete();

        // Mengarahkan kembali ke daftar laporan penjualan dengan pesan sukses
        return redirect()->route('penjualan')->with('success', 'Data Laporan Penjualan berhasil dihapus!');
    }

    // Mengekspor laporan penjualan ke file Excel
    public function export(Request $request)
    {
        // Membuat query dasar untuk laporan penjualan
        $query = LaporanPenjualan::query();
        // Array untuk menyimpan informasi filter untuk nama file
        $filterInfo = [];

        // Menerapkan filter berdasarkan rentang tanggal jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $filterInfo[] = "periode_{$request->start_date}_sampai_{$request->end_date}";
        }

        // Menerapkan filter berdasarkan bulan dan tahun, atau hanya tahun
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('tanggal', $request->month)
                ->whereYear('tanggal', $request->year);
            $filterInfo[] = "bulan_{$request->month}_{$request->year}";
        } elseif ($request->filled('year')) {
            $query->whereYear('tanggal', $request->year);
            $filterInfo[] = "tahun_{$request->year}";
        }

        // Mengambil semua data laporan penjualan berdasarkan filter
        $laporanPenjualan = $query->get();
        // Menghitung total penjualan dari semua data
        $totalPenjualan = $laporanPenjualan->sum('total');

        // Membuat nama file dengan timestamp dan informasi filter
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filterText = !empty($filterInfo) ? '_' . implode('_', $filterInfo) : '';
        $filename = "laporan-penjualan{$filterText}_{$timestamp}.xlsx";

        // Mengekspor data ke file Excel menggunakan kelas LaporanPenjualanExport
        return Excel::download(new LaporanPenjualanExport($laporanPenjualan, $totalPenjualan), $filename);
    }

    // Menyimpan laporan penjualan baru ke database
    public function store(Request $request)
    {
        // Memvalidasi data yang dikirim dari formulir
        $validateData = $request->validate([
            'tanggal' => 'required|date', // Tanggal wajib diisi, harus format tanggal
            'nama_pembeli' => 'required|string', // Nama pembeli wajib diisi
            'nama_produk' => 'required|string', // Nama produk wajib diisi
            'harga_jual' => 'required|numeric', // Harga jual wajib diisi, harus angka
            'jumlah' => 'required|numeric', // Jumlah wajib diisi, harus angka
            'id_product' => 'required|numeric' // ID produk wajib diisi, harus angka
        ]);

        // Memeriksa apakah stok produk mencukupi
        $product = Product::findOrFail($request->id_product);
        if ($product->stok < $request->jumlah) {
            // Mengembalikan ke halaman sebelumnya dengan pesan error jika stok tidak cukup
            return redirect()->back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stok)->withInput();
        }

        // Mengurangi stok produk berdasarkan jumlah yang dijual
        $product->stok -= $request->jumlah;
        $product->save();

        // Menghitung total penjualan (harga jual x jumlah)
        $total = $request->harga_jual * $request->jumlah;
        // Mengonversi nomor telepon ke string
        $no_telp = strval($request->no_telepon);

        // Menyimpan data laporan penjualan baru ke database
        LaporanPenjualan::create([
            'tanggal' => $request->tanggal,
            'no_telepon' => $no_telp,
            'alamat' => $request->alamat,
            'nama_pembeli' => $request->nama_pembeli,
            'nama_produk' => $request->nama_produk,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $product->harga_beli,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'id_product' => $request->id_product
        ]);

        // Mengarahkan kembali ke daftar laporan penjualan dengan pesan sukses
        return redirect()->route('penjualan')->with('success', 'Data penjualan berhasil ditambahkan');
    }

    // Menampilkan pratinjau nota penjualan dalam format PDF di browser
    public function previewNota($id)
    {
        // Mencari laporan penjualan berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $penjualan = LaporanPenjualan::findOrFail($id);
        // Memformat tanggal ke format 'dd/mm/yyyy'
        $tanggal = Carbon::parse($penjualan->tanggal)->format('d/m/Y');
        // Membuat nomor nota dengan format 'NOTA-XXXXX' (ID dengan padding nol)
        $notaNumber = 'NOTA-' . str_pad($penjualan->id, 5, '0', STR_PAD_LEFT);

        // Mengambil data profil perusahaan (dengan ID = 1)
        $dataPerusahaan  = Profile::find(1);
        // Mengambil logo perusahaan dari penyimpanan dan mengubahnya ke format base64
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $imageData = base64_encode(file_get_contents($imagePath));

        // Membuat PDF menggunakan tampilan 'nota-penjualan' dengan data penjualan, tanggal, nomor nota, logo, dan perusahaan
        $pdf = PDF::loadView('admin.Laporan.nota-penjualan', [
            'penjualan' => $penjualan,
            'tanggal' => $tanggal,
            'notaNumber' => $notaNumber,
            'logoImage' => $imageData,
            'data' => $dataPerusahaan
        ]);

        // Mengatur ukuran kertas A4 dengan orientasi portrait
        $pdf->setPaper('A4', 'portrait');
        // Mengatur opsi PDF untuk rendering yang lebih baik
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'isPhpEnabled' => true,
        ]);

        // Menampilkan PDF di browser tanpa memaksa unduh
        return $pdf->stream('nota-penjualan-' . $notaNumber . '.pdf', [
            'Attachment' => false
        ]);
    }

    // Mengunduh nota penjualan dalam format PDF
    public function downloadNotaFile($id)
    {
        // Mencari laporan penjualan berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $penjualan = LaporanPenjualan::findOrFail($id);
        // Memformat tanggal ke format 'dd/mm/yyyy'
        $tanggal = Carbon::parse($penjualan->tanggal)->format('d/m/Y');
        // Membuat nomor nota dengan format 'NOTA-XXXXX' (ID dengan padding nol)
        $notaNumber = 'NOTA-' . str_pad($penjualan->id, 5, '0', STR_PAD_LEFT);

        // Mengambil data profil perusahaan (dengan ID = 1)
        $dataPerusahaan  = Profile::find(1);
        // Mengambil logo perusahaan dari penyimpanan dan mengubahnya ke format base64
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $imageData = base64_encode(file_get_contents($imagePath));

        // Membuat PDF menggunakan tampilan 'nota-penjualan' dengan data penjualan, tanggal, nomor nota, logo, dan perusahaan
        $pdf = PDF::loadView('admin.Laporan.nota-penjualan', [
            'penjualan' => $penjualan,
            'tanggal' => $tanggal,
            'notaNumber' => $notaNumber,
            'logoImage' => $imageData,
            'data' => $dataPerusahaan
        ]);

        // Mengatur ukuran kertas A4 dengan orientasi portrait
        $pdf->setPaper('A4', 'portrait');
        // Mengatur opsi PDF untuk rendering yang lebih baik
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'isPhpEnabled' => true,
        ]);

        // Memaksa unduh PDF dengan nama file sesuai nomor nota
        return $pdf->download('nota-penjualan-' . $notaNumber . '.pdf');
    }
}

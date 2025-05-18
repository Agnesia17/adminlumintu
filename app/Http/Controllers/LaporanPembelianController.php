<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LaporanPembelian;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPembelianExport;

class LaporanPembelianController extends Controller
{
    // Menampilkan daftar laporan pembelian dengan filter dan paginasi
    public function index(Request $request)
    {
        // Membuat query dasar untuk laporan pembelian
        $baseQuery = LaporanPembelian::query();
        // Mengkloning query untuk digunakan dalam filter
        $filteredQuery = clone $baseQuery;

        // Variabel untuk menandakan apakah filter aktif
        $isFilterActive = false;

        // Menerapkan filter berdasarkan rentang tanggal jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $baseQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $isFilterActive = true;
        }

        // Menerapkan filter berdasarkan bulan dan tahun, atau hanya tahun
        if ($request->filled('month') && $request->filled('year')) {
            $baseQuery->whereMonth('tanggal', $request->month)
                ->whereYear('tanggal', $request->year);
            $isFilterActive = true;
        } elseif ($request->filled('year')) {
            $baseQuery->whereYear('tanggal', $request->year);
            $isFilterActive = true;
        }

        // Mengambil data laporan pembelian dengan paginasi (10 data per halaman)
        $laporanPembelian = $baseQuery->paginate(10);

        // Mengambil total jumlah produk yang dibeli, dikelompokkan berdasarkan ID dan nama produk
        $totalProduk = LaporanPembelian::select('id_product', 'nama_produk')
            ->selectRaw('SUM(jumlah) as total_jumlah')
            ->groupBy('id_product', 'nama_produk')
            ->get();

        // Mengambil daftar tahun unik dari kolom tanggal untuk filter
        $years = LaporanPembelian::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Mengembalikan tampilan dengan data laporan, total produk, tahun, dan status filter
        return view('admin.Laporan.pembelian', compact('laporanPembelian', 'totalProduk', 'years', 'isFilterActive'));
    }

    // Menghapus laporan pembelian dari database
    public function destroy($id)
    {
        // Mencari laporan pembelian berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $laporanPembelian = LaporanPembelian::findOrFail($id);
        // Menghapus laporan pembelian dari database
        $laporanPembelian->delete();

        // Mengarahkan kembali ke daftar laporan pembelian dengan pesan sukses
        return redirect()->route('pembelian')->with('success', 'Data Laporan Pembelian berhasil dihapus!');
    }

    // Mengekspor laporan pembelian ke file Excel
    public function export(Request $request)
    {
        // Membuat query dasar untuk laporan pembelian
        $query = LaporanPembelian::query();
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

        // Mengambil semua data laporan pembelian berdasarkan filter
        $laporanPembelian = $query->get();
        // Menghitung total pembelian dari semua data
        $totalPembelian = $laporanPembelian->sum('total');

        // Membuat nama file dengan timestamp dan informasi filter
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filterText = !empty($filterInfo) ? '_' . implode('_', $filterInfo) : '';
        $filename = "laporan-pembelian{$filterText}_{$timestamp}.xlsx";

        // Mengekspor data ke file Excel menggunakan kelas LaporanPembelianExport
        return Excel::download(new LaporanPembelianExport($laporanPembelian, $totalPembelian), $filename);
    }

    // Menampilkan formulir untuk menambah laporan pembelian baru
    public function create()
    {
        // Mengambil semua data produk untuk pilihan di formulir
        $products = Product::all();
        // Mengembalikan tampilan formulir untuk menambah laporan pembelian
        return view('admin.Laporan.add-pembelian', compact('products'));
    }

    // Menyimpan laporan pembelian baru ke database
    public function store(Request $request)
    {
        // Memvalidasi data yang dikirim dari formulir
        $validatedData =  $request->validate([
            'tanggal' => 'required|date', // Tanggal wajib diisi, harus format tanggal
            'nama_supplier' => 'required|string', // Nama supplier wajib diisi
            'nama_produk' => 'required|string', // Nama produk wajib diisi
            'harga_beli' => 'required|numeric', // Harga beli wajib diisi, harus angka
            'jumlah' => 'required|numeric', // Jumlah wajib diisi, harus angka
            'total_numeric' => 'required|numeric', // Total wajib diisi, harus angka
            'id_product' => 'required|numeric' // ID produk wajib diisi, harus angka
        ]);

        // Mencari produk berdasarkan ID untuk memperbarui stok
        $product = Product::findOrFail($request->id_product);
        // Menambah stok produk berdasarkan jumlah yang dibeli
        $product->stok += $request->jumlah;
        $product->save();

        // Menyimpan data laporan pembelian baru ke database
        LaporanPembelian::create([
            'tanggal' => $validatedData['tanggal'],
            'nama_supplier' => $validatedData['nama_supplier'],
            'id_product' => $validatedData['id_product'],
            'nama_produk' => $validatedData['nama_produk'],
            'harga_beli' => $validatedData['harga_beli'],
            'jumlah' => $validatedData['jumlah'],
            'total' => $validatedData['total_numeric'], // Menggunakan nilai total asli
        ]);

        // Mengarahkan kembali ke daftar laporan pembelian dengan pesan sukses
        return redirect()->route('pembelian')->with('success', 'Produk berhasil ditambahkan');
    }

    // Menampilkan pratinjau nota pembelian dalam format PDF di browser
    public function downloadNota($id)
    {
        // Mencari laporan pembelian berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $pembelian = LaporanPembelian::findOrFail($id);
        // Memformat tanggal ke format 'dd/mm/yyyy'
        $tanggal = Carbon::parse($pembelian->tanggal)->format('d/m/Y');
        // Membuat nomor nota dengan format 'NOTA-XXXXX' (ID dengan padding nol)
        $notaNumber = 'NOTA-' . str_pad($pembelian->id, 5, '0', STR_PAD_LEFT);

        // Mengambil data profil perusahaan (dengan ID = 1)
        $dataPerusahaan  = Profile::find(1);
        // Mengambil logo perusahaan dari penyimpanan dan mengubahnya ke format base64
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $imageData = base64_encode(file_get_contents($imagePath));

        // Membuat PDF menggunakan tampilan 'nota-pembelian' dengan data pembelian, tanggal, nomor nota, logo, dan perusahaan
        $pdf = PDF::loadView('admin.Laporan.nota-pembelian', [
            'pembelian' => $pembelian,
            'tanggal' => $tanggal,
            'notaNumber' => $notaNumber,
            'logoImage' => $imageData,
            'data' => $dataPerusahaan
        ]);

        // Mengatur ukuran kertas A4 dengan orientasi portrait
        $pdf->setPaper('A4', 'portrait');

        // Menampilkan PDF di browser tanpa memaksa unduh
        return $pdf->stream('nota-pembelian-' . $notaNumber . '.pdf', [
            'Attachment' => false
        ]);
    }

    // Mengunduh nota pembelian dalam format PDF
    public function downloadNotaFile($id)
    {
        // Mencari laporan pembelian berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $pembelian = LaporanPembelian::findOrFail($id);

        // Memformat tanggal ke format 'dd/mm/yyyy'
        $tanggal = Carbon::parse($pembelian->tanggal)->format('d/m/Y');
        // Membuat nomor nota dengan format 'NOTA-XXXXX' (ID dengan padding nol)
        $notaNumber = 'NOTA-' . str_pad($pembelian->id, 5, '0', STR_PAD_LEFT);

        // Mengambil data profil perusahaan (dengan ID = 1)
        $dataPerusahaan  = Profile::find(1);
        // Mengambil logo perusahaan dari penyimpanan dan mengubahnya ke format base64
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $imageData = base64_encode(file_get_contents($imagePath));

        // Membuat PDF menggunakan tampilan 'nota-pembelian' dengan data pembelian, tanggal, nomor nota, logo, dan perusahaan
        $pdf = PDF::loadView('admin.Laporan.nota-pembelian', [
            'pembelian' => $pembelian,
            'tanggal' => $tanggal,
            'notaNumber' => $notaNumber,
            'logoImage' => $imageData,
            'data' => $dataPerusahaan
        ]);

        // Mengatur ukuran kertas khusus (610x312 poin, sekitar 21.5 cm x 11 cm)
        $pdf->setPaper([0, 0, 610, 312]);

        // Memaksa unduh PDF dengan nama file sesuai nomor nota
        return $pdf->download('nota-pembelian-' . $notaNumber . '.pdf');
    }

    // Menampilkan pratinjau nota pembelian dalam format PDF di browser dengan penanganan error
    public function previewNota($id)
    {
        try {
            // Mencari laporan pembelian berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
            $pembelian = LaporanPembelian::findOrFail($id);
            // Memformat tanggal ke format 'dd/mm/yyyy'
            $tanggal = Carbon::parse($pembelian->tanggal)->format('d/m/Y');
            // Membuat nomor nota dengan format 'NOTA-XXXXX' (ID dengan padding nol)
            $notaNumber = 'NOTA-' . str_pad($pembelian->id, 5, '0', STR_PAD_LEFT);

            // Merender tampilan ke HTML terlebih dahulu
            $html = view('admin.Laporan.nota-pembelian', [
                'pembelian' => $pembelian,
                'tanggal' => $tanggal,
                'notaNumber' => $notaNumber
            ])->render();

            // Membuat PDF dari HTML yang dirender
            $pdf = Pdf::loadHTML($html);
            // Mengatur ukuran kertas khusus (610x312 poin, sekitar 21.5 cm x 11 cm) dengan orientasi portrait
            $pdf->setPaper([0, 0, 610, 312], 'portrait');

            // Menampilkan PDF di browser tanpa memaksa unduh
            return $pdf->stream('nota-pembelian-' . $notaNumber . '.pdf', [
                'Attachment' => false // false = preview, true = download
            ]);
        } catch (\Exception $e) {
            // Mencatat error ke log untuk debugging
            Log::error('PDF Generation Error: ' . $e->getMessage());
            // Mengembalikan ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat generate PDF');
        }
    }
}

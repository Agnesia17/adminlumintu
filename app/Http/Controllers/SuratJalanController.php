<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Profile;
use App\Models\SuratJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class SuratJalanController extends Controller
{
    // Menampilkan daftar Surat Jalan dengan paginasi dan semua produk
    public function index()
    {
        // Mengambil data Surat Jalan dengan paginasi (10 data per halaman)
        $letters = SuratJalan::paginate(10);
        // Mengambil semua data produk dari database
        $products = Product::all();

        // Mengembalikan tampilan untuk menampilkan daftar Surat Jalan dengan data letters dan products
        return view('admin.administrasi.surat-jalan', compact('letters', 'products'));
    }

    // Menampilkan formulir untuk membuat Surat Jalan baru
    public function create()
    {
        // Mengambil ID terakhir untuk membuat nomor Surat Jalan unik
        $lastId = SuratJalan::max('id') + 1;
        // Mengambil bulan dan tahun saat ini untuk format nomor Surat Jalan
        $monthYear = Carbon::now()->format('m/Y');
        // Mengambil semua data produk untuk pilihan di formulir
        $products = Product::all();

        // Membuat nomor Surat Jalan dengan format "SJ/XX/LEP/MM/YYYY"
        $noSurat = "SJ/" . str_pad($lastId, 2, '0', STR_PAD_LEFT) . "/LEP/" . $monthYear;
        // Mengembalikan tampilan formulir untuk membuat Surat Jalan baru dengan nomor dan produk
        return view('admin.administrasi.add-surat-jalan', compact('noSurat', 'products'));
    }

    // Menyimpan Surat Jalan baru ke database
    public function store(Request $request)
    {
        try {
            // Memvalidasi data yang dikirim dari formulir
            $validate = $request->validate([
                'nama_penerima' => 'required|string',
                'nama_produk' => 'required|string',
                'jenis_kendaraan' => 'required',
                'no_pol' => 'required|string',
                'jumlah' => 'required|numeric|min:0',
                'no_surat' => 'required|string',
                'tanggal' => 'required|date',
                'masa' => 'required|date'
            ]);

            // Memformat tanggal ke format 'Y-m-d' untuk disimpan di database
            $tanggalFormatted = date('Y-m-d', strtotime($validate['tanggal']));
            // Menghitung masa berlaku (6 bulan dari tanggal) dan memformatnya
            $masaFormatted = \Carbon\Carbon::parse($tanggalFormatted)->addMonths(6)->format('Y-m-d');

            // Mengambil ID terakhir untuk membuat nomor Surat Jalan unik
            $lastId = SuratJalan::max('id') + 1;
            // Mengambil bulan dan tahun saat ini untuk nomor Surat Jalan
            $monthYear = Carbon::now()->format('m/Y');

            // Membuat nomor Surat Jalan dengan format "SJ/XX/LEP/MM/YYYY"
            $noSurat = "SJ/" . str_pad($lastId, 2, '0', STR_PAD_LEFT) . "/LEP/" . $monthYear;

            // Menyimpan data Surat Jalan baru ke database dengan data yang sudah divalidasi
            SuratJalan::create([
                'nama_penerima' => $validate['nama_penerima'],
                'nama_produk' => $validate['nama_produk'],
                'jenis_kendaraan' => $validate['jenis_kendaraan'],
                'no_pol' => $validate['no_pol'],
                'tanggal' => $tanggalFormatted,
                'masa' => $masaFormatted,
                'jumlah' => $validate['jumlah'],
                'no_surat' => $noSurat,
            ]);

            // Mengarahkan kembali ke daftar Surat Jalan dengan pesan sukses
            return redirect()->route('surat-jalan')->with('success', 'Surat jalan berhasil dibuat.');
        } catch (\Exception $e) {
            // Mencatat error ke log untuk keperluan debugging
            Log::error('Gagal menyimpan surat jalan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all(), // Mencatat data input untuk diperiksa
            ]);

            // Mengarahkan kembali ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan cek log untuk detail.');
        }
    }

    // Memperbarui data Surat Jalan yang sudah ada
    public function update(Request $request, $id)
    {
        // Memvalidasi data yang dikirim dari formulir
        $validate =  $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'jenis_kendaraan' => 'required|string',
            'no_pol' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'masa' => 'required|date',
            'tanggal' => 'required|date'
        ]);

        // Memformat tanggal ke format 'Y-m-d' untuk disimpan di database
        $tanggalFormatted = date('Y-m-d', strtotime($validate['tanggal']));
        // Menghitung masa berlaku (6 bulan dari tanggal) dan memformatnya
        $masaFormatted = \Carbon\Carbon::parse($tanggalFormatted)->addMonths(6)->format('Y-m-d');

        // Mencari Surat Jalan berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $suratJalan = SuratJalan::findOrFail($id);
        // Memperbarui data Surat Jalan dengan data yang sudah divalidasi
        $suratJalan->update([
            'nama_penerima' => $request->nama_penerima,
            'no_pol' => $request->no_pol,
            // 'nama_produk' => $request->nama_produk, // Dikomentari, mungkin tidak diupdate
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'jumlah' => $request->jumlah,
            'tanggal' => $tanggalFormatted,
            'masa' => $masaFormatted
        ]);

        // Mengarahkan kembali ke daftar Surat Jalan dengan pesan sukses
        return redirect()->route('surat-jalan')->with('success', 'Data Surat Jalan Berhasil diperbarui');
    }

    // Menampilkan pratinjau Surat Jalan dalam format PDF di browser
    public function preview($id)
    {
        // Mencari Surat Jalan berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $suratJalan = SuratJalan::findOrFail($id);

        // Memformat tanggal ke format yang mudah dibaca (misalnya, "18 Mei 2025")
        $tanggal = Carbon::parse($suratJalan->tanggal)->format('d F Y');

        // Mengambil data profil perusahaan (dengan ID = 1)
        $dataPerusahaan  = Profile::find(1);
        // Mengambil logo perusahaan dari penyimpanan dan mengubahnya ke format base64 untuk disisipkan di PDF
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $logoImage = base64_encode(file_get_contents($imagePath));

        // Membuat PDF menggunakan tampilan 'view-surat-jalan' dengan data Surat Jalan, tanggal, logo, dan perusahaan
        $pdf = PDF::loadView('admin.administrasi.view-surat-jalan', [
            'suratJalan' => $suratJalan,
            'tanggal' => $tanggal,
            'logoImage' => $logoImage,
            'data' => $dataPerusahaan
        ]);

        // Mengatur ukuran kertas khusus untuk PDF (610x312 poin)
        $pdf->setPaper([0, 0, 610, 312]);

        // Mengganti karakter slash di no_surat untuk membuat nama file yang aman
        $cleanFileName = str_replace(['/', '\\'], '-', $suratJalan->no_surat);

        // Menampilkan PDF di browser tanpa memaksa unduh
        return $pdf->stream('surat-jalan-' . $cleanFileName . '.pdf', [
            'Attachment' => false
        ]);
    }

    // Mengunduh Surat Jalan dalam format PDF
    public function download($id)
    {
        // Mencari Surat Jalan berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $suratJalan = SuratJalan::findOrFail($id);

        // Memformat tanggal ke format yang mudah dibaca (misalnya, "18 Mei 2025")
        $tanggal = Carbon::parse($suratJalan->tanggal)->format('d F Y');

        // Mengambil data profil perusahaan (dengan ID = 1)
        $dataPerusahaan  = Profile::find(1);
        // Mengambil logo perusahaan dari penyimpanan dan mengubahnya ke format base64 untuk disisipkan di PDF
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $logoImage = base64_encode(file_get_contents($imagePath));

        // Membuat PDF menggunakan tampilan 'view-surat-jalan' dengan data Surat Jalan, tanggal, logo, dan perusahaan
        $pdf = PDF::loadView('admin.administrasi.view-surat-jalan', [
            'suratJalan' => $suratJalan,
            'tanggal' => $tanggal,
            'logoImage' => $logoImage,
            'data' => $dataPerusahaan
        ]);

        // Mengatur ukuran kertas khusus untuk PDF (610x312 poin)
        $pdf->setPaper([0, 0, 610, 312]);

        // Mengganti karakter slash di no_surat untuk membuat nama file yang aman
        $cleanFileName = str_replace(['/', '\\'], '-', $suratJalan->no_surat);

        // Memaksa unduh PDF dengan nama file yang ditentukan
        return $pdf->download('surat-jalan-' . $cleanFileName . '.pdf');
    }
}

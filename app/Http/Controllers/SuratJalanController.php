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

    public function index()
    {
        $letters = SuratJalan::paginate(10);
        $products = Product::all();

        return view('admin.administrasi.surat-jalan', compact('letters', 'products'));
    }

    public function create()
    {
        $lastId = SuratJalan::max('id') + 1;
        $monthYear = Carbon::now()->format('m/Y');
        $products = Product::all();

        $noSurat = "SJ/" . str_pad($lastId, 2, '0', STR_PAD_LEFT) . "/LEP/" . $monthYear;
        return view('admin.administrasi.add-surat-jalan', compact('noSurat', 'products'));
    }

    public function store(Request $request)
    {
        try {
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

            $tanggalFormatted = date('Y-m-d', strtotime($validate['tanggal']));
            $masaFormatted = \Carbon\Carbon::parse($tanggalFormatted)->addMonths(6)->format('Y-m-d');

            // Ambil ID terakhir
            $lastId = SuratJalan::max('id') + 1;
            $monthYear = Carbon::now()->format('m/Y');

            // Buat format No Surat
            $noSurat = "SJ/" . str_pad($lastId, 2, '0', STR_PAD_LEFT) . "/LEP/" . $monthYear;



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

            return redirect()->route('surat-jalan')->with('success', 'Surat jalan berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan surat jalan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all(), // supaya bisa lihat inputan
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan cek log untuk detail.');
        }
    }

    public function update(Request $request, $id)
    {
        $validate =  $request->validate([
            'nama_penerima' => 'required|string|max:255',
            // 'nama_produk' => 'required|string',
            'jenis_kendaraan' => 'required|string',
            'no_pol' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'masa' => 'required|date',
            'tanggal' => 'required|date'
        ]);

        $tanggalFormatted = date('Y-m-d', strtotime($validate['tanggal']));
        $masaFormatted = \Carbon\Carbon::parse($tanggalFormatted)->addMonths(6)->format('Y-m-d');

        $suratJalan = SuratJalan::findOrFail($id);
        $suratJalan->update([
            'nama_penerima' => $request->nama_penerima,
            'no_pol' => $request->no_pol,
            // 'nama_produk' => $request->nama_produk,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'jumlah' => $request->jumlah,
            'tanggal' => $tanggalFormatted,
            'masa' => $masaFormatted
        ]);

        return redirect()->route('surat-jalan')->with('success', 'Data Surat Jalan Berhasil diperbarui');
    }

    public function preview($id)
    {
        $suratJalan = SuratJalan::findOrFail($id);

        // Format tanggal
        $tanggal = Carbon::parse($suratJalan->tanggal)->format('d F Y');

        $dataPerusahaan  = Profile::find(1);
        // Get logo image
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $logoImage = base64_encode(file_get_contents($imagePath));



        $pdf = PDF::loadView('admin.administrasi.view-surat-jalan', [
            'suratJalan' => $suratJalan,
            'tanggal' => $tanggal,
            'logoImage' => $logoImage,
            'data' => $dataPerusahaan
        ]);

        // Set specific paper dimensions as requested
        $pdf->setPaper([0, 0, 610, 312]);

        $cleanFileName = str_replace(['/', '\\'], '-', $suratJalan->no_surat);

        return $pdf->stream('surat-jalan-' . $cleanFileName . '.pdf', [
            'Attachment' => false
        ]);
    }

    public function download($id)
    {
        $suratJalan = SuratJalan::findOrFail($id);

        // Format tanggal
        $tanggal = Carbon::parse($suratJalan->tanggal)->format('d F Y');

        // Get logo image
        $dataPerusahaan  = Profile::find(1);
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $logoImage = base64_encode(file_get_contents($imagePath));

        $pdf = PDF::loadView('admin.administrasi.view-surat-jalan', [
            'suratJalan' => $suratJalan,
            'tanggal' => $tanggal,
            'logoImage' => $logoImage,
            'data' => $dataPerusahaan
        ]);

        // Set specific paper dimensions as requested
        $pdf->setPaper([0, 0, 610, 312]);

        $cleanFileName = str_replace(['/', '\\'], '-', $suratJalan->no_surat);

        return $pdf->download('surat-jalan-' . $cleanFileName . '.pdf');
    }
}

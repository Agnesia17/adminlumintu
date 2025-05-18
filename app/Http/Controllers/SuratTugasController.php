<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Profile;
use App\Models\SuratTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class SuratTugasController extends Controller
{
    // menampilkan halaman surat tugas
    public function index()
    {
        $letters = SuratTugas::paginate(10);

        return view('admin.administrasi.surat-tugas', compact('letters'));
    }

    // menampilkan halaman tambah surat tugas
    public function create()
    {
        $lastId = SuratTugas::max('id') + 1;
        $monthYear = Carbon::now()->format('m/Y');
        // membuat nomer surat
        $noSurat = "ST/" . str_pad($lastId, 2, '0', STR_PAD_LEFT) . "/LEP/" . $monthYear;
        return view('admin.administrasi.add-surat', compact('noSurat'));
    }

    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'nama' => 'required|string',
                'no_ktp' => 'required|digits:16',
                'no_surat' => 'required|string',
                'alamat' => 'required|string',
                'masa' => 'required|date',
                'tanggal' => 'required|date'
            ]);
            // mendapatkan tanggal sekarang dan konversi
            $tanggalFormatted = date('Y-m-d', strtotime($validate['tanggal']));
            $masaFormatted = \Carbon\Carbon::parse($tanggalFormatted)->addMonths(6)->format('Y-m-d');

            // Ambil ID terakhir
            $lastId = SuratTugas::max('id') + 1;
            $monthYear = Carbon::now()->format('m/Y');

            // Buat format No Surat
            $noSurat = "ST/" . str_pad($lastId, 2, '0', STR_PAD_LEFT) . "/LEP/" . $monthYear;

            // fungsi menambahkan surat tugas ke database
            SuratTugas::create([
                'nama' => $validate['nama'],
                'no_ktp' => $validate['no_ktp'],
                'alamat' => $validate['alamat'],
                'tanggal' => $tanggalFormatted,
                'masa' => $masaFormatted, // Tidak ambil dari request
                'no_surat' => $noSurat,
            ]);
            // mengembbalikan ke dalam halaman surat tugas
            return redirect()->route('surat-tugas')->with('success', 'Surat tugas berhasil dibuat.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage()); // Pastikan error ditampilkan
        }
    }

    // menampilkan review surat tugas
    public function preview($id)
    {
        $suratTugas = SuratTugas::findOrFail($id);

        // Format tanggal
        $tanggal = Carbon::parse($suratTugas->tanggal)->format('d F Y');

        $dataPerusahaan  = Profile::find(1);
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $logoImage = base64_encode(file_get_contents($imagePath));

        $pdf = PDF::loadView('admin.administrasi.view-surat-tugas', [
            'suratTugas' => $suratTugas,
            'tanggal' => $tanggal,
            'logoImage' => $logoImage,
            'data' => $dataPerusahaan
        ]);

        $pdf->setPaper('A4', 'portrait');

        $cleanFileName = str_replace(['/', '\\'], '-', $suratTugas->no_surat);

        return $pdf->stream('surat-tugas-' . $cleanFileName . '.pdf', [
            'Attachment' => false
        ]);
    }
    // fungsi untuk download surat ke perangkat
    public function download($id)
    {
        $suratTugas = SuratTugas::findOrFail($id);

        // Format tanggal
        $tanggal = Carbon::parse($suratTugas->tanggal)->format('d F Y');
        // mendapatkan data company dari database
        $dataPerusahaan  = Profile::find(1);

        // load gambar
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $logoImage = base64_encode(file_get_contents($imagePath));


        $pdf = PDF::loadView('admin.administrasi.view-surat-tugas', [
            'suratTugas' => $suratTugas,
            'tanggal' => $tanggal,
            'logoImage' => $logoImage,
            'data' => $dataPerusahaan
        ]);

        $pdf->setPaper('A4', 'portrait');
        // format nama
        $cleanFileName = str_replace(['/', '\\'], '-', $suratTugas->no_surat);

        // Force download
        return $pdf->download('surat-tugas-' . $cleanFileName . '.pdf');
    }

    // fungsi ubah data dari surat tugas
    public function update(Request $request, $id)
    {
        // validasi data yang dimasukkan
        $validate =  $request->validate([
            'nama' => 'required|string|max:255',
            'no_ktp' => 'required|numeric',
            'alamat' => 'required|string',
            'masa' => 'required|date',
            'tanggal' => 'required|date'
        ]);
        // format tanggal
        $tanggalFormatted = date('Y-m-d', strtotime($validate['tanggal']));
        $masaFormatted = \Carbon\Carbon::parse($tanggalFormatted)->addMonths(6)->format('Y-m-d');

        $suratTugas = SuratTugas::findOrFail($id);
        // fungsi ubah data yang diperlukan
        $suratTugas->update([
            'nama' => $request->nama,
            'no_ktp' => $request->no_ktp,
            'alamat' => $request->alamat,
            'tanggal' => $tanggalFormatted,
            'masa' => $masaFormatted
        ]);

        return redirect()->route('surat-tugas')->with('success', 'Data Surat Tugas Berhasil diperbarui');
    }
}

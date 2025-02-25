<?php

namespace App\Http\Controllers;

use Exception;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SuratTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class SuratTugasController extends Controller
{
    //
    public function index()
    {
        $letters = SuratTugas::paginate(10);

        return view('admin.administrasi.surat-tugas', compact('letters'));
    }

    public function create()
    {
        $lastId = SuratTugas::max('id') + 1;
        $monthYear = Carbon::now()->format('m/Y');

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

            $tanggalFormatted = date('Y-m-d', strtotime($validate['tanggal']));
            $masaFormatted = \Carbon\Carbon::parse($tanggalFormatted)->addMonths(6)->format('Y-m-d');

            // Ambil ID terakhir
            $lastId = SuratTugas::max('id') + 1;
            $monthYear = Carbon::now()->format('m/Y');

            // Buat format No Surat
            $noSurat = "ST/" . str_pad($lastId, 2, '0', STR_PAD_LEFT) . "/LEP/" . $monthYear;
            // dd($validate);
            // dump($validate);

            SuratTugas::create([
                'nama' => $validate['nama'],
                'no_ktp' => $validate['no_ktp'],
                'alamat' => $validate['alamat'],
                'tanggal' => $tanggalFormatted,
                'masa' => $masaFormatted, // Tidak ambil dari request
                'no_surat' => $noSurat,
            ]);

            return redirect()->route('surat-tugas')->with('success', 'Surat tugas berhasil dibuat.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage()); // Pastikan error ditampilkan
        }
    }

    public function preview($id)
    {
        $suratTugas = SuratTugas::findOrFail($id);

        // Format tanggal
        $tanggal = Carbon::parse($suratTugas->tanggal)->format('d F Y');

        // Get logo image
        $imagePath = public_path('sbadmin/img/cvlumintu.png');
        $logoImage = base64_encode(file_get_contents($imagePath));

        $pdf = PDF::loadView('admin.administrasi.view-surat-tugas', [
            'suratTugas' => $suratTugas,
            'tanggal' => $tanggal,
            'logoImage' => $logoImage
        ]);

        $pdf->setPaper('A4', 'portrait');

        $cleanFileName = str_replace(['/', '\\'], '-', $suratTugas->no_surat);

        return $pdf->stream('surat-tugas-' . $cleanFileName . '.pdf', [
            'Attachment' => false
        ]);
    }

    public function download($id)
    {
        $suratTugas = SuratTugas::findOrFail($id);

        // Format tanggal
        $tanggal = Carbon::parse($suratTugas->tanggal)->format('d F Y');

        // Get logo image
        $imagePath = public_path('sbadmin/img/cvlumintu.png');
        $logoImage = base64_encode(file_get_contents($imagePath));

        $pdf = PDF::loadView('admin.administrasi.view-surat-tugas', [
            'suratTugas' => $suratTugas,
            'tanggal' => $tanggal,
            'logoImage' => $logoImage
        ]);

        $pdf->setPaper('A4', 'portrait');

        $cleanFileName = str_replace(['/', '\\'], '-', $suratTugas->no_surat);

        // Force download
        return $pdf->download('nota-pembelian-' . $cleanFileName . '.pdf');
    }
}

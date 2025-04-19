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

    public function index(Request $request)
    {
        $baseQuery = LaporanPembelian::query();
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

        $laporanPembelian = $baseQuery->paginate(10);

        $totalProduk = LaporanPembelian::select('id_product', 'nama_produk')
            ->selectRaw('SUM(jumlah) as total_jumlah')
            ->groupBy('id_product', 'nama_produk')
            ->get();

        $years = LaporanPembelian::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.Laporan.pembelian', compact('laporanPembelian', 'totalProduk', 'years'));
    }

    public function export(Request $request)
    {
        $query = LaporanPembelian::query();
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

        $laporanPembelian = $query->get();
        $totalPembelian = $laporanPembelian->sum('total');

        // Buat nama file dengan informasi filter
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filterText = !empty($filterInfo) ? '_' . implode('_', $filterInfo) : '';
        $filename = "laporan-pembelian{$filterText}_{$timestamp}.xlsx";

        return Excel::download(new LaporanPembelianExport($laporanPembelian, $totalPembelian), $filename);
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.Laporan.add-pembelian', compact('products'));
    }

    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'tanggal' => 'required|date',
            'nama_supplier' => 'required|string',
            'nama_produk' => 'required|string',
            'harga_beli' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'total_numeric' => 'required|numeric',
            'id_product' => 'required|numeric'
        ]);

        $product = Product::findOrFail($request->id_product);
        $product->stok += $request->jumlah;
        $product->save();

        LaporanPembelian::create([
            'tanggal' => $validatedData['tanggal'],
            'nama_supplier' => $validatedData['nama_supplier'],
            'id_product' => $validatedData['id_product'],
            'nama_produk' => $validatedData['nama_produk'],
            'harga_beli' => $validatedData['harga_beli'],
            'jumlah' => $validatedData['jumlah'],
            'total' => $validatedData['total_numeric'], // Gunakan angka asli
        ]);

        return redirect()->route('pembelian')->with('success', 'Produk berhasil ditambahkan');
    }

    public function downloadNota($id)
    {
        $pembelian = LaporanPembelian::findOrFail($id);
        $tanggal = Carbon::parse($pembelian->tanggal)->format('d/m/Y');
        $notaNumber = 'NOTA-' . str_pad($pembelian->id, 5, '0', STR_PAD_LEFT);

        $dataPerusahaan  = Profile::find(1);
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $imageData = base64_encode(file_get_contents($imagePath));

        $pdf = PDF::loadView('admin.Laporan.nota-pembelian', [
            'pembelian' => $pembelian,
            'tanggal' => $tanggal,
            'notaNumber' => $notaNumber,
            'logoImage' => $imageData,
            'data' => $dataPerusahaan
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('nota-pembelian-' . $notaNumber . '.pdf', [
            'Attachment' => false
        ]);
    }

    // Add a new method for direct download if needed
    public function downloadNotaFile($id)
    {
        $pembelian = LaporanPembelian::findOrFail($id);

        $tanggal = Carbon::parse($pembelian->tanggal)->format('d/m/Y');
        $notaNumber = 'NOTA-' . str_pad($pembelian->id, 5, '0', STR_PAD_LEFT);

        $dataPerusahaan  = Profile::find(1);
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $imageData = base64_encode(file_get_contents($imagePath));

        $pdf = PDF::loadView('admin.Laporan.nota-pembelian', [
            'pembelian' => $pembelian,
            'tanggal' => $tanggal,
            'notaNumber' => $notaNumber,
            'logoImage' => $imageData,
            'data' => $dataPerusahaan
        ]);

        // $pdf->setPaper('A4');
        $pdf->setPaper([0, 0, 610, 312]); // Ukuran dalam poin (21.5 cm x 11 cm)


        // Force download
        return $pdf->download('nota-pembelian-' . $notaNumber . '.pdf');
    }

    public function previewNota($id)
    {
        try {
            $pembelian = LaporanPembelian::findOrFail($id);
            $tanggal = Carbon::parse($pembelian->tanggal)->format('d/m/Y');
            $notaNumber = 'NOTA-' . str_pad($pembelian->id, 5, '0', STR_PAD_LEFT);

            // Render view ke HTML dulu
            $html = view('admin.Laporan.nota-pembelian', [
                'pembelian' => $pembelian,
                'tanggal' => $tanggal,
                'notaNumber' => $notaNumber
            ])->render();

            // Debug: cek output HTML
            // return $html;

            // Buat PDF
            $pdf = Pdf::loadHTML($html);
            // $pdf->setPaper('A4', 'portrait');
            $pdf->setPaper([0, 0, 610, 312], 'portrait');


            // Stream dengan nama file
            return $pdf->stream('nota-pembelian-' . $notaNumber . '.pdf', [
                'Attachment' => false // false = preview, true = download
            ]);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat generate PDF');
        }
    }
}

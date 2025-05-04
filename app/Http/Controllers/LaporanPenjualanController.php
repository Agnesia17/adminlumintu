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

    public function index(Request $request)
    {
        $baseQuery = LaporanPenjualan::query();
        $filteredQuery = clone $baseQuery;

        $isFilterActive = false;

        // Terapkan filter jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $baseQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $filteredQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $isFilterActive = true;
        }

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

        $laporanPenjualan = $baseQuery->paginate(10);

        $totalProduk = LaporanPenjualan::select('id_product', 'nama_produk')
            ->selectRaw('SUM(jumlah) as total_jumlah')
            ->groupBy('id_product', 'nama_produk')
            ->get();

        $years = LaporanPenjualan::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.Laporan.penjualan', compact('laporanPenjualan', 'totalProduk', 'years', 'isFilterActive'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.Laporan.add-penjualan', compact('products'));
    }

    public function destroy($id)
    {
        $laporanPenjualan = LaporanPenjualan::findOrFail($id);
        $laporanPenjualan->delete();

        return redirect()->route('penjualan')->with('success', 'Data Laporan Penjualan berhasil dihapus!');
    }

    public function export(Request $request)
    {
        $query = LaporanPenjualan::query();
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

        $laporanPenjualan = $query->get();
        $totalPenjualan = $laporanPenjualan->sum('total');

        // Buat nama file dengan informasi filter
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filterText = !empty($filterInfo) ? '_' . implode('_', $filterInfo) : '';
        $filename = "laporan-penjualan{$filterText}_{$timestamp}.xlsx";

        return Excel::download(new LaporanPenjualanExport($laporanPenjualan, $totalPenjualan), $filename);
    }

    public function store(Request $request)
    {

        $validateData = $request->validate([
            'tanggal' => 'required|date',
            'nama_pembeli' => 'required|string',
            'nama_produk' => 'required|string',
            'harga_jual' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'id_product' => 'required|numeric'
        ]);

        // Check if product has enough stock
        $product = Product::findOrFail($request->id_product);

        if ($product->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stok)->withInput();
        }

        // Reduce stock
        $product->stok -= $request->jumlah;
        $product->save();

        // Calculate total
        $total = $request->harga_jual * $request->jumlah;
        $no_telp = strval($request->no_telepon);

        LaporanPenjualan::create([
            'tanggal' => $request->tanggal,
            'no_telepon' =>   $no_telp,
            'alamat' => $request->alamat,
            'nama_pembeli' => $request->nama_pembeli,
            'nama_produk' => $request->nama_produk,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $product->harga_beli,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'id_product' => $request->id_product
        ]);

        return redirect()->route('penjualan')->with('success', 'Data penjualan berhasil ditambahkan');
    }

    public function previewNota($id)
    {
        $penjualan = LaporanPenjualan::findOrFail($id);
        $tanggal = Carbon::parse($penjualan->tanggal)->format('d/m/Y');
        $notaNumber = 'NOTA-' . str_pad($penjualan->id, 5, '0', STR_PAD_LEFT);

        $dataPerusahaan  = Profile::find(1);
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $imageData = base64_encode(file_get_contents($imagePath));

        $pdf = PDF::loadView('admin.Laporan.nota-penjualan', [
            'penjualan' => $penjualan,
            'tanggal' => $tanggal,
            'notaNumber' => $notaNumber,
            'logoImage' => $imageData,
            'data' => $dataPerusahaan
        ]);

        // Set specific options for better rendering
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'isPhpEnabled' => true,
        ]);

        return $pdf->stream('nota-penjualan-' . $notaNumber . '.pdf', [
            'Attachment' => false
        ]);
    }

    // Add a new method for direct download if needed
    public function downloadNotaFile($id)
    {
        $penjualan = LaporanPenjualan::findOrFail($id);
        $tanggal = Carbon::parse($penjualan->tanggal)->format('d/m/Y');
        $notaNumber = 'NOTA-' . str_pad($penjualan->id, 5, '0', STR_PAD_LEFT);

        $dataPerusahaan  = Profile::find(1);
        $imagePath = public_path('storage/logos/' . $dataPerusahaan->logo_company);
        $imageData = base64_encode(file_get_contents($imagePath));

        $pdf = PDF::loadView('admin.Laporan.nota-penjualan', [
            'penjualan' => $penjualan,
            'tanggal' => $tanggal,
            'notaNumber' => $notaNumber,
            'logoImage' => $imageData,
            'data' => $dataPerusahaan
        ]);

        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'isPhpEnabled' => true,
        ]);


        // Force download
        return $pdf->download('nota-penjualan-' . $notaNumber . '.pdf');
    }
}

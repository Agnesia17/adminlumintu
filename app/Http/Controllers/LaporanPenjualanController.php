<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\LaporanPenjualan;
use App\Http\Controllers\Controller;

class LaporanPenjualanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_product' => 'required|exists:product,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->id_product);

        if ($request->jumlah > $product->stok) {
            return back()->with('error', 'Stok tidak mencukupi untuk penjualan ini.');
        }

        // Kurangi stok setelah penjualan
        $product->stok -= $request->jumlah;
        $product->save();

        LaporanPenjualan::create([
            'tanggal' => now(),
            'nama_pembeli' => $request->nama_pembeli,
            'nama_produk' => $product->nama_produk,
            'harga_jual' => $product->harga_jual,
            'jumlah' => $request->jumlah,
            'total' => $request->jumlah * $product->harga_jual,
            'id_product' => $request->id_product,
        ]);

        return redirect()->back()->with('success', 'Penjualan berhasil!');
    }
}

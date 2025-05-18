<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
    // Menampilkan daftar produk dengan paginasi
    public function index()
    {
        // Mengambil semua data produk dari database dengan paginasi (10 data per halaman)
        $products = Product::paginate(10);

        // Mengirim data produk ke tampilan 'admin.product.product'
        return view('admin.product.product', compact('products'));
    }

    // Menampilkan formulir untuk membuat produk baru
    public function create()
    {
        // Mengembalikan tampilan formulir untuk menambah produk baru
        return view('admin.product.addproduct');
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        // Memvalidasi data yang dikirim dari formulir
        $request->validate([
            'nama_produk' => 'required|string|max:255', // Nama produk wajib diisi, maksimal 255 karakter
            'harga_beli' => 'required|numeric', // Harga beli wajib diisi, harus angka
            'harga_jual' => 'required|numeric', // Harga jual wajib diisi, harus angka
        ]);

        // Memeriksa apakah harga beli lebih tinggi dari harga jual
        if ($request->harga_beli > $request->harga_jual) {
            // Mengembalikan ke halaman sebelumnya dengan pesan error jika harga beli lebih tinggi
            return redirect()->back()->with('error', 'Harga beli tidak boleh lebih tinggi dari harga jual');
        }

        // Menyimpan data produk baru ke database
        Product::create([
            'nama_produk' => $request->nama_produk,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        // Mengarahkan kembali ke daftar produk dengan pesan sukses
        return redirect()->route('product')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Memperbarui data produk yang sudah ada
    public function update(Request $request, $id)
    {
        // Memvalidasi data yang dikirim dari formulir
        $request->validate([
            'nama_produk' => 'required|string|max:255', // Nama produk wajib diisi, maksimal 255 karakter
            'harga_beli' => 'required|numeric', // Harga beli wajib diisi, harus angka
            'harga_jual' => 'required|numeric', // Harga jual wajib diisi, harus angka
        ]);

        // Mencari produk berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $produk = Product::findOrFail($id);

        // Memeriksa apakah harga beli lebih tinggi dari harga jual
        if ($request->harga_beli > $request->harga_jual) {
            // Mengembalikan ke halaman sebelumnya dengan pesan error, data input sebelumnya, dan ID produk untuk edit
            return redirect()->back()
                ->withErrors(['harga_beli' => 'Harga beli tidak boleh lebih tinggi dari harga jual'])
                ->withInput()
                ->with('edit_id', $id);
        }

        // Memperbarui data produk dengan data yang sudah divalidasi
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        // Mengarahkan kembali ke daftar produk dengan pesan sukses
        return redirect()->route('product')->with('success', 'Produk Berhasil diperbarui');
    }

    // Menghapus produk dari database
    public function destroy($id)
    {
        // Mencari produk berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $product = Product::findOrFail($id);
        // Menghapus produk dari database
        $product->delete();

        // Mengarahkan kembali ke daftar produk dengan pesan sukses
        return redirect()->route('product')->with('success', 'Produk berhasil dihapus!');
    }
}

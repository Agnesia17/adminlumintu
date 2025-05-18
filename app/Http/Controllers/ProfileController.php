<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // menampilkan halaman profil
    public function index()
    {
        // mengambil data profil
        $data = Profile::find(1);
        // menampilkan halaman profil dengan data profil
        return view('admin.profil', compact('data'));
    }

    // Memperbarui data profil perusahaan berdasarkan ID
    public function update(Request $request, $id)
    {
        // Mencari data profil berdasarkan ID, jika tidak ditemukan akan memunculkan error 404
        $profile = Profile::findOrFail($id);

        // Memvalidasi data yang dikirim dari formulir
        $validatedData = $request->validate([
            'company' => 'required|string|max:255', // Nama perusahaan wajib diisi, maksimal 255 karakter
            'alamat_company' => 'required|string', // Alamat perusahaan wajib diisi
            'no_telp' => 'required|string|max:15', // Nomor telepon wajib diisi, maksimal 15 karakter
            'email_company' => 'required|email|max:255', // Email perusahaan wajib diisi, harus format email valid, maksimal 255 karakter
            'owner' => 'required|string|max:255', // Nama pemilik wajib diisi, maksimal 255 karakter
            'logo_company' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Logo perusahaan opsional, harus gambar (jpeg, png, jpg), maksimal 2MB
        ]);

        // Menangani unggahan file logo hanya jika ada file baru yang dipilih
        if ($request->hasFile('logo_company')) {
            // Menghapus logo lama dari penyimpanan jika ada
            if ($profile->logo_company) {
                Storage::disk('public')->delete('logos/' . $profile->logo_company);
            }

            // Menyimpan logo baru di direktori 'logos' pada disk public
            $file = $request->file('logo_company');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Membuat nama file unik dengan timestamp
            $file->storeAs('logos', $fileName, 'public');

            // Memperbarui kolom logo_company dengan nama file baru
            $profile->logo_company = $fileName;
        }

        // Memperbarui data profil dengan data yang sudah divalidasi
        $profile->company = $validatedData['company'];
        $profile->alamat_company = $validatedData['alamat_company'];
        $profile->no_telp = $validatedData['no_telp'];
        $profile->email_company = $validatedData['email_company'];
        $profile->owner = $validatedData['owner'];

        // Menyimpan perubahan ke database
        $profile->save();

        // Mengarahkan kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile')->with('success', 'Data Profil Berhasil Diubah');
    }
}

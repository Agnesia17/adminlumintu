<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $data = Profile::find(1);
        return view('admin.profil', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        $validatedData = $request->validate([
            'company' => 'required|string|max:255',
            'alamat_company' => 'required|string',
            'no_telp' => 'required|string|max:15',
            'email_company' => 'required|email|max:255',
            'owner' => 'required|string|max:255',
            'logo_company' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file upload only if a new file is selected
        if ($request->hasFile('logo_company')) {
            // Delete old image if exists
            if ($profile->logo_company) {
                Storage::disk('public')->delete('logos/' . $profile->logo_company);
            }

            // Store the new image in public disk
            $file = $request->file('logo_company');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('logos', $fileName, 'public');

            $profile->logo_company = $fileName;
        }

        $profile->company = $validatedData['company'];
        $profile->alamat_company = $validatedData['alamat_company'];
        $profile->no_telp = $validatedData['no_telp'];
        $profile->email_company = $validatedData['email_company'];
        $profile->owner = $validatedData['owner'];

        $profile->save();

        // Flash a success message
        return redirect()->route('profile')->with('success', 'Data Profil Berhasil Diubah');
    }
}

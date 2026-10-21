<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id_user, 'id_user'),
            ],
            'nama' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        // Update nama di relasi mahasiswa atau dosen
        if ($user->mahasiswa) {
            $user->mahasiswa->nama = $request->nama;
            $user->mahasiswa->save();
        } elseif ($user->dosen) {
            $user->dosen->nama = $request->nama;
            $user->dosen->save();
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && file_exists(public_path('profile/admin/' . $user->foto))) {
                unlink(public_path('profile/admin/' . $user->foto));
            }

            // Buat direktori jika belum ada
            if (!file_exists(public_path('profile/admin'))) {
                mkdir(public_path('profile/admin'), 0755, true);
            }

            // Simpan file baru
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('profile/admin'), $fileName);

            $user->foto = $fileName;
        }

        $user->save();

        return response()->json([
            'message' => 'Profil berhasil diperbarui.'
        ]);
    }
}

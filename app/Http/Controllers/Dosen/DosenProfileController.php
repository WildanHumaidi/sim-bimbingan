<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\FakController;

class DosenProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $fakultasList = FakController::$listFakultas;

        return view('dosen.profile', compact('user', 'fakultasList'));
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
            'fakultas' => 'required|string|in:'.implode(',', FakController::$listFakultas),
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        if ($user->mahasiswa) {
            $user->mahasiswa->nama = $request->nama;
            $user->mahasiswa->fakultas = $request->fakultas;
            $user->mahasiswa->save();
        } elseif ($user->dosen) {
            $user->dosen->nama = $request->nama;
            $user->dosen->fakultas = $request->fakultas;
            $user->dosen->save();
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && file_exists(public_path($user->foto))) {
                unlink(public_path($user->foto));
            }

            // Simpan foto baru di public/profile/dosen/
            $file = $request->file('foto');
            $fileName = time().'_'.$file->getClientOriginalName();

            // Buat direktori jika belum ada
            if (!file_exists(public_path('profile/dosen'))) {
                mkdir(public_path('profile/dosen'), 0777, true);
            }

            $file->move(public_path('profile/dosen'), $fileName);
            $user->foto = $fileName;
        }

        $user->save();

        return redirect()->route('dosen.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}

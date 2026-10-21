<?php

namespace App\Http\Controllers\Mhs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MhsProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('mhs.profile', compact('user'));
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

        if ($user->mahasiswa) {
            $user->mahasiswa->nama = $request->nama;
            $user->mahasiswa->save();
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $uploadPath = public_path('profile/mhs');

            // Create directory if not exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Delete old photo if exists
            if ($user->foto && file_exists($uploadPath.'/'.$user->foto)) {
                unlink($uploadPath.'/'.$user->foto);
            }

            // Generate unique filename
            $fileName = 'mhs_'.$user->id_user.'_'.time().'.'.$request->file('foto')->getClientOriginalExtension();

            // Move uploaded file
            $request->file('foto')->move($uploadPath, $fileName);

            // Save only the filename in database
            $user->foto = $fileName;
        }

        $user->save();

        return redirect()->route('mhs.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}

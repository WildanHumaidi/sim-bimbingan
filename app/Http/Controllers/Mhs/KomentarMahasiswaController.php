<?php

namespace App\Http\Controllers\Mhs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Bimbingan;
use App\Models\KomentarBimbingan;

class KomentarMahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:3'); // Role 3 = Mahasiswa
    }

    /**
     * Menyimpan komentar baru dari mahasiswa
     */
    public function store(Request $request, $id_bimbingan)
    {
        $user = Auth::user();

        if (!$user->mahasiswa) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'komentar' => 'required|string|min:1|max:2000',
            'lampiran_url' => 'nullable|url|max:255'
        ]);

        try {
            $bimbingan = Bimbingan::where('nim', $user->mahasiswa->id_nim)
                ->where('id_bimbingan', $id_bimbingan)
                ->firstOrFail();

            KomentarBimbingan::create([
                'id_bimbingan' => $bimbingan->id_bimbingan,
                'id_pengirim' => $user->id_user,
                'isi_komentar' => $request->komentar,
                'tipe_pengirim' => 'mahasiswa',
                'waktu_kirim' => now(),
                'lampiran_url' => $request->lampiran_url
                // Kolom `parent_id` dihapus karena tidak ada fitur reply
            ]);

            $bimbingan->touch();

            return redirect()
                ->route('mhs.bimbingan.show', $bimbingan->id_bimbingan)
                ->with('success', 'Komentar berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan komentar mahasiswa: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan komentar: ' . $e->getMessage());
        }
    }
}

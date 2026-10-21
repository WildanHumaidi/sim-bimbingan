<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\KomentarBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KomentarBimbinganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:2'); // Role 2 = Dosen
    }

    /**
     * Menyimpan komentar baru dari dosen
     */
    public function store(Request $request, $id_bimbingan)
    {
        $user = Auth::user();

        if (!$user->dosen) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'komentar' => 'required|string|min:1|max:2000',
            'lampiran_url' => 'nullable|url|max:255'
        ]);

        try {
            $bimbingan = Bimbingan::where('nidn', $user->dosen->id_nidn)
                ->where('id_bimbingan', $id_bimbingan)
                ->firstOrFail();

            KomentarBimbingan::create([
                'id_bimbingan' => $bimbingan->id_bimbingan,
                'id_pengirim' => $user->id_user,
                'isi_komentar' => $request->komentar,
                'tipe_pengirim' => 'dosen',
                'waktu_kirim' => now(),
                'lampiran_url' => $request->lampiran_url
            ]);

            $bimbingan->touch();

            return redirect()
                ->route('dosen.bimbingan.show', $bimbingan->id_bimbingan)
                ->with('success', 'Komentar berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan komentar: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan komentar: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail komentar tertentu
     */
    public function show($id_bimbingan, $id_komentar)
    {
        $user = Auth::user();

        if (!$user->dosen) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $bimbingan = Bimbingan::where('nidn', $user->dosen->id_nidn)
                ->where('id_bimbingan', $id_bimbingan)
                ->firstOrFail();

            $komentar = KomentarBimbingan::with(['bimbingan.mahasiswa', 'pengirim'])
                ->where('id_bimbingan', $bimbingan->id_bimbingan)
                ->findOrFail($id_komentar);

            return view('dosen.bimbingan.komentar', [
                'komentar' => $komentar,
                'bimbingan' => $bimbingan
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal memuat detail komentar: ' . $e->getMessage());
            return redirect()
                ->route('dosen.bimbingan.show', $id_bimbingan)
                ->with('error', 'Komentar tidak ditemukan.');
        }
    }

    /**
     * Menghapus komentar bimbingan milik dosen sendiri
     */
    public function destroy($id_komentar)
    {
        $user = Auth::user();

        if (!$user->dosen) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $komentar = KomentarBimbingan::where('id_pengirim', $user->id_user)
                ->where('tipe_pengirim', 'dosen')
                ->findOrFail($id_komentar);

            $id_bimbingan = $komentar->id_bimbingan;
            $komentar->delete();

            return redirect()
                ->route('dosen.bimbingan.show', $id_bimbingan)
                ->with('success', 'Komentar berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus komentar: ' . $e->getMessage());
            return back()->with('error', 'Komentar tidak dapat dihapus.');
        }
    }
}

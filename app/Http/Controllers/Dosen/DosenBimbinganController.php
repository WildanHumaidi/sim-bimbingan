<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenBimbinganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:2'); // Hanya dosen
    }

    public function index()
    {
        $user = Auth::user();

        if (!$user->dosen) {
            return view('dosen.bimbingan.index', ['bimbingan' => collect()]);
        }

        $nidn = $user->dosen->id_nidn;

        $bimbingan = Bimbingan::with(['mahasiswa', 'dokumen', 'komentar'])
            ->where('nidn', $nidn)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('dosen.bimbingan.index', compact('bimbingan'));
    }

    public function show($id)
    {
        $user = Auth::user();

        if (!$user->dosen) {
            abort(403, 'Unauthorized action.');
        }

        $nidn = $user->dosen->id_nidn;

        $bimbingan = Bimbingan::with([
                'mahasiswa',
                'dokumen',
                'komentar' => function ($query) {
                    $query->with(['pengirim:id_user,username'])
                    ->orderBy('waktu_kirim', 'asc');
                }
            ])
            ->where('nidn', $nidn)
            ->findOrFail($id);

        return view('dosen.bimbingan.show', compact('bimbingan'));
    }

    public function edit($id)
    {
        $user = Auth::user();

        if (!$user->dosen) {
            abort(403, 'Unauthorized action.');
        }

        $nidn = $user->dosen->id_nidn;

        $bimbingan = Bimbingan::with(['dokumen', 'komentar.pengirim'])
            ->where('nidn', $nidn)
            ->findOrFail($id);

        return view('dosen.bimbingan.edit', compact('bimbingan'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->dosen) {
            abort(403, 'Unauthorized action.');
        }

        $nidn = $user->dosen->id_nidn;

        $request->validate([
            'catatan' => 'nullable|string',
            'status_validasi' => 'required|in:valid,invalid,pending,Valid,Invalid,Pending',
            'dokumen.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $bimbingan = Bimbingan::where('nidn', $nidn)->findOrFail($id);

        $bimbingan->update([
            'catatan' => $request->catatan,
            'status_validasi' => strtolower($request->status_validasi),
        ]);

        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $path = $file->store('dokumen_bimbingan', 'public');

                Dokumen::create([
                    'id_bimbingan' => $bimbingan->id_bimbingan,
                    'nama_file' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('dosen.bimbingan.index')
            ->with('success', 'Bimbingan berhasil diperbarui.');
    }

    public function deleteDokumen($id)
    {
        $user = Auth::user();

        if (!$user->dosen) {
            abort(403, 'Unauthorized action.');
        }

        $nidn = $user->dosen->id_nidn;

        $dokumen = Dokumen::whereHas('bimbingan', function ($query) use ($nidn) {
            $query->where('nidn', $nidn);
        })->findOrFail($id);

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($dokumen->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($dokumen->file_path);
        } elseif (file_exists(public_path($dokumen->file_path))) {
            unlink(public_path($dokumen->file_path));
        }

        $dokumen->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Dosen memberikan rekomendasi / ACC Sidang Skripsi
     */
    public function accSidang(Request $request, $nim)
    {
        $user = Auth::user();

        if (!$user->dosen) {
            abort(403, 'Unauthorized action.');
        }

        $nidn = $user->dosen->id_nidn;
        $mahasiswa = \App\Models\Mahasiswa::findOrFail($nim);

        // Pastikan dosen adalah pembimbing atau memiliki bimbingan dengan mahasiswa ini
        $isPembimbing = ($mahasiswa->nidn_pembimbing === $nidn) || 
            Bimbingan::where('nim', $nim)->where('nidn', $nidn)->exists();

        if (!$isPembimbing) {
            abort(403, 'Anda bukan dosen pembimbing untuk mahasiswa ini.');
        }

        $request->validate([
            'catatan' => 'nullable|string|max:1000',
        ]);

        $mahasiswa->update([
            'status_sidang' => 'acc_sidang',
            'tanggal_acc_sidang' => now(),
            'catatan_acc_sidang' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Mahasiswa berhasil direkomendasikan / ACC untuk Sidang Skripsi.');
    }

    /**
     * Dosen melihat Kartu Kendali Bimbingan mahasiswa
     */
    public function kartuKendali($nim)
    {
        $user = Auth::user();

        if (!$user->dosen) {
            abort(403, 'Unauthorized action.');
        }

        $mahasiswa = \App\Models\Mahasiswa::with(['dosenPembimbing', 'user'])->findOrFail($nim);
        $bimbinganList = Bimbingan::with(['dokumen', 'komentar'])
            ->where('nim', $nim)
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('bimbingan.kartu_kendali', [
            'mahasiswa' => $mahasiswa,
            'dosen' => $mahasiswa->dosenPembimbing ?? $user->dosen,
            'bimbinganList' => $bimbinganList,
            'tanggalCetak' => now()->isoFormat('D MMMM Y'),
        ]);
    }
}

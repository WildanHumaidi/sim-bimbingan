<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Dokumen;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BimbinganController extends Controller
{
    public function index()
    {
        $bimbingan = Bimbingan::with(['mahasiswa', 'dosen', 'dokumen'])->paginate(10);
        $mahasiswa = Mahasiswa::all();
        $dosen = Dosen::all();

        return view('admin.bimbingan.index', compact('bimbingan', 'mahasiswa', 'dosen'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        $dosen = Dosen::all();
        return view('admin.bimbingan.create', compact('mahasiswa', 'dosen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|exists:mahasiswas,id_nim',
            'nidn' => 'required|exists:dosens,id_nidn',
            'tanggal' => 'required|date',
            'topik' => 'required|string',
            'catatan' => 'nullable|string',
            'status_validasi' => 'required|in:valid,invalid,pending,Valid,Invalid,Pending',
            'dokumen.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $bimbingan = Bimbingan::create([
            'nim' => $request->nim,
            'nidn' => $request->nidn,
            'tanggal' => $request->tanggal,
            'topik' => $request->topik,
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

        return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bimbingan = Bimbingan::with('dokumen')->findOrFail($id);
        $mahasiswa = Mahasiswa::all();
        $dosen = Dosen::all();
        //edit.blade
        $mahasiswaList = Mahasiswa::all();
        $dosenList = Dosen::all();


        return view('admin.bimbingan.edit', compact('bimbingan', 'mahasiswaList', 'dosenList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required|exists:mahasiswas,id_nim',
            'nidn' => 'required|exists:dosens,id_nidn',
            'tanggal' => 'required|date',
            'topik' => 'required|string',
            'catatan' => 'nullable|string',
            'status_validasi' => 'required|in:valid,invalid,pending,Valid,Invalid,Pending',
            'dokumen.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $bimbingan = Bimbingan::findOrFail($id);
        $bimbingan->update([
            'nim' => $request->nim,
            'nidn' => $request->nidn,
            'tanggal' => $request->tanggal,
            'topik' => $request->topik,
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

        return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bimbingan = Bimbingan::findOrFail($id);

        foreach ($bimbingan->dokumen as $dokumen) {
            if (Storage::disk('public')->exists($dokumen->file_path)) {
                Storage::disk('public')->delete($dokumen->file_path);
            } elseif (file_exists(public_path($dokumen->file_path))) {
                unlink(public_path($dokumen->file_path));
            }
            $dokumen->delete();
        }

        $bimbingan->delete();

        return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil dihapus.');
    }
}

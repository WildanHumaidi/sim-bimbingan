<?php

namespace App\Http\Controllers\Admin;

use App\Models\TahunAjar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TahunAjarController extends Controller
{
    public function index()
    {
        $tahunAjar = TahunAjar::paginate(10);
        return view('admin.tahun_ajar.index', compact('tahunAjar'));
    }

    public function create()
    {
        return view('admin.tahun_ajar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:10',
            'semester' => 'required|string|max:10',
        ]);

        TahunAjar::create($request->all());

        return redirect()->route('tahun_ajar.index')->with('success', 'Tahun Ajar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tahunAjar = TahunAjar::findOrFail($id);
        return view('admin.tahun_ajar.edit', compact('tahunAjar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|string|max:10',
            'semester' => 'required|string|max:10',
        ]);

        $tahunAjar = TahunAjar::findOrFail($id);
        $tahunAjar->update($request->all());

        return redirect()->route('tahun_ajar.index')->with('success', 'Tahun Ajar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tahunAjar = TahunAjar::findOrFail($id);
        $tahunAjar->delete();

        return redirect()->route('tahun_ajar.index')->with('success', 'Tahun Ajar berhasil dihapus.');
    }
}

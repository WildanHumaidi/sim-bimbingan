<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProgramStudi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $programStudi = ProgramStudi::paginate(10);
        return view('admin.program_studi.index', compact('programStudi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
        ]);

        ProgramStudi::create($request->all());

        return redirect()->route('program_studi.index')->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
        ]);

        $programStudi = ProgramStudi::findOrFail($id);
        $programStudi->update($request->all());

        return redirect()->route('program_studi.index')->with('success', 'Program Studi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $programStudi = ProgramStudi::findOrFail($id);
        $programStudi->delete();

        return redirect()->route('program_studi.index')->with('success', 'Program Studi berhasil dihapus.');
    }
}

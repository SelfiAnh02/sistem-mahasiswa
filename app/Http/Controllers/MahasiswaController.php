<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::query();

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $mahasiswa = $query->orderBy('nama')->paginate(10);
        
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:mahasiswa|max:20',
            'nama' => 'required|max:100',
            'alamat' => 'required',
        ]);

        Mahasiswa::create($validated);

        return redirect()->route('mahasiswa.index')
                        ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim' => ['required', 'max:20', Rule::unique('mahasiswa')->ignore($mahasiswa)],
            'nama' => 'required|max:100',
            'alamat' => 'required',
        ]);

        $mahasiswa->update($validated);

        return redirect()->route('mahasiswa.index')
                        ->with('success', 'Data mahasiswa berhasil diupdate.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')
                        ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
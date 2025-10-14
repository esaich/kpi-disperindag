<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IndikatorController extends Controller
{
    /**
     * Menampilkan daftar semua indikator.
     */
    public function index()
    {
        $indikators = Indikator::all();
        // Asumsi view: resources/views/indikators/index.blade.php
        return view('indikators.index', compact('indikators'));
    }

    /**
     * Menampilkan form untuk membuat indikator baru.
     */
    public function create()
    {
        return view('indikators.create');
    }

    /**
     * Menyimpan indikator baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_indikator' => ['required', 'string', 'max:255', Rule::unique('indikators', 'nama_indikator')],
        ]);

        Indikator::create($request->only('nama_indikator'));

        return redirect()->route('indikators.index')
                         ->with('success', 'Indikator berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail indikator tertentu (Opsional).
     */
    public function show(Indikator $indikator)
    {
        return view('indikators.show', compact('indikator'));
    }

    /**
     * Menampilkan form untuk mengedit indikator.
     */
    public function edit(Indikator $indikator)
    {
        return view('indikators.edit', compact('indikator'));
    }

    /**
     * Memperbarui indikator yang ada di database.
     */
    public function update(Request $request, Indikator $indikator)
    {
        $request->validate([
            'nama_indikator' => ['required', 'string', 'max:255', Rule::unique('indikators', 'nama_indikator')->ignore($indikator->indikator_id, 'indikator_id')],
        ]);

        $indikator->update($request->only('nama_indikator'));

        return redirect()->route('indikators.index')
                         ->with('success', 'Indikator berhasil diperbarui!');
    }

    /**
     * Menghapus indikator dari database.
     */
    public function destroy(Indikator $indikator)
    {
        $indikator->delete();

        return redirect()->route('indikators.index')
                         ->with('success', 'Indikator berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Bidang;
use App\Models\Nilai;
use App\Models\Indikator;

class InputDataController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::with(['bidang', 'nilais.indikator'])->get();
        $bidangs = Bidang::all();
        $indikators = Indikator::all();

        return view('inputdata.index', compact('pegawais', 'bidangs', 'indikators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'bidang_id' => 'required|exists:bidangs,bidang_id',
            'indikator_id' => 'required|exists:indikators,indikator_id',
            'nilai' => 'required|integer|min:0|max:100',
        ]);

        // Simpan Pegawai
        $pegawai = Pegawai::firstOrCreate([
            'nama' => $validated['nama'],
            'bidang_id' => $validated['bidang_id'],
        ]);

        // Simpan Nilai
        Nilai::create([
            'pegawai_id' => $pegawai->pegawai_id,
            'indikator_id' => $validated['indikator_id'],
            'nilai' => $validated['nilai'],
        ]);

        return redirect()->route('inputdata.index')->with('success', 'Data pegawai dan nilai berhasil disimpan.');
    }

    public function storeBidang(Request $request)
    {
        $request->validate([
            'nama_bidang' => 'required|string|max:255|unique:bidangs,nama_bidang',
        ]);

        Bidang::create(['nama_bidang' => $request->nama_bidang]);

        return redirect()->route('inputdata.index')->with('success', 'Bidang baru berhasil ditambahkan.');
    }

    public function storeIndikator(Request $request)
    {
        $request->validate([
            'nama_indikator' => 'required|string|max:255|unique:indikators,nama_indikator',
        ]);

        Indikator::create(['nama_indikator' => $request->nama_indikator]);

        return redirect()->route('inputdata.index')->with('success', 'Indikator baru berhasil ditambahkan.');
    }
}

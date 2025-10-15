<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index()
    {
        // ===============================
        // Data Teknis (Indikator 1–28)
        // ===============================
        $dataTeknis = DB::table('nilais')
            ->join('pegawais', 'nilais.pegawai_id', '=', 'pegawais.pegawai_id')
            ->join('indikators', 'nilais.indikator_id', '=', 'indikators.indikator_id')
            ->select(
                'pegawais.nama as nama_pegawai',
                'indikators.nama_indikator',
                'nilais.indikator_id',
                'nilais.nilai'
            )
            ->whereBetween('nilais.indikator_id', [1, 28])
            ->orderBy('pegawais.nama')
            ->get();

        $teknisBelumTerpenuhi = $dataTeknis->filter(fn($item) => $item->nilai < 60);

        // Ambil daftar indikator teknis untuk dropdown
        $indikatorTeknis = DB::table('indikators')
            ->whereBetween('indikator_id', [1, 28])
            ->pluck('nama_indikator', 'indikator_id');

        // ===============================
        // Data Mansoskul (Indikator 29–37)
        // ===============================
        $dataMansoskul = DB::table('nilais')
            ->join('pegawais', 'nilais.pegawai_id', '=', 'pegawais.pegawai_id')
            ->join('indikators', 'nilais.indikator_id', '=', 'indikators.indikator_id')
            ->select(
                'pegawais.nama as nama_pegawai',
                'indikators.nama_indikator',
                'nilais.indikator_id',
                'nilais.nilai'
            )
            ->whereBetween('nilais.indikator_id', [29, 37])
            ->orderBy('pegawais.nama')
            ->get();

        $mansoskulBelumTerpenuhi = $dataMansoskul->filter(fn($item) => $item->nilai < 15);

        // Ambil daftar indikator mansoskul untuk dropdown
        $indikatorMansoskul = DB::table('indikators')
            ->whereBetween('indikator_id', [29, 37])
            ->pluck('nama_indikator', 'indikator_id');

        return view('pelatihan.index', [
            'dataTeknis' => $dataTeknis,
            'teknisBelumTerpenuhi' => $teknisBelumTerpenuhi,
            'indikatorTeknis' => $indikatorTeknis,
            'dataMansoskul' => $dataMansoskul,
            'mansoskulBelumTerpenuhi' => $mansoskulBelumTerpenuhi,
            'indikatorMansoskul' => $indikatorMansoskul,
        ]);
    }
}

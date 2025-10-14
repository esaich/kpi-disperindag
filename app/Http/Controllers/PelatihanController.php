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

        // Ambil yang nilai teknis < 60
        $teknisBelumTerpenuhi = $dataTeknis->filter(function ($item) {
            return $item->nilai < 60;
        });

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

        // Ambil yang nilai mansoskul < 15
        $mansoskulBelumTerpenuhi = $dataMansoskul->filter(function ($item) {
            return $item->nilai < 15;
        });

        return view('pelatihan.index', [
            'dataTeknis' => $dataTeknis,
            'teknisBelumTerpenuhi' => $teknisBelumTerpenuhi,
            'dataMansoskul' => $dataMansoskul,
            'mansoskulBelumTerpenuhi' => $mansoskulBelumTerpenuhi,
        ]);
    }
}

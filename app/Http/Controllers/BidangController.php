<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidangController extends Controller
{
    /**
     * Menampilkan daftar bidang dan (jika dipilih) pegawai beserta nilai rata-ratanya.
     */
    public function index(Request $request)
    {
        // Ambil semua bidang
        $bidangs = DB::table('bidangs')->orderBy('nama_bidang', 'asc')->get();

        // Jika user memilih salah satu bidang
        $selectedBidangId = $request->query('bidang_id');
        $pegawaiNilai = collect();
        $selectedBidang = null;

        if ($selectedBidangId) {
            // Ambil nama bidang
            $selectedBidang = DB::table('bidangs')
                ->where('bidang_id', $selectedBidangId)
                ->first();

            if ($selectedBidang) {
                // Ambil pegawai + rata-rata nilainya (hanya indikator 29–37), urutkan tertinggi–terendah
                $pegawaiNilai = DB::table('pegawais')
                    ->join('nilais', 'pegawais.pegawai_id', '=', 'nilais.pegawai_id')
                    ->select(
                        'pegawais.nama',
                        DB::raw('AVG(nilais.nilai) as rata_nilai')
                    )
                    ->where('pegawais.bidang_id', $selectedBidangId)
                    // ->whereBetween('nilais.indikator_id', [29, 37]) // batas indikator 29–37
                    ->groupBy('pegawais.pegawai_id', 'pegawais.nama')
                    ->orderByDesc('rata_nilai')
                    ->get();
            }
        }

        return view('bidangs.index', [
            'bidangs' => $bidangs,
            'selectedBidang' => $selectedBidang,
            'pegawaiNilai' => $pegawaiNilai,
        ]);
    }
}

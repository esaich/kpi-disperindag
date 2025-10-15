<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bidang;
use App\Models\Pegawai;

class BidangController extends Controller
{
    /**
     * Menampilkan daftar bidang dan (jika dipilih) pegawai beserta nilai rata-ratanya.
     */
    public function index(Request $request)
    {
        // 1. Ambil semua bidang menggunakan Model Bidang
        $bidangs = Bidang::orderBy('nama_bidang', 'asc')->get();

        // Jika user memilih salah satu bidang
        $selectedBidangId = $request->query('bidang_id');
        $pegawaiNilai = collect();
        $selectedBidang = null;

        if ($selectedBidangId) {
            // 2. Ambil selectedBidang menggunakan Model Bidang (find() mencari berdasarkan primary key)
            $selectedBidang = Bidang::find($selectedBidangId);

            // Lanjutkan hanya jika bidang ditemukan
            if ($selectedBidang) {
                // 3. Ambil pegawai + rata-rata nilainya (Indikator 29–37)
                // Menggunakan Model Pegawai sebagai titik awal, dan tetap menggunakan join
                // untuk melakukan agregasi AVG yang efisien.
                $pegawaiNilai = Pegawai::where('bidang_id', $selectedBidangId)
                    // Gabungkan ke tabel nilai (pivot table)
                    ->join('nilais', 'pegawais.pegawai_id', '=', 'nilais.pegawai_id')
                    ->select(
                        'pegawais.pegawai_id',
                        'pegawais.nama',
                        // Hitung rata-rata nilai
                        DB::raw('AVG(nilais.nilai) as rata_nilai')
                    )
                    // Filter indikator 29-37 (Mansoskul)
                    // ->whereBetween('nilais.indikator_id', [29, 37])
                    // Kelompokkan dan urutkan
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

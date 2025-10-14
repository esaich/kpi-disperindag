<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1️⃣ Ambil daftar semua bidang
        $bidangs = DB::table('bidangs')->pluck('nama_bidang')->toArray();

        // 2️⃣ Rata-rata nilai per bidang
        $rataBidang = DB::table('nilais')
            ->join('pegawais', 'nilais.pegawai_id', '=', 'pegawais.pegawai_id')
            ->join('bidangs', 'pegawais.bidang_id', '=', 'bidangs.bidang_id')
            ->select('bidangs.nama_bidang', DB::raw('AVG(nilais.nilai) as rata_nilai'))
            ->groupBy('bidangs.nama_bidang')
            ->orderByDesc('rata_nilai')
            ->get();

        // 3️⃣ Rata-rata nilai setiap indikator per bidang
        $rataIndikatorBidang = DB::table('nilais')
            ->join('pegawais', 'nilais.pegawai_id', '=', 'pegawais.pegawai_id')
            ->join('bidangs', 'pegawais.bidang_id', '=', 'bidangs.bidang_id')
            ->join('indikators', 'nilais.indikator_id', '=', 'indikators.indikator_id')
            ->select(
                'bidangs.nama_bidang',
                'indikators.nama_indikator',
                DB::raw('AVG(nilais.nilai) as rata_nilai')
            )
            ->groupBy('bidangs.nama_bidang', 'indikators.nama_indikator')
            ->get();

        // 4️⃣ Format ke bentuk array agar mudah dikirim ke JavaScript
        $indikatorData = [];
        foreach ($rataIndikatorBidang as $row) {
            $indikatorData[$row->nama_bidang][$row->nama_indikator] = round($row->rata_nilai, 2);
        }

        // 5️⃣ Ambil semua nama indikator sebagai label chart (untuk radar)
        $indikators = DB::table('indikators')->pluck('nama_indikator')->toArray();

        // 6️⃣ Siapkan data untuk radar chart (rata-rata bidang saja)
        $labels = $bidangs;
        $data = [];
        foreach ($bidangs as $bidang) {
            $nilai = $rataBidang->firstWhere('nama_bidang', $bidang);
            $data[] = $nilai ? round($nilai->rata_nilai, 2) : 0;
        }

        // 🔹 7️⃣ Tambahan: Data khusus untuk Bar Chart (indikator_id 29–37)
        $indikatorBar = DB::table('indikators')
            ->whereBetween('indikator_id', [29, 37])
            ->pluck('nama_indikator', 'indikator_id')
            ->toArray();

        $rataIndikatorBar = DB::table('nilais')
            ->select('indikator_id', DB::raw('AVG(nilai) as rata_nilai'))
            ->whereBetween('indikator_id', [29, 37])
            ->groupBy('indikator_id')
            ->pluck('rata_nilai', 'indikator_id')
            ->toArray();

        // Format agar bisa langsung dipakai Chart.js
        $barChartLabels = array_values($indikatorBar);
        $barChartData = [];
        foreach (array_keys($indikatorBar) as $id) {
            $barChartData[] = isset($rataIndikatorBar[$id])
                ? round($rataIndikatorBar[$id], 2)
                : 0;
        }

        // 🔸 8️⃣ Kirim semua ke view (bagian lain TIDAK dihapus/diubah)
        return view('pages.home', [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
            'rataBidang' => $rataBidang,
            'indikators' => json_encode($indikators),
            'indikatorData' => json_encode($indikatorData),

            // ➕ Tambahan khusus untuk Bar Chart baru
            'barChartLabels' => json_encode($barChartLabels),
            'barChartData' => json_encode($barChartData),
        ]);
    }
}

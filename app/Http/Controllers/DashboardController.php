<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        // 1️⃣ Ambil daftar semua bidang
        $bidangs = DB::table('bidangs')->pluck('nama_bidang')->toArray();

        // ----------------------------------------------------
        // 🎯 KPI METRICS (Untuk Summary Cards)
        // ----------------------------------------------------

        // Menghitung Total Pegawai
        $totalPegawai = DB::table('pegawais')->count();

        // Menghitung Rata-rata Global (Rata-rata SEMUA nilai indikator)
        $rataRataGlobal = DB::table('nilais')->avg('nilai');
        $rataRataGlobal = round($rataRataGlobal, 2);

        // 2️⃣ Rata-rata nilai per bidang (semua indikator 1-37)
        // Data ini digunakan untuk Tabel Peringkat DAN Radar Chart
        $rataBidang = DB::table('nilais')
            ->join('pegawais', 'nilais.pegawai_id', '=', 'pegawais.pegawai_id')
            ->join('bidangs', 'pegawais.bidang_id', '=', 'bidangs.bidang_id')
            ->select('bidangs.nama_bidang', DB::raw('AVG(nilais.nilai) as rata_nilai'))
            ->groupBy('bidangs.nama_bidang')
            ->orderByDesc('rata_nilai')
            ->get();
        
        // ----------------------------------------------------
        // 📊 RADAR CHART DATA (Sumbu: Bidang)
        // ----------------------------------------------------

        // 3️⃣ LABEL RADAR: Gunakan daftar nama bidang sebagai sumbu/jari-jari
        $radarLabels = $bidangs; 

        // 4️⃣ DATA RADAR: Siapkan data skor rata-rata (total skor) untuk setiap bidang
        $radarScores = [];
        foreach ($bidangs as $bidang) {
            // Ambil rata-rata nilai (dari Langkah 2) untuk bidang tersebut
            $nilai = $rataBidang->firstWhere('nama_bidang', $bidang);
            $radarScores[] = $nilai ? round($nilai->rata_nilai, 2) : 0;
        }

        // ----------------------------------------------------
        // 📈 BAR CHART DATA (Indikator 29–37) 
        // ----------------------------------------------------

        // 5️⃣ Ambil ID dan Nama Indikator 29-37
        $indikatorBar = DB::table('indikators')
            ->whereBetween('indikator_id', [29, 37])
            ->pluck('nama_indikator', 'indikator_id')
            ->toArray();
            
        $indikatorBarIds = array_keys($indikatorBar);
        $barChartLabels = array_values($indikatorBar); // Labels untuk sumbu Y Bar Chart

        // 6️⃣ Ambil Rata-rata Nilai Indikator 29-37 PER BIDANG
        $rataIndikatorBarPerBidang = DB::table('nilais')
            ->join('pegawais', 'nilais.pegawai_id', '=', 'pegawais.pegawai_id')
            ->join('bidangs', 'pegawais.bidang_id', '=', 'bidangs.bidang_id')
            ->whereIn('nilais.indikator_id', $indikatorBarIds)
            ->select(
                'bidangs.nama_bidang',
                'nilais.indikator_id',
                DB::raw('AVG(nilais.nilai) as rata_nilai')
            )
            ->groupBy('bidangs.nama_bidang', 'nilais.indikator_id')
            ->get()
            ->groupBy('nama_bidang'); 

        // 7️⃣ Format Data BAR CHART FINAL ($barChartDataFinal)
        $barChartDataFinal = [];
        $globalScores = array_fill_keys($indikatorBarIds, ['total' => 0, 'count' => 0]);

        foreach ($bidangs as $namaBidang) {
            $scores = [];
            $rataBidangData = $rataIndikatorBarPerBidang[$namaBidang] ?? collect(); 

            foreach ($indikatorBarIds as $indikatorId) {
                $nilaiRow = $rataBidangData->firstWhere('indikator_id', $indikatorId);
                $rataNilai = $nilaiRow ? round($nilaiRow->rata_nilai, 2) : 0;
                $scores[] = $rataNilai;

                if ($rataNilai > 0) { 
                    $globalScores[$indikatorId]['total'] += $rataNilai;
                    $globalScores[$indikatorId]['count'] += 1;
                }
            }
            $barChartDataFinal[$namaBidang] = $scores;
        }

        // Hitung dan masukkan Rata-rata Global ke $barChartDataFinal
        $rataGlobalScores = [];
        foreach ($indikatorBarIds as $indikatorId) {
            $total = $globalScores[$indikatorId]['total'];
            $count = $globalScores[$indikatorId]['count'];
            $rataGlobalScores[] = $count > 0 ? round($total / $count, 2) : 0;
        }
        $barChartDataFinal['Rata-rata Semua Bidang'] = $rataGlobalScores;
        
        // ----------------------------------------------------
        // 🚀 KIRIM SEMUA KE VIEW
        // ----------------------------------------------------
        return view('pages.home', [
            // Data KPI Metrics
            'totalPegawai' => $totalPegawai,
            'rataRataGlobal' => $rataRataGlobal,

            // Data Radar Chart (Sumbu: Bidang, Data: Rata-rata Skor Bidang)
            'labels' => json_encode($radarLabels), 
            'data' => json_encode($radarScores), 
            
            // Data Umum (Tabel Peringkat)
            'rataBidang' => $rataBidang, 
            
            // Data Bar Chart
            'barChartLabels' => json_encode($barChartLabels), 
            'barChartDataFinal' => json_encode($barChartDataFinal), 
        ]);
    }
}
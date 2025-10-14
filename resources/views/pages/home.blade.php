@extends('layouts.app')

@section('title', 'Performa Bidang')

@section('content')
{{-- Kontainer utama dihilangkan, hanya menyisakan padding dan background bg-gray-100 --}}
<div class="p-4 sm:p-6 text-[#2D2D2D] bg-gray-100 w-full min-h-screen">
    {{-- Div ini berfungsi sebagai wrapper konten utama --}}
    <div class="w-full"> 

        {{-- HEADER: Menggunakan background transparan/mengikuti parent, atau bisa tetap putih jika ingin kontras --}}
        <div class="p-6 bg-white mb-6">
            <h2 class="text-3xl font-extrabold text-center mb-2 text-[#203A43]">
                 Visualisasi Kinerja Bidang & Indikator 
            </h2>
            <p class="text-center text-gray-500">
                Analisis komprehensif performa tiap bidang dan rata-rata skor pada Indikator Kinerja.
            </p>
        </div>

        {{-- ================= STATISTIC CARDS SECTION (MENGGANTI DUMMY DATA) ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            
            {{-- Card 1: TOTAL PEGAWAI DINILAI --}}
            <div class="bg-white p-5 flex items-start justify-between transition transform hover:bg-gray-50 duration-300 ease-in-out">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">TOTAL PEGAWAI DINILAI</p>
                    <p class="text-3xl font-bold text-[#203A43]">{{ number_format($totalPegawai, 0, ',', '.') }}</p>
                    <p class="text-sm mt-1 text-green-600 font-semibold flex items-center">
                        {{-- <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> --}}
                 <span class="text-gray-500 ml-1 font-normal">Cakupan Data</span>
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-blue-100 text-blue-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 5h12a1 1 0 011 1v8a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1zM7 16a1 1 0 000 2h6a1 1 0 100-2H7z"></path></svg>
                </div>
            </div>

            {{-- Card 2: JUMLAH BIDANG TERUKUR --}}
            <div class="bg-white p-5 flex items-start justify-between transition transform hover:bg-gray-50 duration-300 ease-in-out">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">JUMLAH BIDANG TERUKUR</p>
                    <p class="text-3xl font-bold text-[#203A43]">{{ $rataBidang->count() }}</p>
                    <p class="text-sm mt-1 text-red-600 font-semibold flex items-center">
                        {{-- <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg> --}}
                 <span class="text-gray-500 ml-1 font-normal">Total Bidang</span>
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-orange-100 text-orange-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18H4v-1a4 4 0 0110.875-2.285L16 17v1z"></path></svg>
                </div>
            </div>

            {{-- Card 3: RATA-RATA SKOR GLOBAL --}}
            <div class="bg-white p-5 flex items-start justify-between transition transform hover:bg-gray-50 duration-300 ease-in-out">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">RATA-RATA SKOR GLOBAL</p>
                    <p class="text-3xl font-bold text-[#203A43]">{{ number_format($rataRataGlobal, 2, ',', '.') }}%</p>
                    <p class="text-sm mt-1 text-green-600 font-semibold flex items-center">
                     
                         <span class="text-gray-500 ml-1 font-normal">Data Skor Keseluruhan</span>
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-green-100 text-green-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                </div>
            </div>

            {{-- Card 4: SKOR BIDANG TERTINGGI --}}
            <div class="bg-white p-5 flex items-start justify-between transition transform hover:bg-gray-50 duration-300 ease-in-out">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">SKOR BIDANG TERTINGGI</p>
                    @php
                        $topBidang = $rataBidang->first();
                    @endphp
                    <p class="text-3xl font-bold text-[#203A43]">{{ $topBidang ? number_format($topBidang->rata_nilai, 2, ',', '.') : 0 }}%</p>
                    <p class="text-sm mt-1 text-green-600 font-semibold flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        {{ $topBidang ? $topBidang->nama_bidang : 'N/A' }} <span class="text-gray-500 ml-1 font-normal">Bidang Terbaik</span>
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-yellow-100 text-yellow-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 7h1v7h-1v-7zM7 7h1v7H7V7z"></path><path fill-rule="evenodd" d="M12 2a1 1 0 011 1v1h2a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h2V3a1 1 0 011-1h4zM5 7h10v9a1 1 0 001 1H4a1 1 0 001-1V7z" clip-rule="evenodd"></path></svg>
                </div>
            </div>
        </div>

        {{-- ================= CHART SECTION (TWO COLUMNS) ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">

            {{-- RADAR CHART (Tanpa rounded, shadow, dan border) --}}
            <div class="bg-white p-6">
                <h3 class="text-xl font-semibold mb-4 text-center text-[#0096FF]">
                    Profil Performa Data Teknis
                </h3>
                <p class="text-center text-gray-500 mb-4 text-sm">
                    Keseimbangan skor rata-rata bidang pada semua indikator.
                </p>
                <div class="w-full">
                    <canvas id="radarChart" class="w-full h-[350px]"></canvas>
                </div>
            </div>

            {{-- BAR CHART (Tanpa rounded, shadow, dan border) --}}
            <div class="bg-white p-6">
                <h3 class="text-xl font-semibold mb-4 text-center text-[#0096FF]" id="barChartTitle">
                    Skor Data Mansoskul (Rata-rata Semua Bidang)
                </h3>

                {{-- Dropdown Filter --}}
                <div class="w-full mb-4">
                    <label for="bidangFilter" class="block text-sm font-medium text-gray-700 mb-1">
                        Pilih Bidang untuk Analisis Detail:
                    </label>
                    <select id="bidangFilter"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#0096FF] focus:border-[#0096FF] sm:text-sm cursor-pointer transition duration-150">
                        <option value="Rata-rata Semua Bidang" selected>Rata-rata Semua Bidang</option>
                        {{-- Mengambil Opsi Bidang dari data rataBidang (sama seperti tabel) --}}
                        @foreach ($rataBidang as $row)
                            <option value="{{ $row->nama_bidang }}">{{ $row->nama_bidang }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <canvas id="barChart" class="w-full h-[350px]"></canvas>
                </div>
            </div>
        </div>

        {{-- ================= TABLE SECTION ================= --}}
        {{-- Tanpa rounded, shadow, dan border --}}
        <div class="bg-white p-6">
            <h3 class="text-2xl font-semibold mb-4 text-center text-[#203A43]">
                📊 Skor Rata-rata per Bidang
            </h3>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-white bg-[#203A43] uppercase tracking-wider text-xs">
                            <th class="py-3 text-left px-4">No</th>
                            <th class="py-3 text-left px-4">Nama Bidang</th>
                            <th class="py-3 text-center px-4">Rata-rata Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rataBidang as $index => $row)
                            @php
                                $isBest = $index === 0;
                                $rowClasses = $isBest
                                    ? 'bg-yellow-50 border-l-4 border-yellow-400 font-bold'
                                    : 'hover:bg-gray-50 transition duration-200 ease-in-out border-b border-gray-100';
                                $valueClasses = $isBest ? 'text-yellow-600' : 'text-[#0096FF]';
                            @endphp
                            <tr class="{{ $rowClasses }}">
                                <td class="px-4 py-3 text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-[#2D2D2D] flex items-center">
                                    {{ $row->nama_bidang }}
                                    @if ($isBest)
                                        <span
                                            class="ml-2 text-xs bg-yellow-400 text-white px-2 py-0.5 rounded-full">
                                            ⭐ Terbaik
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center font-bold {{ $valueClasses }}">
                                    {{ number_format($row->rata_nilai, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-400">
                                    Belum ada data nilai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- ================== SCRIPTS (Disinkronkan dengan Controller) ================== --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    
    // ====== DATA DARI SERVER (DATA REAL) ======
    // Data untuk Bar Chart
    const BAR_CHART_LABELS = {!! isset($barChartLabels) ? $barChartLabels : '[]' !!};
    // Mengandung data semua bidang DAN 'Rata-rata Semua Bidang'
    const BAR_DATA_FINAL = {!! isset($barChartDataFinal) ? $barChartDataFinal : '{}' !!}; 
    
    // Data untuk Radar Chart
    // RADAR_LABELS = Nama-nama Bidang (Sumbu Radar)
    const RADAR_LABELS = {!! isset($labels) ? $labels : '[]' !!}; 
    // RADAR_SCORES = Rata-rata Skor Bidang (Data Poligon)
    const RADAR_SCORES = {!! isset($data) ? $data : '[]' !!}; 

    // 🔥🔥🔥 BAGIAN DEBUGGING KRITIS 🔥🔥🔥
    console.log('--- BAR CHART DEBUGGING ---');
    console.log('1. Labels (Indikator 29-37):', BAR_CHART_LABELS);
    console.log('2. Data Skor Semua Bidang (Object Keys):', Object.keys(BAR_DATA_FINAL));
    
    // Cari data default (Rata-rata Semua Bidang)
    const DEFAULT_BIDANG_NAME = "Rata-rata Semua Bidang";
    const defaultScores = BAR_DATA_FINAL[DEFAULT_BIDANG_NAME] || [];
    
    console.log('3. Data Default Ditemukan:', defaultScores.length > 0);
    console.log('4. Skor Default (Array Data):', defaultScores); 
    console.log('--- RADAR CHART DEBUGGING ---');
    console.log('5. Radar Labels (Nama Bidang):', RADAR_LABELS);
    console.log('6. Radar Scores (Rata-rata Bidang):', RADAR_SCORES);
    console.log('---------------------------');
    // 🔥🔥🔥 AKHIR BAGIAN DEBUGGING KRITIS 🔥🔥🔥

    // Cek apakah data Bar Chart tersedia
    const isBarDataValid = defaultScores.length > 0 && BAR_CHART_LABELS.length > 0;

    // ====== BAR CHART (Indikator 29-37) ======
    let barChartInstance;
    const ctxBar = document.getElementById('barChart').getContext('2d');

    // Hanya inisialisasi jika data valid
    if (isBarDataValid) {
        barChartInstance = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: BAR_CHART_LABELS,
                datasets: [{
                    label: 'Rata-rata Nilai Indikator (Semua Bidang)',
                    data: defaultScores, 
                    backgroundColor: '#0096FF',
                    borderColor: '#203A43',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 1000, easing: 'easeOutQuart' },
                scales: {
                    x: {
                        beginAtZero: true,
                        min: 0, max: 100,
                        grid: { color: 'rgba(32, 58, 67, 0.1)' },
                        ticks: { color: '#6B7280' }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { color: '#2D2D2D', font: { weight: 'bold' } }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(32, 58, 67, 0.9)',
                        titleColor: '#FFFFFF',
                        bodyColor: '#FFFFFF',
                        borderColor: '#0096FF',
                        borderWidth: 1,
                        callbacks: { label: ctx => ` Skor: ${ctx.parsed.x}` }
                    }
                }
            }
        });

        // Listener untuk memperbarui Judul dan Data Bar Chart saat dropdown berubah
        document.getElementById('bidangFilter').addEventListener('change', e => {
            const bidang = e.target.value;
            const dataScores = BAR_DATA_FINAL[bidang];
            if (!dataScores) return;

            const newTitle = bidang === DEFAULT_BIDANG_NAME
                ? '📈 Skor Data Mansoskul (Rata-rata Semua Bidang)'
                : `📈 Skor Data Mansoskul: ${bidang}`;

            barChartInstance.data.labels = BAR_CHART_LABELS;
            barChartInstance.data.datasets[0].data = dataScores;
            barChartInstance.data.datasets[0].label = newTitle.replace('📈 ', '');

            // Memperbarui tag <h3>
            document.getElementById('barChartTitle').textContent = newTitle; 
            
            barChartInstance.update();
        });
    } else {
        console.warn("Bar Chart tidak diinisialisasi karena data kosong. Cek Controller/Database.");
    }
    
    // ====== RADAR CHART (Sumbu: Bidang) ======
    const radarEl = document.getElementById('radarChart');
    if (radarEl && !radarEl.dataset.initialized) {
        radarEl.dataset.initialized = true;

        // RADAR_LABELS kini berisi Nama Bidang
        const ctxRadar = radarEl.getContext('2d');

        new Chart(ctxRadar, {
            type: 'radar',
            data: {
                labels: RADAR_LABELS, // Menggunakan Nama Bidang
                datasets: [{
                    label: 'Rata-rata Skor Total Pegawai', 
                    data: RADAR_SCORES, // Skor Rata-rata Bidang
                    fill: true,
                    backgroundColor: 'rgba(0,150,255,0.08)',
                    borderColor: '#0096FF',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#0096FF',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    tension: 0.25
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: 25 },
                scales: {
                    r: {
                        beginAtZero: true,
                        min: 0, max: 100,
                        ticks: { stepSize: 20, color: '#6B7280', backdropColor: 'transparent' },
                        grid: { color: 'rgba(32,58,67,0.12)', circular: true },
                        angleLines: { color: 'rgba(32,58,67,0.15)' },
                        pointLabels: { color: '#203A43', font: { size: 13, weight: 600 }, padding: 8 } 
                    }
                },
                plugins: {
                    legend: { display: true, labels: { color: '#203A43', boxWidth: 10 } }, 
                    tooltip: {
                        backgroundColor: 'rgba(32,58,67,0.9)',
                        titleColor: '#0096FF',
                        bodyColor: '#FFFFFF',
                        borderColor: '#0096FF',
                        borderWidth: 1,
                        callbacks: { label: ctx => ` Rata-rata Bidang: ${ctx.parsed.r}` } 
                    }
                }
            }
        });
    }
});
</script>
@endpush
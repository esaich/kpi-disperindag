@extends('layouts.app')

@section('title', 'Performa Bidang')

@section('content')
<div class="min-h-screen p-10 text-[#2D2D2D]">
    <div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-xl p-8 border border-gray-200">
        <h2 class="text-3xl font-extrabold text-center mb-2 text-[#203A43]">
            ⚡ Visualisasi Kinerja Bidang & Indikator ⚡
        </h2>
        <p class="text-center text-gray-500 mb-8">
            Analisis komprehensif performa tiap bidang dan rata-rata skor pada Indikator Kinerja.
        </p>

        

        <div class="flex flex-col lg:flex-row gap-8 mb-10">

            {{-- RADAR CHART --}}
            <div class="lg:w-1/2 w-full bg-white rounded-2xl p-6 border border-gray-100 shadow-lg flex flex-col items-center">
                <h3 class="text-xl font-semibold mb-4 text-center text-[#0096FF]">
                    🌀 Profil Performa Bidang
                </h3>
                <p class="text-center text-gray-500 mb-4 text-sm">
                    Keseimbangan skor rata-rata bidang pada semua indikator.
                </p>
                <div class="w-full">
                    <canvas id="radarChart" class="w-full h-[350px]"></canvas>
                </div>
            </div>

            {{-- BAR CHART --}}
            <div class="lg:w-1/2 w-full bg-white rounded-2xl p-6 border border-gray-100 shadow-lg flex flex-col items-center">
                <h3 class="text-xl font-semibold mb-4 text-center text-[#0096FF]">
                    📈 Skor data Mansoskul
                </h3>
                <div class="w-full mb-4">
                    <label for="bidangFilter" class="block text-sm font-medium text-gray-700 mb-1">
                        Pilih Bidang untuk Analisis Detail:
                    </label>
                    <select id="bidangFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#0096FF] focus:border-[#0096FF] sm:text-sm rounded-lg shadow-sm cursor-pointer transition duration-150">
                        <option value="Rata-rata Semua Bidang" selected>Rata-rata Semua Bidang</option>
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

        

        {{-- TABEL SKOR --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-md">
            <h3 class="text-2xl font-semibold mb-4 text-center text-[#0096FF]">
                📊 Skor Rata-rata per Bidang
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-white bg-[#203A43] uppercase tracking-wider text-xs shadow-lg">
                            <th class="py-3 text-left px-4 rounded-tl-xl">No</th>
                            <th class="py-3 text-left px-4">Nama Bidang</th>
                            <th class="py-3 text-center px-4 rounded-tr-xl">Rata-rata Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rataBidang as $index => $row)
                            @php
                                $isBest = $index === 0;
                                $rowClasses = $isBest ? 'bg-yellow-50 border-l-4 border-yellow-400 font-bold' : 'hover:bg-gray-50 transition duration-200 ease-in-out border-b border-gray-100';
                                $valueClasses = $isBest ? 'text-yellow-600' : 'text-[#0096FF]';
                            @endphp
                            <tr class="{{ $rowClasses }}">
                                <td class="px-4 py-3 text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-[#2D2D2D] flex items-center">
                                    {{ $row->nama_bidang }}
                                    @if ($isBest)
                                        <span class="ml-2 text-xs bg-yellow-400 text-white px-2 py-0.5 rounded-full shadow-sm">
                                            ⭐ Terbaik
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center font-bold {{ number_format($row->rata_nilai, 2) }} {{ $valueClasses }}">
                                    {{ number_format($row->rata_nilai, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-400">Belum ada data nilai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- DATA DARI SERVER ---
    const RATA_BIDANG_LIST = {!! json_encode($rataBidang) !!};

    // GANTI: gunakan barChartLabels yang dikirim controller; jika belum ada, fallback ke []
    const INDIKATOR_LABELS = {!! isset($barChartLabels) ? $barChartLabels : '[]' !!};

    // --- SIMULASI DATA BIDANG (tidak diubah selain menyesuaikan panjang skor) ---
    const MOCK_INDICATOR_DATA_INITIAL = [
        { name: "UPTD METROLOGI LEGAL", scores: [95, 90, 85, 92, 88, 90, 95, 87, 91] },
        { name: "INDUSTRI", scores: [70, 75, 65, 80, 85, 75, 70, 72, 68] },
        { name: "UPTD PASAR WILAYAH II", scores: [80, 85, 90, 75, 70, 80, 85, 82, 77] },
        { name: "SEKRETARIAT", scores: [88, 82, 91, 79, 84, 86, 81, 89, 83] },
    ];

    let MOCK_INDICATOR_DATA_FINAL = [...MOCK_INDICATOR_DATA_INITIAL];
    const existingNames = new Set(MOCK_INDICATOR_DATA_INITIAL.map(d => d.name));

    RATA_BIDANG_LIST.forEach(item => {
        if (!existingNames.has(item.nama_bidang)) {
            const baseScore = parseFloat(item.rata_nilai) || 75;
            const placeholderScores = INDIKATOR_LABELS.map(() => {
                let score = Math.round(baseScore + (Math.random() * 10 - 5));
                return Math.min(100, Math.max(60, score));
            });
            MOCK_INDICATOR_DATA_FINAL.push({
                name: item.nama_bidang,
                scores: placeholderScores
            });
        }
    });

    const totalFields = MOCK_INDICATOR_DATA_FINAL.length;
    const globalAverageScores = INDIKATOR_LABELS.map((_, index) => {
        let totalScore = 0;
        MOCK_INDICATOR_DATA_FINAL.forEach(data => {
            if(data.scores[index] !== undefined) {
                totalScore += data.scores[index];
            }
        });
        return Math.round(totalScore / totalFields);
    });

    MOCK_INDICATOR_DATA_FINAL.push({
        name: "Rata-rata Semua Bidang",
        scores: globalAverageScores
    });

    // --- BAR CHART ---
    let barChartInstance = null;

    const updateBarChart = (bidangName) => {
        const selectedData = MOCK_INDICATOR_DATA_FINAL.find(d => d.name === bidangName);
        if (!selectedData) return console.error("Data tidak ditemukan untuk Bidang:", bidangName);

        const newTitle = bidangName === "Rata-rata Semua Bidang" 
            ? 'Rata-rata Nilai Indikator (Semua Bidang)'
            : `Rata-rata Nilai Indikator untuk Bidang: ${bidangName}`;

        barChartInstance.data.labels = INDIKATOR_LABELS;
        barChartInstance.data.datasets[0].data = selectedData.scores;
        barChartInstance.data.datasets[0].label = newTitle;

        const titleElement = document.querySelector('#barChart').closest('.flex-col').querySelector('h3');
        titleElement.textContent = `📈 ${newTitle}`;
        barChartInstance.update();
    };

    const barElement = document.getElementById('barChart');
    if (barElement) {
        const ctxBar = barElement.getContext('2d');
        const defaultData = MOCK_INDICATOR_DATA_FINAL.find(d => d.name === 'Rata-rata Semua Bidang');

        barChartInstance = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: INDIKATOR_LABELS,
                datasets: [{
                    label: 'Rata-rata Nilai Indikator (Semua Bidang)',
                    data: defaultData.scores,
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
                        beginAtZero: true, min: 0, max: 100,
                        grid: { color: 'rgba(32, 58, 67, 0.1)', borderColor: 'rgba(32, 58, 67, 0.3)' },
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

        const filterDropdown = document.getElementById('bidangFilter');
        filterDropdown.addEventListener('change', (event) => {
            updateBarChart(event.target.value);
        });
    }

    // --- RADAR CHART (tidak diubah) ---
    const splitLabel = (label) => {
        const parts = label.split(' ');
        const firstLine = parts.slice(0, 2).join(' ');
        const secondLine = parts.slice(2).join(' ');
        if (secondLine) return [firstLine, secondLine];
        return [firstLine];
    };

    const radarElement = document.getElementById('radarChart');
    if (radarElement) {
        const bidangLabels = {!! $labels !!}.map(splitLabel);
        const bidangValues = {!! $data !!};
        const ctxRadar = radarElement.getContext('2d');

        new Chart(ctxRadar, {
            type: 'radar',
            data: {
                labels: bidangLabels,
                datasets: [{
                    label: 'Rata-rata Nilai Bidang',
                    data: bidangValues,
                    fill: true,
                    backgroundColor: 'rgba(0, 150, 255, 0.1)', 
                    borderColor: '#0096FF',
                    pointBackgroundColor: '#203A43', 
                    pointBorderColor: '#0096FF',
                    pointHoverBackgroundColor: '#0096FF',
                    pointHoverBorderColor: '#FFFFFF',
                    borderWidth: 3,
                    tension: 0.3,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 1200, easing: 'easeInOutQuart' },
                scales: {
                    r: {
                        beginAtZero: true,
                        min: 0, max: 100,
                        ticks: { stepSize: 20, color: '#6B7280' },
                        grid: { color: 'rgba(32, 58, 67, 0.1)' },
                        angleLines: { color: 'rgba(32, 58, 67, 0.2)' },
                        pointLabels: { color: '#2D2D2D', font: { size: 13, weight: 'bold' } }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(32, 58, 67, 0.9)',
                        titleColor: '#0096FF',
                        bodyColor: '#FFFFFF',
                        borderColor: '#0096FF',
                        borderWidth: 1,
                        callbacks: { label: ctx => ` Rata-rata: ${ctx.parsed.r}` }
                    }
                }
            }
        });
    }
});
</script>
@endpush

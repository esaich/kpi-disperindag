@extends('layouts.app')

@section('title', 'Daftar Pelatihan')

@section('content')
<div class="space-y-8">
    <h1 class="text-3xl font-extrabold text-[#203A43]">Halaman Daftar Pelatihan</h1>

    {{-- ========================= --}}
    {{-- FILTER & SEARCH --}}
    {{-- ========================= --}}
    <div class="flex flex-wrap items-center gap-4">
        {{-- Filter --}}
        <div class="flex items-center gap-2">
            <label for="filter-select" class="text-gray-700 font-semibold">Filter:</label>
            <select id="filter-select" class="border-gray-300 rounded-lg p-2 shadow-sm focus:ring focus:ring-[#2C5364]">
                <option value="all" selected>Semua Data</option>
                <option value="belum">Belum Terpenuhi</option>
            </select>
        </div>

        {{-- Search --}}
        <div class="flex items-center gap-2">
            <label for="search-input" class="text-gray-700 font-semibold">Cari Pegawai:</label>
            <input 
                type="text" 
                id="search-input" 
                placeholder="Ketik nama pegawai..." 
                class="border-gray-300 rounded-lg p-2 w-64 shadow-sm focus:ring focus:ring-[#2C5364]"
            />
        </div>
    </div>

    {{-- ========================= --}}
    {{-- TEKNIS --}}
    {{-- ========================= --}}
    <div id="teknis-section">
        <h2 class="text-2xl font-bold text-[#2C5364] mt-8">📘 Data Teknis (Indikator 1–28)</h2>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-[#203A43] text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama Pegawai</th>
                        <th class="px-4 py-2 text-left">Nama Indikator</th>
                        <th class="px-4 py-2 text-left">Nilai</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataTeknis as $index => $item)
                        @php
                            $status = $item->nilai < 60 ? 'Belum Terpenuhi' : 'Terpenuhi';
                        @endphp
                        <tr 
                            class="border-b text-gray-700 {{ $status === 'Belum Terpenuhi' ? 'belum-row bg-red-50' : '' }}"
                            data-nama="{{ strtolower($item->nama_pegawai) }}"
                        >
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $item->nama_pegawai }}</td>
                            <td class="px-4 py-2">{{ $item->nama_indikator }}</td>
                            <td class="px-4 py-2">{{ $item->nilai }}</td>
                            <td class="px-4 py-2">
                                @if($status === 'Belum Terpenuhi')
                                    <span class="text-red-600 font-semibold">❌ {{ $status }}</span>
                                @else
                                    <span class="text-green-600 font-semibold">✅ {{ $status }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- MANSOSKUL --}}
    {{-- ========================= --}}
    <div id="mansoskul-section">
        <h2 class="text-2xl font-bold text-[#2C5364] mt-8">💼 Data Mansoskul (Indikator 29–37)</h2>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-[#203A43] text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama Pegawai</th>
                        <th class="px-4 py-2 text-left">Nama Indikator</th>
                        <th class="px-4 py-2 text-left">Nilai</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataMansoskul as $index => $item)
                        @php
                            $status = $item->nilai < 15 ? 'Belum Terpenuhi' : 'Terpenuhi';
                        @endphp
                        <tr 
                            class="border-b text-gray-700 {{ $status === 'Belum Terpenuhi' ? 'belum-row bg-red-50' : '' }}"
                            data-nama="{{ strtolower($item->nama_pegawai) }}"
                        >
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $item->nama_pegawai }}</td>
                            <td class="px-4 py-2">{{ $item->nama_indikator }}</td>
                            <td class="px-4 py-2">{{ $item->nilai }}</td>
                            <td class="px-4 py-2">
                                @if($status === 'Belum Terpenuhi')
                                    <span class="text-red-600 font-semibold">❌ {{ $status }}</span>
                                @else
                                    <span class="text-green-600 font-semibold">✅ {{ $status }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ========================= --}}
{{-- SCRIPT: FILTER + SEARCH --}}
{{-- ========================= --}}
<script>
    const filterSelect = document.getElementById('filter-select');
    const searchInput = document.getElementById('search-input');

    function applyFilters() {
        const showBelum = filterSelect.value === 'belum';
        const searchText = searchInput.value.toLowerCase().trim();

        const allRows = document.querySelectorAll('tbody tr');

        allRows.forEach(row => {
            const isBelum = row.classList.contains('belum-row');
            const nama = row.dataset.nama || '';

            // logika filter
            const matchBelum = showBelum ? isBelum : true;
            const matchSearch = nama.includes(searchText);

            // tampilkan / sembunyikan
            row.style.display = matchBelum && matchSearch ? '' : 'none';
        });
    }

    filterSelect.addEventListener('change', applyFilters);
    searchInput.addEventListener('input', applyFilters);
</script>
@endsection

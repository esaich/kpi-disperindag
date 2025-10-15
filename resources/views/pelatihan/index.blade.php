@extends('layouts.app')

@section('title', 'Daftar Pelatihan')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto"> 

        <h1 class="text-3xl font-extrabold text-[#203A43] mb-8 border-b pb-3 pl-4 sm:pl-0">🎓 Data Pelatihan & Kebutuhan Pengembangan Pegawai</h1>

        {{-- === Bagian Filter & Search === --}}
        <div class="bg-white rounded-xl shadow-md p-5 mb-8 border border-gray-100">
            <div class="flex flex-wrap items-center justify-between gap-4">
                
                {{-- Filter Status --}}
                <div class="flex items-center gap-3">
                    <label for="filter-select" class="text-gray-700 font-semibold text-sm">Status Kebutuhan:</label>
                    <select id="filter-select" class="border-gray-300 rounded-lg p-2 text-sm shadow-sm focus:ring-2 focus:ring-[#0096FF] focus:border-[#0096FF]">
                        <option value="all" selected>Semua Status</option>
                        <option value="belum">Hanya Belum Terpenuhi</option>
                    </select>
                </div>

                {{-- Search Pegawai --}}
                <div class="flex items-center gap-3">
                    <label for="search-input" class="text-gray-700 font-semibold text-sm hidden sm:block">Cari Pegawai:</label>
                    <div class="relative w-full sm:w-64">
                        <input 
                            type="text" 
                            id="search-input" 
                            placeholder="Ketik nama pegawai..." 
                            class="w-full border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm shadow-sm focus:ring-2 focus:ring-[#0096FF] focus:border-[#0096FF]"
                        />
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- === Bagian Tabs untuk Pemilihan Data === --}}
        <div class="mb-4 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 text-[#0096FF] border-[#0096FF] rounded-t-lg tab-button" id="teknis-tab" data-target="teknis-content" type="button" role="tab">
                        📘 Data Teknis (Indikator 1–28)
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 tab-button" id="mansoskul-tab" data-target="mansoskul-content" type="button" role="tab">
                        💼 Data Mansoskul (Indikator 29–37)
                    </button>
                </li>
            </ul>
        </div>
        
        {{-- === Konten Utama Tab: Wrapper Card untuk Tampilan Data === --}}
        {{-- Pembungkus tunggal ini menjamin lebar kedua konten (teknis/mansoskul) sama --}}
        <div class="bg-white rounded-xl shadow-xl p-6 border border-gray-100 mt-8">
            
            {{-- Konten Tab: Data Teknis --}}
            <div id="teknis-content" class="tab-content">
                <h2 class="text-2xl font-bold text-[#2C5364] mb-4 border-b pb-2">Data Teknis</h2>
                <div class="overflow-x-auto mt-4">
                    {{-- Kelas min-w-full memastikan tabel mengambil lebar penuh dari container p-6 --}}
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#203A43] text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[5%]">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[20%]">Nama Pegawai</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[55%]">Nama Indikator</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider w-[10%]">Nilai</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider w-[10%]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($dataTeknis as $index => $item)
                                @php
                                    $status = $item->nilai < 60 ? 'Belum Terpenuhi' : 'Terpenuhi';
                                    $isBelum = $status === 'Belum Terpenuhi';
                                @endphp
                                <tr 
                                    class="{{ $isBelum ? 'belum-row bg-red-50 hover:bg-red-100' : 'bg-white hover:bg-gray-50' }} text-gray-700 transition duration-150"
                                    data-nama="{{ strtolower($item->nama_pegawai) }}"
                                    data-status="{{ $isBelum ? 'belum' : 'terpenuhi' }}"
                                    data-tab="teknis"
                                >
                                    <td class="px-6 py-3 whitespace-nowrap text-sm">{{ $index + 1 }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-[#203A43]">{{ $item->nama_pegawai }}</td>
                                    <td class="px-6 py-3 text-sm">{{ $item->nama_indikator }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-center font-bold">{{ $item->nilai }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $isBelum ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $isBelum ? '❌ Belum' : '✅ Terpenuhi' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Konten Tab: Data Mansoskul (Hidden by default) --}}
            <div id="mansoskul-content" class="tab-content hidden">
                <h2 class="text-2xl font-bold text-[#2C5364] mb-4 border-b pb-2">Data Mansoskul</h2>
                <div class="overflow-x-auto mt-4">
                    {{-- Kelas min-w-full memastikan tabel mengambil lebar penuh dari container p-6 --}}
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#203A43] text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[5%]">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[20%]">Nama Pegawai</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[55%]">Nama Indikator</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider w-[10%]">Nilai</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider w-[10%]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($dataMansoskul as $index => $item)
                                @php
                                    $status = $item->nilai < 15 ? 'Belum Terpenuhi' : 'Terpenuhi';
                                    $isBelum = $status === 'Belum Terpenuhi';
                                @endphp
                                <tr 
                                    class="{{ $isBelum ? 'belum-row bg-red-50 hover:bg-red-100' : 'bg-white hover:bg-gray-50' }} text-gray-700 transition duration-150"
                                    data-nama="{{ strtolower($item->nama_pegawai) }}"
                                    data-status="{{ $isBelum ? 'belum' : 'terpenuhi' }}"
                                    data-tab="mansoskul"
                                >
                                    <td class="px-6 py-3 whitespace-nowrap text-sm">{{ $index + 1 }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-[#203A43]">{{ $item->nama_pegawai }}</td>
                                    <td class="px-6 py-3 text-sm">{{ $item->nama_indikator }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-center font-bold">{{ $item->nilai }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $isBelum ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $isBelum ? '❌ Belum' : '✅ Terpenuhi' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========================= --}}
{{-- SCRIPT: FILTER + SEARCH + TABS --}}
{{-- ========================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelect = document.getElementById('filter-select');
        const searchInput = document.getElementById('search-input');
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        let activeTabId = 'teknis-content'; // Default tab

        // --- Fungsi Tabs Logic ---
        function activateTab(targetId) {
            activeTabId = targetId;
            
            tabButtons.forEach(button => {
                const target = button.getAttribute('data-target');
                if (target === targetId) {
                    button.classList.add('border-[#0096FF]', 'text-[#0096FF]');
                    button.classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                } else {
                    button.classList.remove('border-[#0096FF]', 'text-[#0096FF]');
                    button.classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                }
            });

            tabContents.forEach(content => {
                if (content.id === targetId) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
            // Terapkan filter setiap kali tab berubah pada baris di tab yang baru diaktifkan
            applyFilters(); 
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                activateTab(this.getAttribute('data-target'));
            });
        });
        
        // --- Fungsi Filter & Search Logic ---
        function applyFilters() {
            const showBelumOnly = filterSelect.value === 'belum';
            const searchText = searchInput.value.toLowerCase().trim();
            
            // Ambil SEMUA baris di tab yang AKTIF saat ini
            const activeRows = document.querySelectorAll(`#${activeTabId} tbody tr`);
            
            activeRows.forEach(row => {
                const status = row.dataset.status; 
                const nama = row.dataset.nama || '';

                // Logika Filter Status
                const matchStatus = showBelumOnly ? (status === 'belum') : true;
                
                // Logika Filter Search
                const matchSearch = nama.includes(searchText);

                // Tampilkan / Sembunyikan baris
                row.style.display = matchStatus && matchSearch ? '' : 'none';
            });
        }

        filterSelect.addEventListener('change', applyFilters);
        searchInput.addEventListener('input', applyFilters);
        
        // Inisialisasi: Tampilkan tab pertama (Teknis) secara default
        activateTab('teknis-content');
    });
</script>
@endsection
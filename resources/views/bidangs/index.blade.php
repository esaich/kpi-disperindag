@extends('layouts.app')

@section('title', 'Daftar Bidang')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold text-[#203A43] mb-8 border-b pb-3">🏢 Daftar Bidang & Kinerja Pegawai</h1>

        {{-- === Bagian 1: Daftar Pilihan Bidang (Pill Style) === --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-[#0096FF]">Pilih Bidang untuk Melihat Data Kinerja:</h2>
            
            <div class="flex flex-wrap gap-3">
                @foreach($bidangs as $bidang)
                    @php
                        // Menentukan apakah bidang ini sedang dipilih
                        $isActive = isset($selectedBidang) && $selectedBidang->bidang_id == $bidang->bidang_id;
                        $activeClasses = 'bg-[#0096FF] text-white shadow-md font-bold';
                        $inactiveClasses = 'text-[#203A43] bg-gray-100 hover:bg-[#0096FF]/10 hover:border-[#0096FF]';
                    @endphp
                    
                    <a href="{{ route('bidangs.index', ['bidang_id' => $bidang->bidang_id]) }}"
                       class="px-5 py-2 rounded-full border border-gray-300 transition duration-200 text-sm 
                           {{ $isActive ? $activeClasses : $inactiveClasses }}">
                        {{ $bidang->nama_bidang }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- === Bagian 2: Tampilan Hasil Kinerja Bidang yang Dipilih === --}}
        @if($selectedBidang)
            <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-6 mt-8">
                <h2 class="text-2xl font-bold mb-6 text-[#203A43] border-b pb-2">
                    Hasil Kinerja Bidang: {{ $selectedBidang->nama_bidang }}
                </h2>

                @if($pegawaiNilai->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#203A43] text-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider rounded-tl-lg">
                                        No
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                                        Nama Pegawai
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider rounded-tr-lg">
                                        Rata-rata Nilai
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($pegawaiNilai as $index => $pegawai)
                                    @php
                                        $rataRata = number_format($pegawai->rata_nilai, 2);
                                        // Menentukan warna badge berdasarkan nilai rata-rata
                                        $badgeClass = 'bg-gray-100 text-gray-700';
                                        if ($rataRata >= 85) {
                                            $badgeClass = 'bg-green-100 text-green-800';
                                        } elseif ($rataRata >= 70) {
                                            $badgeClass = 'bg-blue-100 text-blue-800';
                                        } else {
                                            $badgeClass = 'bg-red-100 text-red-800';
                                        }
                                    @endphp

                                    <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#203A43]">
                                            {{ $pegawai->nama }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold shadow-sm {{ $badgeClass }}">
                                                {{ $rataRata }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4 text-center bg-gray-50 rounded-lg">
                        <p class="text-gray-500 font-medium">Belum ada data nilai untuk pegawai di bidang **{{ $selectedBidang->nama_bidang }}**.</p>
                    </div>
                @endif
            </div>
        @else
            <div class="p-8 text-center bg-white rounded-xl shadow-lg border border-gray-100">
                <p class="text-xl font-medium text-gray-500">
                    Silakan pilih salah satu bidang di atas untuk menampilkan detail kinerja pegawainya.
                </p>
                <p class="text-sm text-gray-400 mt-2">
                    Data akan diperbarui secara otomatis berdasarkan input nilai terbaru.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
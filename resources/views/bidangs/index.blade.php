@extends('layouts.app')

@section('title', 'Daftar Bidang')

@section('content')
<div class="space-y-6">

    <h1 class="text-3xl font-extrabold text-[#203A43] mb-4">📋 Daftar Bidang</h1>

    {{-- Daftar semua bidang --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-lg font-semibold mb-4 text-[#0096FF]">Pilih salah satu bidang:</h2>
        <ul class="space-y-2">
            @foreach($bidangs as $bidang)
                <li>
                    <a href="{{ route('bidangs.index', ['bidang_id' => $bidang->bidang_id]) }}"
                       class="block p-3 rounded-lg border border-gray-200 hover:bg-[#0096FF]/10 transition {{ isset($selectedBidang) && $selectedBidang->bidang_id == $bidang->bidang_id ? 'bg-[#0096FF]/20 border-[#0096FF]' : '' }}">
                        <span class="font-semibold text-[#203A43]">{{ $bidang->nama_bidang }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Jika bidang dipilih, tampilkan daftar pegawai dan nilai --}}
    @if($selectedBidang)
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-[#0096FF]">
                🏢 Bidang: {{ $selectedBidang->nama_bidang }}
            </h2>

            @if($pegawaiNilai->isNotEmpty())
                <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-[#203A43] text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Nama Pegawai</th>
                            <th class="px-4 py-3 text-center">Rata-rata Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawaiNilai as $index => $pegawai)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition">
                                <td class="px-4 py-2 text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 text-[#2D2D2D]">{{ $pegawai->nama }}</td>
                                <td class="px-4 py-2 text-center font-semibold text-[#0096FF]">
                                    {{ number_format($pegawai->rata_nilai, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada data nilai untuk bidang ini.</p>
            @endif
        </div>
    @endif
</div>
@endsection

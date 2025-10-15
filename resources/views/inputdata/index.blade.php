@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-3xl font-extrabold text-gray-900 mb-8 border-b pb-3">Manajemen Input Data Kinerja</h1>

        {{-- Pesan Sukses & Error --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-bold">Gagal!</p>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- === Bagian 1: Input Utama dan Form Tambahan === --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">

            {{-- Kolom Kiri: Form Input Nilai Pegawai (2/3 lebar di lg) --}}
            <div class="lg:col-span-2 bg-white shadow-xl rounded-xl p-6 border border-gray-100">
                <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Input Nilai Pegawai</h2>

                <form action="{{ route('inputdata.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    {{-- Grid 2 Kolom untuk Input --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Pegawai</label>
                            <input type="text" name="nama" id="nama" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan nama pegawai" required>
                        </div>

                        <div>
                            <label for="bidang_id" class="block text-sm font-medium text-gray-700">Bidang</label>
                            <select name="bidang_id" id="bidang_id" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">-- Pilih Bidang --</option>
                                @foreach($bidangs as $bidang)
                                    <option value="{{ $bidang->bidang_id }}">{{ $bidang->nama_bidang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="indikator_id" class="block text-sm font-medium text-gray-700">Indikator</label>
                            <select name="indikator_id" id="indikator_id" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">-- Pilih Indikator --</option>
                                @foreach($indikators as $indikator)
                                    <option value="{{ $indikator->indikator_id }}">{{ $indikator->nama_indikator }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="nilai" class="block text-sm font-medium text-gray-700">Nilai (0-100)</label>
                            <input type="number" name="nilai" id="nilai" min="0" max="100" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="0-100" required>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
            
            {{-- Kolom Kanan: Form Tambah Bidang & Indikator (1/3 lebar di lg) --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Card Tambah Bidang --}}
                <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Tambah Bidang Baru</h3>
                    <form action="{{ route('inputdata.storeBidang') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="nama_bidang" placeholder="Nama bidang" class="flex-1 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" required>
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition duration-150">Tambah</button>
                    </form>
                </div>
                
                {{-- Card Tambah Indikator --}}
                <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Tambah Indikator Baru</h3>
                    <form action="{{ route('inputdata.storeIndikator') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="nama_indikator" placeholder="Nama indikator" class="flex-1 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-150">Tambah</button>
                    </form>
                </div>
            </div>
        </div>

        <hr class="my-10">

        {{-- === Bagian 2: Daftar Data Pegawai yang Sudah Ada === --}}
        <div class="bg-white shadow-xl rounded-xl p-6 border border-gray-100 mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Daftar Pegawai Dinilai</h2>
            
            @if($pegawais->isEmpty())
                <p class="text-center text-gray-500 py-10">Belum ada data pegawai yang dimasukkan.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">
                                    Pegawai
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">
                                    Bidang
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/5">
                                    Nilai Kinerja (Indikator)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pegawais as $pegawai)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $pegawai->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            {{ $pegawai->bidang->nama_bidang ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{-- Tampilkan daftar Indikator dan Nilainya --}}
                                        @forelse($pegawai->nilais as $nilai)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium 
                                                @if($nilai->nilai >= 85) bg-green-100 text-green-800 
                                                @elseif($nilai->nilai >= 70) bg-blue-100 text-blue-800 
                                                @else bg-red-100 text-red-800 @endif
                                                mr-2 mb-1 border">
                                                {{ $nilai->indikator->nama_indikator ?? 'Indikator Dihapus' }}: 
                                                <strong class="ml-1">{{ $nilai->nilai }}</strong>
                                            </span>
                                        @empty
                                            <span class="text-red-500 italic">Belum ada nilai untuk indikator apapun.</span>
                                        @endforelse
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8">

        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Input Nilai Pegawai</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- FORM UTAMA -->
        <form action="{{ route('inputdata.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Pegawai -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Nama Pegawai</label>
                <input type="text" name="nama" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400" placeholder="Masukkan nama pegawai" required>
            </div>

            <!-- Bidang -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Bidang</label>
                <select name="bidang_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400" required>
                    <option value="">-- Pilih Bidang --</option>
                    @foreach($bidangs as $bidang)
                        <option value="{{ $bidang->bidang_id }}">{{ $bidang->nama_bidang }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Indikator -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Indikator</label>
                <select name="indikator_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400" required>
                    <option value="">-- Pilih Indikator --</option>
                    @foreach($indikators as $indikator)
                        <option value="{{ $indikator->indikator_id }}">{{ $indikator->nama_indikator }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Nilai -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Nilai</label>
                <input type="number" name="nilai" min="0" max="100" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400" placeholder="Masukkan nilai" required>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-center">
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition-all">
                    Simpan Data
                </button>
            </div>
        </form>

        <!-- FORM TAMBAH BIDANG -->
        <div class="mt-12 border-t pt-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Tambah Bidang Baru</h3>
            <form action="{{ route('inputdata.storeBidang') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="nama_bidang" placeholder="Nama bidang baru" class="flex-1 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400" required>
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">Tambah</button>
            </form>
        </div>

        <!-- FORM TAMBAH INDIKATOR -->
        <div class="mt-8 border-t pt-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Tambah Indikator Baru</h3>
            <form action="{{ route('inputdata.storeIndikator') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="nama_indikator" placeholder="Nama indikator baru" class="flex-1 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400" required>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Tambah</button>
            </form>
        </div>

    </div>
</div>
@endsection

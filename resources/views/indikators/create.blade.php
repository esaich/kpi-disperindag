@extends('layouts.app')

@section('title', 'Tambah Indikator Baru')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-white shadow-xl rounded-xl p-6 sm:p-8">
            <h1 class="text-3xl font-bold text-amber-700 mb-6 border-b pb-2">
                Input Indikator Penilaian
            </h1>

            {{-- Formulir akan mengarah ke route resource IndikatorController@store --}}
            <form action="{{ route('indikators.store') }}" method="POST">
                @csrf

                {{-- Field Nama Indikator --}}
                <div class="mb-5">
                    <label for="nama_indikator" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Indikator
                    </label>
                    <input type="text" 
                           name="nama_indikator" 
                           id="nama_indikator" 
                           value="{{ old('nama_indikator') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 @error('nama_indikator') border-red-500 @enderror"
                           placeholder="Contoh: Kedisiplinan, Keterampilan Teknis, Kerjasama Tim"
                           required>

                    @error('nama_indikator')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <p class="text-sm text-gray-500 mb-6">
                    Indikator ini akan digunakan untuk menilai seluruh pegawai. Pastikan nama indikator spesifik dan jelas.
                </p>


                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('indikators.index') }}" 
                       class="inline-flex items-center px-6 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-150">
                        Simpan Indikator
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Tambah Bidang Baru')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-white shadow-xl rounded-xl p-6 sm:p-8">
            <h1 class="text-3xl font-bold text-indigo-700 mb-6 border-b pb-2">
                Input Bidang Baru
            </h1>

            {{-- Formulir akan mengarah ke route resource BidangController@store --}}
            <form action="{{ route('bidangs.store') }}" method="POST">
                @csrf

                {{-- Field Nama Bidang --}}
                <div class="mb-5">
                    <label for="nama_bidang" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Bidang / Departemen
                    </label>
                    <input type="text" 
                           name="nama_bidang" 
                           id="nama_bidang" 
                           value="{{ old('nama_bidang') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('nama_bidang') border-red-500 @enderror"
                           placeholder="Contoh: Keuangan, HRD, Produksi"
                           required>

                    @error('nama_bidang')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('bidangs.index') }}" 
                       class="inline-flex items-center px-6 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                        Simpan Bidang
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

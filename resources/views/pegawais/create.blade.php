@extends('layouts.app')

@section('title', 'Tambah Pegawai Baru')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-white shadow-xl rounded-xl p-6 sm:p-8">
            <h1 class="text-3xl font-bold text-amber-700 mb-6 border-b pb-2">
                Input Data Pegawai
            </h1>

            {{-- Formulir akan mengarah ke route resource PegawaiController@store --}}
            <form action="{{ route('pegawais.store') }}" method="POST">
                @csrf

                {{-- Field Nama Pegawai --}}
                <div class="mb-5">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Pegawai
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 @error('nama') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap pegawai"
                           required>

                    @error('nama')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Field Bidang (Dropdown) --}}
                <div class="mb-5">
                    <label for="bidang_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Bidang / Departemen
                    </label>
                    <select name="bidang_id" 
                            id="bidang_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 @error('bidang_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Pilih Bidang --</option>
                        
                        {{-- Loop untuk menampilkan data bidang dari database --}}
                        @if (isset($bidangs))
                            @foreach ($bidangs as $bidang)
                                <option value="{{ $bidang->bidang_id }}" 
                                    {{ old('bidang_id') == $bidang->bidang_id ? 'selected' : '' }}>
                                    {{ $bidang->nama_bidang }}
                                </option>
                            @endforeach
                        @else
                            {{-- Placeholder jika $bidangs belum dikirim dari controller --}}
                            <option value="" disabled>Harap tambahkan data Bidang terlebih dahulu.</option>
                        @endif
                        
                    </select>

                    @error('bidang_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('pegawais.index') }}" 
                       class="inline-flex items-center px-6 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-150">
                        Simpan Pegawai
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

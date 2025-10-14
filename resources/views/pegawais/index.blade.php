@extends('layouts.app')

@section('title', 'Manajemen Data Pegawai')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
            <h1 class="text-3xl font-extrabold text-amber-800">Daftar Pegawai</h1>
            
            <a href="{{ route('pegawais.create') }}" 
               class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-amber-600 hover:bg-amber-700 transition duration-150">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Pegawai Baru
            </a>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Card Tabel --}}
        <div class="bg-white shadow-xl rounded-xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Pegawai
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Bidang
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Loop data pegawais (Asumsi PegawaiController@index melewatkan $pegawais) --}}
                    {{-- @forelse ($pegawais as $index => $pegawai) --}}
                    @for ($i = 1; $i <= 5; $i++) {{-- Data Placeholder --}}
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $i }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Pegawai Dummy {{ $i }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{-- {{ $pegawai->bidang->nama_bidang ?? 'Tidak Diketahui' }} --}}
                                Bidang {{ $i % 3 == 0 ? 'HRD' : 'Teknis' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center space-x-2">
                                    {{-- <a href="{{ route('pegawais.edit', $pegawai->pegawai_id) }}" class="text-amber-600 hover:text-amber-900 transition duration-150">Edit</a> --}}
                                    {{-- <form action="{{ route('pegawais.destroy', $pegawai->pegawai_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition duration-150">Hapus</button>
                                    </form> --}}
                                    <span class="text-gray-400">Aksi Placeholder</span>
                                </div>
                            </td>
                        </tr>
                    {{-- @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data Pegawai yang tersedia.</td>
                        </tr>
                    @endforelse --}}
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="bg-white rounded-2xl shadow-md p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">
            Struktur Organisasi
        </h1>

        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/struktur-organisasi.jpeg') }}" 
                 alt="Struktur Organisasi Dinas Perindustrian dan Perdagangan Kabupaten Karawang" 
                 class="rounded-lg shadow-lg max-w-full h-auto border border-gray-200">
        </div>

        <div class="text-center text-gray-600 leading-relaxed">
            <p class="mb-4">
                Gambar di atas merupakan <span class="font-semibold">Bagan Susunan Organisasi</span> 
                Dinas Perindustrian dan Perdagangan Kabupaten Karawang. 
                Struktur ini menggambarkan pembagian tugas dan tanggung jawab 
                mulai dari Kepala Dinas, Sekretariat, hingga bidang-bidang utama.
            </p>

            <p>
                Struktur organisasi ini menjadi dasar koordinasi antar unit kerja dalam 
                menjalankan fungsi pelayanan publik, pengawasan, serta pengembangan 
                industri dan perdagangan di Kabupaten Karawang.
            </p>
        </div>
    </div>
</div>
@endsection

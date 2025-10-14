@extends('layouts.app')

{{-- Menetapkan judul khusus untuk halaman ini --}}
@section('title', 'Profil Kami')

{{-- Mengisi area konten utama --}}
@section('content')
    <div class="bg-white shadow-xl rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Halaman Profil</h1>
        <p class="text-gray-600">
            Selamat datang di halaman Profil. Di sini Anda bisa menemukan informasi mendalam tentang tim dan visi kami.
        </p>
        
        <div class="mt-6 border-t border-gray-200 pt-4">
            <p class="text-sm text-gray-500">
                Konten ini di-*render* oleh view `pages/profil.blade.php` yang me-*extend* `layouts/app.blade.php`.
            </p>
        </div>
    </div>
@endsection
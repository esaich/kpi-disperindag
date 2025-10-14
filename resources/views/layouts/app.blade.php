<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Project Web - @yield('title')</title> 
 
 @vite(['resources/css/app.css', 'resources/js/app.js']) 
 
 @stack('styles')
</head>
{{-- Menggunakan body sebagai Flex Container utama untuk Sidebar dan Konten --}}
<body class="bg-white font-sans antialiased min-h-screen flex flex-col">

 {{-- Navbar diposisikan di atas Sidebar dan Konten --}}
 @include('partials.navbar')

 {{-- === Kontainer Utama (Sidebar + Konten) === --}}
 {{-- Ini adalah div flex yang menampung Sidebar dan area konten secara horizontal --}}
 <div class="flex flex-grow w-full">
        
        {{-- 1. PEMANGGILAN SIDEBAR (Full Height, Menempel Kiri) --}}
        @include('partials.sidebar')
        
        {{-- 2. AREA KONTEN & CONTAINER DENGAN BATAS LEBAR --}}
        {{-- Diubah menjadi flex-col untuk menata konten dan footer secara vertikal --}}
        <div class="flex-grow flex flex-col">
            
            {{-- Konten Utama berada dalam container yang berpusat dan dibatasi lebarnya --}}
            {{-- Ditambahkan flex-grow agar bagian ini membesar dan mendorong Footer ke bawah --}}
            <div class="max-w-7xl mx-auto  flex-grow">
                <main class=""> 
                    @yield('content')
                </main>
            </div>
            
            {{-- Footer diletakkan di luar container konten, namun masih di dalam flex-grow area --}}
            @include('partials.footer')
        </div>
        
    </div>

 @stack('scripts')
</body>
</html>

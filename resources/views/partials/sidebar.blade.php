@php
    // Definisikan item sidebar. Sidebar ini dibuat terpisah dari Navbar untuk navigasi khusus desktop.
    $sidebarItems = [
        ['name' => '🏠 Home', 'route' => 'dashboard.index', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-2 2m2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['name' => '🏛️ Bidang', 'route' => 'bidangs.index', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
        ['name' => '🎓 Pelatihan', 'route' => 'pelatihan.index', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253'],
    ];
@endphp

<!-- Sidebar: Fixed, hanya muncul di layar besar (lg:) -->
<div class="
    hidden lg:block lg:w-64 flex-shrink-0 
    bg-[#203A43] text-white 
    border-r border-[#0096FF]/50
    shadow-2xl 
    h-screen sticky top-16 
    pt-4 pb-10 overflow-y-auto
    -ml-6 sm:ml-0
">
    
    <div class="px-2 space-y-2">
        @foreach ($sidebarItems as $item)
            @php
                $isActive = request()->routeIs($item['route']);
                
                // Active classes: teks Sky Blue, background Deep Grey-Blue lebih terang, shadow ringan
                $activeClasses = 'bg-[#203A43]/70 text-[#0096FF] font-bold border-l-4 border-[#0096FF] shadow-inner';
                
                // Inactive classes: teks putih, hover Sky Blue
                $inactiveClasses = 'text-gray-300 hover:bg-[#203A43]/50 hover:text-[#0096FF] border-l-4 border-transparent';
            @endphp

            <a href="{{ route($item['route']) }}" 
                class="
                    flex items-center space-x-3 p-3 rounded-lg transition duration-200 ease-in-out 
                    {{ $isActive ? $activeClasses : $inactiveClasses }}
                ">
                
                {{-- SVG Icon (dari Heroicons) --}}
                <svg class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                </svg>
                
                {{-- Text --}}
                <span class="text-sm">
                    {{ $item['name'] }}
                </span>
            </a>
        @endforeach
    </div>

    {{-- Info Versi --}}
    <div class="absolute bottom-0 left-0 w-full p-4 border-t border-[#0096FF]/30 text-xs text-gray-400 text-center">
        Dashboard v1.0
    </div>
</div>

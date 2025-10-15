@php
    // Definisikan array menu: Hanya menyisakan menu yang tidak ada di sidebar.
    $navItems = [
        ['name' => 'Home', 'route' => 'dashboard.index'], 
        ['name' => 'Input Data', 'route' => 'inputdata.index'], 
        // 'Lihat Kinerja' dan 'Kebutuhan Pelatihan' dihapus.
        ['name' => 'Profil', 'route' => 'profil'],
        ['name' => 'Struktur', 'route' => 'struktur'], 
    ];
@endphp

{{-- Background Deep Grey-Blue (#203A43) dan border Sky Blue (#0096FF) --}}
<nav class="bg-[#203A43] shadow-xl border-b border-[#0096FF]/50 sticky top-0 z-50">
    {{-- Lebar Penuh --}}
    <div class="mx-auto px-4 sm:px-6 lg:px-8"> 
        <div class="flex items-center justify-between h-16">
            
            <a href="{{ route('dashboard.index') }}" class="flex-shrink-0 flex items-center space-x-3 transition duration-300">
                {{-- LOGO DINAS --}}
                <img src="{{ asset('images/logo-dinas.png') }}" alt="Logo Dinas Karawang" class="h-10 w-auto">
                
                {{-- Teks Judul --}}
                <span class="text-white text-2xl font-extrabold tracking-wider hover:text-[#0096FF]">
                    KPI DISPERINDAG
                </span>
            </a>
            
            <div class="hidden sm:flex sm:space-x-4">
                @foreach ($navItems as $item)
                    @php
                        // Memperluas pengecekan rute aktif untuk mencakup rute nested/child
                        $isActive = request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*'); 
                        
                        $activeClasses = 'bg-[#203A43]/80 text-white border-b-2 border-[#0096FF]';
                        $inactiveClasses = 'text-white hover:bg-[#203A43]/50 hover:text-[#0096FF]';
                    @endphp

                    <a href="{{ route($item['route']) }}" 
                        class="px-3 py-2 rounded-md text-sm font-medium transition duration-200 
                                {{ $isActive ? $activeClasses : $inactiveClasses }}">
                        {{ $item['name'] }}
                    </a>
                @endforeach
            </div>

            <div class="flex sm:hidden">
                <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-[#0096FF] hover:text-white hover:bg-[#203A43]/50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#0096FF]" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    
                    <svg id="icon-open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="icon-close" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="sm:hidden" id="mobile-menu" style="display:none;">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-[#203A43]">
            @foreach ($navItems as $item)
                @php
                    $isActive = request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*');
                    $activeClasses = 'bg-[#203A43] text-[#0096FF] border-l-4 border-[#0096FF]';
                    $inactiveClasses = 'text-white hover:bg-[#203A43]/50 hover:text-[#0096FF]';
                @endphp
                <a href="{{ route($item['route']) }}" 
                    class="block px-3 py-2 rounded-md text-base font-medium 
                            {{ $isActive ? $activeClasses : $inactiveClasses }}">
                    {{ $item['name'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        if (button && menu) {
            button.addEventListener('click', function () {
                const isExpanded = button.getAttribute('aria-expanded') === 'true';
                button.setAttribute('aria-expanded', !isExpanded);
                
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');

                if (menu.style.display === "none") {
                    menu.style.display = "block";
                } else {
                    menu.style.display = "none";
                }
            });
        }
    });
</script>
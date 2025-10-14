@php
    // Definisikan array menu, menggunakan 'dashboard.index' sebagai rute utama.
    $navItems = [
        ['name' => 'Home', 'route' => 'dashboard.index'], 
        ['name' => 'Input Data', 'route' => 'inputdata.index'], 
        ['name' => 'Profil', 'route' => 'profil'],
        ['name' => 'Struktur', 'route' => 'struktur'], 
        
    ];
@endphp

{{-- Background Deep Grey-Blue (#203A43) dan border Sky Blue (#0096FF) --}}
<nav class="bg-[#203A43] shadow-xl border-b border-[#0096FF]/50 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- Logo/Judul -->
            {{-- Logo berwarna Sky Blue Soft --}}
            <a href="{{ route('dashboard.index') }}" class="flex-shrink-0 text-[#ffff] text-2xl font-extrabold tracking-wider transition duration-300 hover:text-white">
                KPI Disperindag
            </a>
            
            <!-- Navigasi Utama (Desktop View) -->
            <div class="hidden sm:flex sm:space-x-4">
                @foreach ($navItems as $item)
                    @php
                        $isActive = request()->routeIs($item['route']); 
                        
                        // Item aktif: Teks putih dan border Sky Blue
                        $activeClasses = 'bg-[#203A43]/80 text-white border-b-2 border-[#0096FF]';
                        
                        // Item tidak aktif: Teks Putih, Hover Sky Blue
                        $inactiveClasses = 'text-white hover:bg-[#203A43]/50 hover:text-[#0096FF]';
                    @endphp

                    <a href="{{ route($item['route']) }}" 
                        class="px-3 py-2 rounded-md text-sm font-medium transition duration-200 
                                {{ $isActive ? $activeClasses : $inactiveClasses }}">
                        {{ $item['name'] }}
                    </a>
                @endforeach
            </div>

            <!-- Mobile menu button -->
            <div class="flex sm:hidden">
                {{-- Icon Hamburger berwarna Sky Blue --}}
                <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-[#0096FF] hover:text-white hover:bg-[#203A43]/50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#0096FF]" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    
                    <!-- Icon when menu is closed -->
                    <svg id="icon-open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg id="icon-close" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu" style="display:none;">
        {{-- Mobile menu background Deep Grey-Blue --}}
        <div class="px-2 pt-2 pb-3 space-y-1 bg-[#203A43]">
            @foreach ($navItems as $item)
                @php
                    $isActive = request()->routeIs($item['route']);
                    // Mobile Active: Teks Sky Blue, border Sky Blue
                    $activeClasses = 'bg-[#203A43] text-[#0096FF] border-l-4 border-[#0096FF]';
                    // Mobile Inactive: Teks Putih, Hover Sky Blue
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
                
                // Toggle icon visibility
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');

                // Toggle menu visibility
                if (menu.style.display === "none") {
                    menu.style.display = "block";
                } else {
                    menu.style.display = "none";
                }
            });
        }
    });
</script>

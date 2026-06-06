<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kopi Ajoe') }} - Manager Operasional</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: width 0.3s ease-in-out; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true, isMobile: window.innerWidth < 1024 }" x-init="window.addEventListener('resize', () => { isMobile = window.innerWidth < 1024; if (isMobile) sidebarOpen = false; })">
        
        <!-- SIDEBAR - Full height, tidak terpotong -->
        <aside :class="{
            'w-72': sidebarOpen && !isMobile,
            'w-20': !sidebarOpen && !isMobile,
            'translate-x-0': sidebarOpen && isMobile,
            '-translate-x-full': !sidebarOpen && isMobile,
            'fixed inset-y-0 left-0 z-50': isMobile,
            'relative shadow-xl': !isMobile
        }" class="bg-white border-r border-gray-200 transition-all duration-300 ease-out sidebar-transition h-full min-h-screen overflow-y-auto">
            
            <!-- Logo Area dengan padding yang pas -->
            <div class="sticky top-0 bg-white z-10 px-5 py-6 border-b border-gray-100">
                <div :class="{'justify-center': !sidebarOpen && !isMobile}" class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div x-show="sidebarOpen || isMobile" class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center">
                                <span class="text-white font-bold text-sm">KA</span>
                            </div>
                            <div>
                                <h1 class="text-lg font-bold text-gray-800 tracking-tight">KOPI AJOE</h1>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Manager Ops</p>
                            </div>
                        </div>
                        <div x-show="!sidebarOpen && !isMobile" class="mx-auto">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center">
                                <span class="text-white font-bold text-xs">KA</span>
                            </div>
                        </div>
                    </div>
                    <!-- Tombol toggle desktop -->
                    <button @click="sidebarOpen = !sidebarOpen" x-show="!isMobile" 
                            class="text-gray-400 hover:text-amber-600 transition p-1 rounded-lg hover:bg-gray-100">
                        <svg x-show="sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                        </svg>
                        <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="px-4 py-6 space-y-1">
                <a :href="'{{ route('manager.dashboard') }}'" 
                   class="flex items-center py-2.5 px-3 rounded-xl transition-all duration-200 {{ request()->routeIs('manager.dashboard') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span x-show="sidebarOpen || isMobile" class="ml-3 text-sm whitespace-nowrap" x-cloak>Dashboard Ops</span>
                </a>
                
                <div x-show="sidebarOpen || isMobile" class="pt-4 pb-2 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider" x-cloak>Inventory & Logistik</div>
                <div x-show="!sidebarOpen && !isMobile" class="h-px bg-gray-100 my-2"></div>

                <a :href="'{{ route('manager.stocks.index') }}'" 
                   class="flex items-center py-2.5 px-3 rounded-xl transition-all duration-200 {{ request()->routeIs('manager.stocks.*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span x-show="sidebarOpen || isMobile" class="ml-3 text-sm whitespace-nowrap" x-cloak>Stok Gudang</span>
                </a>
                
                <div x-show="sidebarOpen || isMobile" class="pt-4 pb-2 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider" x-cloak>Operasional Seller</div>
                <div x-show="!sidebarOpen && !isMobile" class="h-px bg-gray-100 my-2"></div>

                <a :href="'{{ route('manager.sessions.index') }}'" 
                   class="flex items-center py-2.5 px-3 rounded-xl transition-all duration-200 {{ request()->routeIs('manager.sessions.*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span x-show="sidebarOpen || isMobile" class="ml-3 text-sm whitespace-nowrap" x-cloak>Sesi Berjualan</span>
                </a>

                <a :href="'{{ route('manager.salaries.index') }}'" 
                   class="flex items-center py-2.5 px-3 rounded-xl transition-all duration-200 {{ request()->routeIs('manager.salaries.*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span x-show="sidebarOpen || isMobile" class="ml-3 text-sm whitespace-nowrap" x-cloak>Approval Upah</span>
                </a>
            </nav>

            <!-- Footer sidebar (optional) -->
            <div x-show="sidebarOpen || isMobile" class="absolute bottom-6 left-0 right-0 text-center text-xs text-gray-400" x-cloak>
                <p>© {{ date('Y') }} Kopi Ajoe Ops</p>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- TOPBAR -->
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur-md border-b border-gray-100 px-6 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-amber-600 focus:outline-none lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>
                    <h1 class="text-2xl font-semibold text-gray-800">
                        {{ $header ?? 'Manager Dashboard' }}
                    </h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Notifikasi -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative p-2 text-gray-500 hover:text-amber-600 transition rounded-full hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 z-50" style="display: none;">
                            <div class="p-3 border-b border-gray-100 font-semibold text-gray-800">Notifikasi</div>
                            <div class="p-4 text-center text-sm text-gray-500">Belum ada notifikasi baru</div>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 text-gray-700 hover:text-amber-700 transition">
                                <div class="hidden md:block text-right">
                                    <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-amber-600">Manager</p>
                                </div>
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-amber-500 to-amber-600 flex items-center justify-center text-white shadow-sm">
                                    <span class="text-sm font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-medium">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <main class="flex-1 p-6 lg:p-8 bg-gray-50">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
        
        <!-- Overlay mobile -->
        <div x-show="sidebarOpen && isMobile" @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black/30 backdrop-blur-sm lg:hidden transition-opacity duration-300" 
             x-transition.opacity style="display: none;"></div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kopi Ajoe') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-[#FDF8F5] to-[#F2EBE5] text-gray-800">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">
        
        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-80 bg-gradient-to-b from-[#2E1A1B] to-[#1A0B0C] text-white shadow-2xl transition-transform duration-300 ease-out lg:translate-x-0 lg:static lg:inset-0 lg:rounded-r-3xl">
            
            <!-- Logo Area -->
            <div class="flex items-center justify-center h-24 border-b border-white/10">
                <div class="text-center">
                    <span class="text-3xl font-bold font-serif tracking-wider bg-gradient-to-r from-amber-300 to-amber-500 bg-clip-text text-transparent">KOPI AJOE</span>
                    <p class="text-xs text-amber-300/70 mt-1">Admin Panel</p>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8 px-5 space-y-2">
                <x-sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </x-sidebar-link>
                
                <x-sidebar-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Manajemen Akun
                </x-sidebar-link>
                
                <x-sidebar-link :href="route('admin.motors.index')" :active="request()->routeIs('admin.motors.*')">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Data Motor
                </x-sidebar-link>
                
                <x-sidebar-link :href="route('admin.menus.index')" :active="request()->routeIs('admin.menus.*')">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Data Menu
                </x-sidebar-link>
            </nav>

            <!-- Footer Sidebar (opsional) -->
            <div class="absolute bottom-6 left-0 right-0 text-center text-xs text-white/30">
                <p>© {{ date('Y') }} Kopi Ajoe</p>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- TOPBAR -->
            <header class="h-20 bg-white/80 backdrop-blur-md shadow-sm flex items-center justify-between px-6 lg:px-8 sticky top-0 z-30 border-b border-gray-100">
                <div class="flex items-center gap-4">
                    <!-- Mobile menu button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-amber-700 focus:outline-none lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>
                    
                    <h1 class="text-2xl font-semibold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        {{ $header ?? 'Admin Panel' }}
                    </h1>
                </div>
                
                <!-- Profile Dropdown -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center space-x-2 text-gray-700 hover:text-amber-800 focus:outline-none transition">
                                    <div class="hidden md:block text-sm font-medium">{{ Auth::user()->name }}</div>
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-r from-amber-500 to-amber-700 flex items-center justify-center text-white shadow-md">
                                        <span class="text-sm font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:text-red-800">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
        
        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden transition-opacity duration-300" 
             x-transition.opacity style="display: none;"></div>
    </div>
</body>
</html>
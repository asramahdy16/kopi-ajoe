<x-manager-layout>
    <x-slot name="header">
        Dashboard Operasional
    </x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Sesi Aktif -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Sesi Aktif</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['active_sessions']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-cyan-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">Seller sedang berkeliling</p>
        </div>

        <!-- Sesi Selesai -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Sesi Selesai</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['completed_sessions']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">Hari ini</p>
        </div>

        <!-- Penjualan Hari Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Penjualan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($stats['today_sales'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">Total omzet</p>
        </div>

        <!-- Stok Menipis -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Stok Menipis</p>
                    <p class="text-3xl font-bold {{ $stats['low_stocks'] > 0 ? 'text-red-600' : 'text-gray-800' }} mt-1">{{ $stats['low_stocks'] }} Item</p>
                </div>
                <div class="w-12 h-12 rounded-lg {{ $stats['low_stocks'] > 0 ? 'bg-red-50' : 'bg-gray-100' }} flex items-center justify-center">
                    <svg class="w-6 h-6 {{ $stats['low_stocks'] > 0 ? 'text-red-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">Perlu restock segera</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Seller Aktif (Card Modern) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white">
                    <h3 class="text-base font-semibold text-gray-800 flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        Seller Sedang Berkeliling
                    </h3>
                    <a href="{{ route('manager.sessions.index') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">Lihat Semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Seller</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($activeSellers as $session)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">
                                                {{ substr($session->seller->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-800">{{ $session->seller->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-gray-100 text-gray-600 text-xs font-mono">
                                            {{ $session->motor->plate_number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $session->started_at ? $session->started_at->format('H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('manager.sessions.show', $session) }}" class="text-amber-600 hover:text-amber-800 text-sm">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <p>Tidak ada seller aktif saat ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Stok Menipis (Card Ringkas) -->
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full">
                <div class="px-6 py-4 border-b border-gray-100 bg-white">
                    <h3 class="text-base font-semibold text-gray-800">⚠️ Peringatan Stok</h3>
                </div>
                <div class="p-5">
                    @if($lowStockItems->count() > 0)
                        <div class="space-y-3">
                            @foreach($lowStockItems as $stock)
                                <div class="flex items-center justify-between p-3 rounded-lg bg-red-50/40 border border-red-100">
                                    <div class="flex items-center gap-3">
                                        @if($stock->menu->image_path)
                                            <img src="{{ asset('storage/' . $stock->menu->image_path) }}" class="w-8 h-8 rounded-md object-cover">
                                        @else
                                            <div class="w-8 h-8 rounded-md bg-gray-200 flex items-center justify-center text-gray-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $stock->menu->name }}</p>
                                            <p class="text-xs text-gray-500">Sisa: {{ $stock->current_stock }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold text-red-600 bg-red-100 px-2 py-1 rounded-full">! Stok</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-5 text-center">
                            <a href="{{ route('manager.stocks.index') }}" class="inline-flex items-center gap-1 text-sm bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Stok
                            </a>
                        </div>
                    @else
                        <div class="flex flex-col items-center py-8 text-center">
                            <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <p class="text-gray-500 text-sm">Semua stok aman</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Tambahan (Placeholder) -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-base font-semibold text-gray-800 mb-4">📈 Tren Penjualan (7 Hari)</h3>
            <div class="h-64">
                <canvas id="salesTrendChart"></canvas>
            </div>
            <p class="text-xs text-gray-400 text-center mt-3">*Data dummy, integrasi real-time segera hadir</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-base font-semibold text-gray-800 mb-4">🏍️ Top Seller (Sesi)</h3>
            <div class="h-64">
                <canvas id="topSellersChart"></canvas>
            </div>
            <p class="text-xs text-gray-400 text-center mt-3">*Berdasarkan jumlah sesi minggu ini</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const salesCtx = document.getElementById('salesTrendChart')?.getContext('2d');
            if (salesCtx) {
                new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                        datasets: [{
                            label: 'Omzet (Rp)',
                            data: [2800000, 3200000, 2900000, 4100000, 4800000, 5300000, 4650000],
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.05)',
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: true }
                });
            }
            const sellerCtx = document.getElementById('topSellersChart')?.getContext('2d');
            if (sellerCtx) {
                new Chart(sellerCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Budi', 'Ani', 'Citra', 'Dedi', 'Eka'],
                        datasets: [{
                            label: 'Jumlah Sesi',
                            data: [12, 10, 8, 7, 5],
                            backgroundColor: '#10b981',
                            borderRadius: 6
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: true }
                });
            }
        });
    </script>
</x-manager-layout>
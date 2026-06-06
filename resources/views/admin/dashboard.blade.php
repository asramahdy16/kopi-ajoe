<x-admin-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-amber-200 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($stats['total_users']) }}</p>
                </div>
                <div class="p-3 rounded-full bg-gradient-to-br from-amber-100 to-amber-200 text-amber-700">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-green-200 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Seller Aktif</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($stats['active_sellers']) }}</p>
                </div>
                <div class="p-3 rounded-full bg-gradient-to-br from-emerald-100 to-emerald-200 text-emerald-700">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Motor</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($stats['total_motors']) }}</p>
                </div>
                <div class="p-3 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-700">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-amber-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Penjualan Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($stats['today_sales'], 0, ',', '.') }}</p>
                </div>
                <div class="p-3 rounded-full bg-gradient-to-br from-yellow-100 to-yellow-200 text-yellow-700">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Grafik Placeholder -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📊 Tren Seller Aktif & Total Motor</h3>
            <div class="h-64">
                <canvas id="motorSellerChart"></canvas>
            </div>
            <p class="text-xs text-gray-400 text-center mt-3">*Placeholder: data statis 7 hari terakhir</p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">💰 Penjualan Per Hari (7 Hari Terakhir)</h3>
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
            <p class="text-xs text-gray-400 text-center mt-3">*Placeholder: data dummy dalam Rupiah</p>
        </div>
    </div>

    <!-- Welcome Section -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="relative p-8 md:p-10">
            <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(circle at 10% 20%, #2E1A1B 1px, transparent 1px); background-size: 20px 20px;"></div>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-600 max-w-2xl">
                        Gunakan menu di sebelah kiri untuk mengelola data akun pengguna, inventaris motor, dan menu produk. 
                        Pantau performa toko Anda melalui grafik di atas.
                    </p>
                </div>
                <div class="hidden md:block">
                    <img src="https://ui-avatars.com/api/?background=2E1A1B&color=fff&rounded=true&bold=true&size=80&name=Kopi+A" alt="Admin avatar" class="rounded-2xl shadow-md">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart 1: Bar chart untuk Seller Aktif & Total Motor
            const ctx1 = document.getElementById('motorSellerChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [
                        {
                            label: 'Seller Aktif',
                            data: [12, 19, 15, 17, 22, 25, 20],
                            backgroundColor: 'rgba(16, 185, 129, 0.6)',
                            borderColor: 'rgb(16, 185, 129)',
                            borderWidth: 1
                        },
                        {
                            label: 'Total Motor',
                            data: [30, 28, 32, 35, 40, 45, 42],
                            backgroundColor: 'rgba(59, 130, 246, 0.6)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: { legend: { position: 'top' } }
                }
            });

            // Chart 2: Line chart untuk Penjualan per Hari
            const ctx2 = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [{
                        label: 'Penjualan (Rp)',
                        data: [1250000, 1500000, 1100000, 1800000, 2100000, 2500000, 1950000],
                        borderColor: 'rgb(245, 158, 11)',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
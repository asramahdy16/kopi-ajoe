<x-manager-layout>
    <x-slot name="header">
        Pantauan Sesi Seller
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-emerald-800 text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="space-y-8">
        
        <!-- Sesi Pending (Menunggu Persetujuan Stok) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-amber-50/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Menunggu Persetujuan Stok
                </h3>
                <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full">{{ $pendingSessions->count() }} Seller</span>
            </div>
            
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-semibold border-b border-slate-100">Seller</th>
                            <th class="px-6 py-4 font-semibold border-b border-slate-100">Motor</th>
                            <th class="px-6 py-4 font-semibold border-b border-slate-100">Jumlah Item Diajukan</th>
                            <th class="px-6 py-4 font-semibold border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pendingSessions as $session)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $session->seller->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $session->motor->plate_number }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $session->sessionStocks->sum('qty_requested') }} item</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('manager.sessions.show', $session) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition-all">
                                        Review & Setujui
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                    Tidak ada pengajuan stok yang menunggu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sesi Aktif -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-cyan-50/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Seller Sedang Berkeliling (Aktif)
                </h3>
                <span class="bg-cyan-100 text-cyan-700 text-xs font-bold px-2.5 py-1 rounded-full">{{ $activeSessions->count() }} Aktif</span>
            </div>
            
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-semibold border-b border-slate-100">Seller</th>
                            <th class="px-6 py-4 font-semibold border-b border-slate-100">Motor</th>
                            <th class="px-6 py-4 font-semibold border-b border-slate-100">Waktu Berangkat</th>
                            <th class="px-6 py-4 font-semibold border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($activeSessions as $session)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $session->seller->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $session->motor->plate_number }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $session->started_at ? $session->started_at->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('manager.sessions.show', $session) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg text-sm font-medium transition-all">
                                        Tutup Sesi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                    Tidak ada seller yang sedang berkeliling.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Sesi Selesai -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Sesi Selesai (Hari Ini)
                </h3>
                <span class="bg-slate-200 text-slate-700 text-xs font-bold px-2.5 py-1 rounded-full">{{ $completedSessions->count() }} Selesai</span>
            </div>
            
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-semibold border-b border-slate-100">Seller</th>
                            <th class="px-6 py-4 font-semibold border-b border-slate-100">Waktu Berangkat</th>
                            <th class="px-6 py-4 font-semibold border-b border-slate-100">Waktu Pulang</th>
                            <th class="px-6 py-4 font-semibold border-b border-slate-100">Total Penjualan</th>
                            <th class="px-6 py-4 font-semibold border-b border-slate-100 text-right">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($completedSessions as $session)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $session->seller->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $session->started_at ? $session->started_at->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $session->ended_at ? $session->ended_at->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 font-bold text-emerald-600">Rp {{ number_format($session->salaryRecord->total_sales ?? 0, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('manager.sessions.show', $session) }}" class="text-slate-500 hover:text-slate-800 text-sm font-medium transition-all">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada sesi yang selesai hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-manager-layout>

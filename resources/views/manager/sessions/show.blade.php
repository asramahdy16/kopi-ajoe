<x-manager-layout>
    <x-slot name="header">
        Detail Sesi: {{ $session->seller->name }}
    </x-slot>

    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="{{ route('manager.sessions.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-cyan-700 transition text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Sesi
        </a>
    </div>

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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Info Sesi -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                    <div class="w-14 h-14 rounded-full bg-cyan-100 text-cyan-700 flex items-center justify-center font-bold text-xl">
                        {{ substr($session->seller->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">{{ $session->seller->name }}</h3>
                        <p class="text-sm text-slate-500">Seller Kopi Ajoe</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status Sesi</p>
                        @if($session->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-sm font-bold">
                                Menunggu Persetujuan
                            </span>
                        @elseif($session->status == 'active')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cyan-100 text-cyan-700 text-sm font-bold">
                                Sedang Aktif (Berkeliling)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200 text-slate-700 text-sm font-bold">
                                Selesai
                            </span>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tanggal</p>
                        <p class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Motor Digunakan</p>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 font-medium text-slate-700 text-sm">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                {{ $session->motor->plate_number }}
                            </span>
                            <span class="text-sm text-slate-500">{{ $session->motor->brand }}</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Berangkat</p>
                            <p class="font-medium text-slate-800">{{ $session->started_at ? $session->started_at->format('H:i') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kembali</p>
                            <p class="font-medium text-slate-800">{{ $session->ended_at ? $session->ended_at->format('H:i') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if(in_array($session->status, ['completed', 'cancelled']) && $session->salaryRecord)
            <!-- Ringkasan Upah (jika sudah selesai) -->
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 shadow-md text-white">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Ringkasan Pendapatan
                </h3>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm opacity-90">
                        <span>Total Penjualan:</span>
                        <span class="font-bold">Rp {{ number_format($session->salaryRecord->total_sales, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm opacity-90">
                        <span>Upah Pokok:</span>
                        <span class="font-bold">Rp {{ number_format($session->salaryRecord->base_salary, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm opacity-90">
                        <span>Komisi ({{ $session->seller->commission_rate }}%):</span>
                        <span class="font-bold">Rp {{ number_format($session->salaryRecord->commission, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-white/20">
                    <p class="text-xs uppercase tracking-wider opacity-80 mb-1">Total Dibayarkan</p>
                    <h2 class="text-3xl font-bold">Rp {{ number_format($session->salaryRecord->total_salary, 0, ',', '.') }}</h2>
                </div>
            </div>
            @endif
        </div>

        <!-- Detail Konten (Tengah & Kanan) -->
        <div class="lg:col-span-2 space-y-6">
            
            @if($session->status == 'pending')
                <!-- Form Persetujuan Stok -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 bg-amber-50/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Review & Persetujuan Stok Awal</h3>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('manager.sessions.approve', $session) }}" method="POST">
                            @csrf
                            <div class="overflow-x-auto mb-6">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                                            <th class="py-3 font-semibold">Item Menu</th>
                                            <th class="py-3 font-semibold text-center">Stok Gudang</th>
                                            <th class="py-3 font-semibold text-center text-amber-600">Diajukan Seller</th>
                                            <th class="py-3 font-semibold text-center text-emerald-600">Disetujui Manager</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($session->sessionStocks as $stock)
                                            @php
                                                $globalStock = \App\Models\MenuStock::where('menu_id', $stock->menu_id)->first()->current_stock ?? 0;
                                            @endphp
                                            <tr>
                                                <td class="py-4 font-medium text-slate-800">{{ $stock->menu->name }}</td>
                                                <td class="py-4 text-center">
                                                    <span class="px-2 py-1 bg-slate-100 rounded text-slate-700 font-bold text-sm">{{ $globalStock }}</span>
                                                </td>
                                                <td class="py-4 text-center text-amber-600 font-bold">
                                                    {{ $stock->qty_requested }}
                                                </td>
                                                <td class="py-4">
                                                    <div class="flex justify-center">
                                                        <input type="number" name="stocks[{{ $stock->id }}][approved]" value="{{ min($stock->qty_requested, $globalStock) }}" min="0" max="{{ $globalStock }}" 
                                                               class="w-20 text-center rounded-lg border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 p-1.5 text-sm font-bold">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="flex justify-end pt-4 border-t border-slate-100">
                                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-bold shadow-md transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Setujui Stok & Mulai Sesi Berjualan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @if($session->status == 'active')
                <!-- Pantauan Transaksi & Sisa Stok Aktif -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 bg-cyan-50/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Status Stok Dibawa</h3>
                    </div>
                    
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-semibold border-b border-slate-100">Item Menu</th>
                                    <th class="px-6 py-4 font-semibold border-b border-slate-100 text-center">Awal Bawa</th>
                                    <th class="px-6 py-4 font-semibold border-b border-slate-100 text-center">Terjual</th>
                                    <th class="px-6 py-4 font-semibold border-b border-slate-100 text-center">Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($session->sessionStocks as $stock)
                                    @php
                                        $terjual = $stock->qty_approved - $stock->qty_remaining;
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-slate-800">{{ $stock->menu->name }}</td>
                                        <td class="px-6 py-4 text-center text-slate-500">{{ $stock->qty_approved }}</td>
                                        <td class="px-6 py-4 text-center font-bold text-emerald-600">{{ $terjual }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-2 py-1 {{ $stock->qty_remaining <= 2 ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-700' }} rounded font-bold text-sm">
                                                {{ $stock->qty_remaining }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Form Tutup Sesi -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mt-6 border-t-4 border-t-cyan-500">
                    <div class="px-6 py-5 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Tutup Sesi & Validasi Laporan</h3>
                        <p class="text-sm text-slate-500 mt-1">Lakukan ini saat seller sudah kembali ke markas (Check-out).</p>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('manager.sessions.close', $session) }}" method="POST">
                            @csrf
                            
                            <div class="bg-slate-50 p-4 rounded-xl mb-6 flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-slate-500 font-medium mb-1">Total Penjualan Sementara (Sistem):</p>
                                    <h4 class="text-2xl font-bold text-emerald-600">Rp {{ number_format($session->transactions->sum('total_amount'), 0, ',', '.') }}</h4>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500 font-medium mb-1">Total Transaksi:</p>
                                    <h4 class="text-2xl font-bold text-slate-700">{{ $session->transactions->count() }} Transaksi</h4>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label for="manager_notes" class="block text-sm font-semibold text-slate-700 mb-2">Catatan Validasi (Opsional)</label>
                                <textarea name="manager_notes" id="manager_notes" rows="3" placeholder="Contoh: Uang tunai sesuai, sisa stok sesuai fisik."
                                          class="w-full rounded-xl border border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 py-2.5 px-3"></textarea>
                            </div>
                            
                            <div class="flex justify-end pt-4 border-t border-slate-100">
                                <button type="submit" onclick="return confirm('Anda yakin ingin menutup sesi ini? Sisa stok akan otomatis dikembalikan ke gudang dan upah akan dihitung.')" 
                                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-bold shadow-md transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Konfirmasi Tutup Sesi & Hitung Upah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @if(in_array($session->status, ['completed', 'cancelled']))
                <!-- Riwayat Transaksi -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Daftar Transaksi</h3>
                        <span class="text-sm font-medium text-slate-500">{{ $session->transactions->count() }} Transaksi</span>
                    </div>
                    
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-semibold border-b border-slate-100">Waktu</th>
                                    <th class="px-6 py-4 font-semibold border-b border-slate-100">Metode Bayar</th>
                                    <th class="px-6 py-4 font-semibold border-b border-slate-100">Item</th>
                                    <th class="px-6 py-4 font-semibold border-b border-slate-100 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($session->transactions as $trx)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-slate-600">{{ $trx->created_at->format('H:i:s') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase {{ $trx->payment_method == 'qris' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                {{ $trx->payment_method }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600">
                                            <ul class="list-disc list-inside">
                                            @foreach($trx->items as $item)
                                                <li>{{ $item->menu->name }} (x{{ $item->quantity }})</li>
                                            @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold text-slate-800">
                                            Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                            Tidak ada transaksi pada sesi ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-manager-layout>

<x-manager-layout>
    <x-slot name="header">
        Manajemen Stok Gudang
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-emerald-800 text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Tabel Stok Global (2 Kolom) -->
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Ketersediaan Stok Saat Ini</h3>
                        <p class="text-sm text-slate-500 mt-1">Stok riil yang tersedia di gudang pusat</p>
                    </div>
                </div>
                
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold border-b border-slate-100">Item Menu</th>
                                <th class="px-6 py-4 font-semibold border-b border-slate-100 text-center">Status</th>
                                <th class="px-6 py-4 font-semibold border-b border-slate-100 text-right">Stok Tersedia</th>
                                <th class="px-6 py-4 font-semibold border-b border-slate-100 text-right">Batas Minimum</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($stocks as $stock)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            @if($stock->menu->photo)
                                                <img src="{{ Storage::url($stock->menu->photo) }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200">
                                            @else
                                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center border border-slate-200">
                                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $stock->menu->name }}</p>
                                                <p class="text-xs text-slate-500 mt-0.5">{{ $stock->menu->category ?? 'Tanpa Kategori' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($stock->current_stock <= $stock->low_stock_threshold)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                                Menipis
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Aman
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-lg font-bold {{ $stock->current_stock <= $stock->low_stock_threshold ? 'text-red-600' : 'text-slate-800' }}">
                                            {{ $stock->current_stock }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm text-slate-500">
                                        {{ $stock->low_stock_threshold }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        Belum ada data stok. Stok akan muncul setelah ditambahkan melalui form.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Riwayat Stok Masuk -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-bold text-slate-800">Riwayat Stok Masuk (Terbaru)</h3>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500">
                                <th class="px-6 py-3 font-medium border-b border-slate-100">Tanggal</th>
                                <th class="px-6 py-3 font-medium border-b border-slate-100">Item</th>
                                <th class="px-6 py-3 font-medium border-b border-slate-100 text-right">Jumlah</th>
                                <th class="px-6 py-3 font-medium border-b border-slate-100">Diinput Oleh</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentEntries as $entry)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-6 py-3 text-slate-600">{{ \Carbon\Carbon::parse($entry->entry_date)->format('d M Y') }}</td>
                                    <td class="px-6 py-3 font-medium text-slate-800">{{ $entry->menu->name }}</td>
                                    <td class="px-6 py-3 text-right text-emerald-600 font-bold">+{{ $entry->quantity }}</td>
                                    <td class="px-6 py-3 text-slate-500">{{ $entry->manager->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada riwayat stok masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Input Stok (1 Kolom) -->
        <div class="xl:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-28">
                <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-900 to-slate-800 text-white">
                    <h3 class="text-lg font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Input Stok Masuk
                    </h3>
                    <p class="text-xs text-slate-300 mt-1">Tambahkan stok baru dari supplier</p>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('manager.stocks.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-5">
                            <!-- Tanggal Masuk -->
                            <div>
                                <label for="entry_date" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                                <input type="date" name="entry_date" id="entry_date" value="{{ old('entry_date', date('Y-m-d')) }}" 
                                       class="w-full rounded-xl border border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 py-2.5 px-3 transition-all" required>
                                @error('entry_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Pilih Item -->
                            <div>
                                <label for="menu_id" class="block text-sm font-semibold text-slate-700 mb-2">Item Menu <span class="text-red-500">*</span></label>
                                <select name="menu_id" id="menu_id" class="w-full rounded-xl border border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 py-2.5 px-3 bg-white" required>
                                    <option value="">-- Pilih Item --</option>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->id }}" {{ old('menu_id') == $menu->id ? 'selected' : '' }}>
                                            {{ $menu->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('menu_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Jumlah -->
                            <div>
                                <label for="quantity" class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Tambahan <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </div>
                                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" 
                                           class="w-full pl-10 pr-3 py-2.5 rounded-xl border border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200" required>
                                </div>
                                @error('quantity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Catatan -->
                            <div>
                                <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">Catatan / Supplier (Opsional)</label>
                                <textarea name="notes" id="notes" rows="3" 
                                          class="w-full rounded-xl border border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 py-2.5 px-3">{{ old('notes') }}</textarea>
                                @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-bold shadow-md transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Simpan Stok Masuk
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout>

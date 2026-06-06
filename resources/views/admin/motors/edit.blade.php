<x-admin-layout>
    <x-slot name="header">
        Edit Motor
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.motors.index') }}" 
           class="inline-flex items-center gap-2 text-gray-500 hover:text-amber-700 transition text-sm font-medium group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Motor
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl mx-auto transition-shadow hover:shadow-md">
        <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white px-8 py-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Edit Data Motor</h3>
                    <p class="text-xs text-gray-500">Ubah informasi inventaris motor listrik</p>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.motors.update', $motor) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Nama Motor -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Motor <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $motor->name) }}" 
                               class="w-full rounded-xl border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 transition-all duration-200" required>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Plat Nomor -->
                    <div>
                        <label for="plate_number" class="block text-sm font-semibold text-gray-700 mb-2">
                            Plat Nomor <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="plate_number" id="plate_number" value="{{ old('plate_number', $motor->plate_number) }}" 
                               class="w-full rounded-xl border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 font-mono uppercase transition-all duration-200" required>
                        @error('plate_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="brand" class="block text-sm font-semibold text-gray-700 mb-2">
                            Merk / Tipe <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand', $motor->brand) }}" 
                               class="w-full rounded-xl border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 transition-all duration-200" required>
                        @error('brand') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Battery Capacity dengan progress bar preview -->
                    <div>
                        <label for="battery_capacity" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kapasitas Baterai (%) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="battery_capacity" id="battery_capacity" value="{{ old('battery_capacity', $motor->battery_capacity) }}" 
                               min="0" max="100" class="w-full rounded-xl border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 transition-all duration-200" required>
                        <div class="mt-2 w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div id="batteryPreview" class="h-full bg-amber-500 rounded-full transition-all duration-300" style="width: {{ old('battery_capacity', $motor->battery_capacity) }}%"></div>
                        </div>
                        @error('battery_capacity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status Ketersediaan <span class="text-red-500">*</span></label>
                        <select name="status" id="status" 
                                class="w-full rounded-xl border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 bg-white" required>
                            <option value="available" {{ old('status', $motor->status) == 'available' ? 'selected' : '' }}>🟢 Tersedia</option>
                            <option value="in_use" {{ old('status', $motor->status) == 'in_use' ? 'selected' : '' }}>🔵 Sedang Digunakan</option>
                            <option value="maintenance" {{ old('status', $motor->status) == 'maintenance' ? 'selected' : '' }}>🔴 Maintenance</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Is Active -->
                    <div>
                        <label for="is_active" class="block text-sm font-semibold text-gray-700 mb-2">Status Operasional <span class="text-red-500">*</span></label>
                        <select name="is_active" id="is_active" 
                                class="w-full rounded-xl border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 bg-white" required>
                            <option value="1" {{ old('is_active', $motor->is_active) == '1' ? 'selected' : '' }}>✅ Aktif</option>
                            <option value="0" {{ old('is_active', $motor->is_active) == '0' ? 'selected' : '' }}>⛔ Non-Aktif</option>
                        </select>
                        @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t border-gray-100">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white rounded-xl text-sm font-medium shadow-sm transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview baterai
        const batteryInput = document.getElementById('battery_capacity');
        const batteryPreview = document.getElementById('batteryPreview');
        if (batteryInput && batteryPreview) {
            batteryInput.addEventListener('input', function() {
                let val = Math.min(100, Math.max(0, this.value));
                batteryPreview.style.width = val + '%';
                if (val < 20) batteryPreview.classList.add('bg-red-500');
                else if (val < 50) batteryPreview.classList.add('bg-yellow-500');
                else batteryPreview.classList.remove('bg-red-500', 'bg-yellow-500');
            });
        }
    </script>
</x-admin-layout>
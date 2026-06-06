<x-admin-layout>
    <x-slot name="header">
        Tambah Motor
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.motors.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center text-sm font-medium">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white shadow-md rounded-xl overflow-hidden max-w-3xl">
        <div class="p-6">
            <form action="{{ route('admin.motors.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Nama Motor -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Motor <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required placeholder="Cth: Motor Seller 1">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Plat Nomor -->
                    <div>
                        <label for="plate_number" class="block text-sm font-medium text-gray-700 mb-1">Plat Nomor <span class="text-red-500">*</span></label>
                        <input type="text" name="plate_number" id="plate_number" value="{{ old('plate_number') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm font-mono uppercase" required placeholder="B 1234 ABC">
                        @error('plate_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Merk / Tipe <span class="text-red-500">*</span></label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required placeholder="Cth: Yadea / Gesits">
                        @error('brand') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Battery Capacity -->
                    <div>
                        <label for="battery_capacity" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas Baterai Awal (%) <span class="text-red-500">*</span></label>
                        <input type="number" name="battery_capacity" id="battery_capacity" value="{{ old('battery_capacity', 100) }}" min="0" max="100" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required>
                        @error('battery_capacity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Ketersediaan <span class="text-red-500">*</span></label>
                        <select name="status" id="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required>
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>Sedang Digunakan</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Is Active -->
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Status Operasional <span class="text-red-500">*</span></label>
                        <select name="is_active" id="is_active" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required>
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="bg-[#1A0B0C] hover:bg-[#1A0B0C]/90 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                        Simpan Motor
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

<x-admin-layout>
    <x-slot name="header">
        Tambah Pengguna
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center text-sm font-medium">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white shadow-md rounded-xl overflow-hidden max-w-3xl">
        <div class="p-6">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required>
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required>
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required>
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                        <select name="role" id="role" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required x-data @change="$dispatch('role-changed', $event.target.value)">
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                        </select>
                        @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="is_active" id="is_active" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required>
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Seller Specific Fields -->
                <div x-data="{ role: '{{ old('role') }}' }" @@role-changed.window="role = $event.detail">
                    <div x-show="role === 'seller'" class="p-4 bg-gray-50 rounded-lg border border-gray-200 mb-6" style="display: none;">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4">Pengaturan Gaji Seller</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="base_salary" class="block text-sm font-medium text-gray-700 mb-1">Gaji Pokok Harian (Rp)</label>
                                <input type="number" name="base_salary" id="base_salary" value="{{ old('base_salary', 50000) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm">
                                @error('base_salary') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="commission_rate" class="block text-sm font-medium text-gray-700 mb-1">Persentase Komisi (%)</label>
                                <input type="number" step="0.1" name="commission_rate" id="commission_rate" value="{{ old('commission_rate', 10) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm">
                                @error('commission_rate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="bg-[#1A0B0C] hover:bg-[#1A0B0C]/90 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

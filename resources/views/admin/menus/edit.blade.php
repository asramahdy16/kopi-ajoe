<x-admin-layout>
    <x-slot name="header">
        Edit Menu Produk
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.menus.index') }}" 
           class="inline-flex items-center gap-2 text-gray-500 hover:text-amber-700 transition text-sm font-medium group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Menu
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl mx-auto transition-shadow hover:shadow-md">
        <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white px-8 py-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Edit Menu Produk</h3>
                    <p class="text-xs text-gray-500">Ubah informasi menu, harga, dan foto produk</p>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Foto Upload Area -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Foto Produk</label>
                        <div class="flex flex-col sm:flex-row items-start gap-6">
                            <div class="relative w-32 h-32 rounded-xl bg-gray-50 border-2 border-dashed border-gray-200 overflow-hidden flex items-center justify-center group hover:border-amber-300 transition">
                                @if($menu->image_path)
                                    <img id="imagePreview" src="{{ asset('storage/' . $menu->image_path) }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @else
                                    <svg id="placeholderIcon" class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg" 
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 transition"
                                       onchange="previewImage(event)">
                                <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG. Maks: 2MB. Kosongkan jika tidak ingin mengubah foto.</p>
                            </div>
                        </div>
                        @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Nama Menu -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Menu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" 
                               class="w-full rounded-xl border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 transition" required>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="category" id="category" value="{{ old('category', $menu->category) }}" 
                               class="w-full rounded-xl border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 transition" required>
                        @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Harga Jual (Rp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-sm">Rp</span>
                            </div>
                            <input type="number" name="price" id="price" value="{{ old('price', $menu->price) }}" min="0" 
                                   class="w-full pl-10 pr-3 py-2.5 rounded-xl border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 transition" required>
                        </div>
                        @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status Tampil -->
                    <div>
                        <label for="is_active" class="block text-sm font-semibold text-gray-700 mb-2">Status Tampil <span class="text-red-500">*</span></label>
                        <select name="is_active" id="is_active" 
                                class="w-full rounded-xl border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 bg-white" required>
                            <option value="1" {{ old('is_active', $menu->is_active) == '1' ? 'selected' : '' }}>✅ Aktif (Tampil di Aplikasi)</option>
                            <option value="0" {{ old('is_active', $menu->is_active) == '0' ? 'selected' : '' }}>⛔ Non-Aktif (Disembunyikan)</option>
                        </select>
                        @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Produk</label>
                        <textarea name="description" id="description" rows="4" 
                                  class="w-full rounded-xl border border-gray-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 py-2.5 px-3 transition">{{ old('description', $menu->description) }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t border-gray-100">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white rounded-xl text-sm font-medium shadow-sm transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan Menu
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('placeholderIcon');
            reader.onload = function(){
                if (preview) {
                    preview.src = reader.result;
                    preview.classList.remove('hidden');
                    preview.style.display = 'block';
                }
                if (placeholder) placeholder.style.display = 'none';
            };
            if(event.target.files[0]){
                reader.readAsDataURL(event.target.files[0]);
            }
        }
        // Inisialisasi preview
        if (document.getElementById('imagePreview') && document.getElementById('imagePreview').src) {
            document.getElementById('imagePreview').style.display = 'block';
        }
    </script>
</x-admin-layout>
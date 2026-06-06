<x-admin-layout>
    <x-slot name="header">
        Tambah Menu Produk
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.menus.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center text-sm font-medium">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white shadow-md rounded-xl overflow-hidden max-w-3xl">
        <div class="p-6">
            <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Image Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Produk</label>
                        <div class="flex items-center space-x-6">
                            <div class="shrink-0 w-24 h-24 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200" id="imagePreviewContainer">
                                <svg id="placeholderIcon" class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <img id="imagePreview" src="" class="hidden w-full h-full object-cover">
                            </div>
                            <label class="block">
                                <span class="sr-only">Pilih foto profil</span>
                                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg" class="block w-full text-sm text-slate-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100
                                " onchange="previewImage(event)">
                                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maks: 2MB.</p>
                            </label>
                        </div>
                        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Nama Menu -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Menu <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required placeholder="Cth: Kopi Susu Aren">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="category" id="category" value="{{ old('category') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required placeholder="Cth: Coffee / Non-Coffee">
                        @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required placeholder="15000">
                        @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Is Active -->
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Status Tampil <span class="text-red-500">*</span></label>
                        <select name="is_active" id="is_active" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" required>
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif (Tampil di Aplikasi)</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Non-Aktif (Disembunyikan)</option>
                        </select>
                        @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk</label>
                        <textarea name="description" id="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm" placeholder="Tuliskan deskripsi singkat produk ini...">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Saat menu baru disimpan, sistem akan secara otomatis membuatkan entri <strong>Stok Pusat (Global Stock)</strong> dengan nilai 0. Anda dapat mengisi stok melalui panel Manager nantinya.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="bg-[#1A0B0C] hover:bg-[#1A0B0C]/90 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                        Simpan Menu
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('imagePreview');
                const placeholder = document.getElementById('placeholderIcon');
                output.src = reader.result;
                output.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            if(event.target.files[0]){
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</x-admin-layout>

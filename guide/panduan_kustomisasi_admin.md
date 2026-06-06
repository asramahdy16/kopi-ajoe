# Panduan Kustomisasi Tampilan Admin — Kopi Ajoe

Panduan ini menjelaskan struktur file, cara kerja styling, dan langkah-langkah praktis untuk mengubah tampilan halaman admin secara manual.

---

## 1. Prasyarat: Menjalankan Dev Server

Sebelum mengedit tampilan, pastikan **dua terminal** ini selalu berjalan bersamaan:

```bash
# Terminal 1 — Laravel server
php artisan serve

# Terminal 2 — Vite + Tailwind (WAJIB agar CSS ter-compile)
npm run dev
```

> [!IMPORTANT]
> Tanpa `npm run dev`, perubahan class Tailwind **tidak akan terlihat** di browser. Vite akan otomatis me-refresh halaman setiap kali Anda menyimpan file `.blade.php` atau `.css`.

---

## 2. Peta File Tampilan Admin

```
resources/views/
├── layouts/
│   └── admin.blade.php          ← Layout utama (sidebar + topbar + content area)
├── components/
│   └── sidebar-link.blade.php   ← Komponen link navigasi sidebar
└── admin/
    ├── dashboard.blade.php      ← Halaman dashboard (statistik)
    ├── users/
    │   ├── index.blade.php      ← Tabel daftar pengguna
    │   ├── create.blade.php     ← Form tambah pengguna
    │   └── edit.blade.php       ← Form edit pengguna
    ├── motors/
    │   ├── index.blade.php      ← Tabel daftar motor
    │   ├── create.blade.php     ← Form tambah motor
    │   └── edit.blade.php       ← Form edit motor
    └── menus/
        ├── index.blade.php      ← Tabel daftar menu
        ├── create.blade.php     ← Form tambah menu
        └── edit.blade.php       ← Form edit menu
```

| Anda ingin mengubah...            | Edit file ini                                |
|-----------------------------------|----------------------------------------------|
| Sidebar (logo, menu navigasi)     | `layouts/admin.blade.php`                    |
| Topbar (header, profil dropdown)  | `layouts/admin.blade.php`                    |
| Gaya link sidebar (hover, aktif)  | `components/sidebar-link.blade.php`          |
| Tampilan dashboard                | `admin/dashboard.blade.php`                  |
| Tabel atau form CRUD              | `admin/users/*.blade.php`, dst.              |
| Warna global / font              | `tailwind.config.js` + `resources/css/app.css` |

---

## 3. Sistem Warna yang Digunakan

Proyek ini menggunakan **Tailwind CSS arbitrary values** (`bg-[#hex]`) untuk warna brand. Berikut palet warnanya:

### Warna Brand
| Nama             | Kode Hex    | Tailwind Class          | Dipakai untuk                     |
|------------------|-------------|-------------------------|-----------------------------------|
| Dark Maroon      | `#1A0B0C`   | `bg-[#1A0B0C]`          | Sidebar, topbar seller, tombol utama |
| Classic Brown    | `#8B5A2B`   | `bg-[#8B5A2B]`          | Sidebar link aktif, aksen         |
| Lighter Brown    | `#A56F3F`   | `bg-[#A56F3F]`          | Hover pada aksen                  |
| Background Base  | `#F4F6F9`   | `bg-[#F4F6F9]`          | Background halaman utama          |
| Text Primary     | `#2D3748`   | `text-[#2D3748]`        | Teks utama body                   |

### Contoh Mengubah Warna

**Mengubah warna sidebar dari Dark Maroon ke Biru Gelap:**
```html
<!-- SEBELUM -->
<div class="... bg-[#1A0B0C] ...">

<!-- SESUDAH -->
<div class="... bg-[#1E3A5F] ...">
```

**Mengubah warna tombol utama:**
```html
<!-- SEBELUM -->
<button class="bg-[#1A0B0C] hover:bg-[#1A0B0C]/90 ...">

<!-- SESUDAH — gunakan warna hijau misalnya -->
<button class="bg-emerald-600 hover:bg-emerald-700 ...">
```

> [!TIP]
> Anda bisa menggunakan format hex langsung (`bg-[#hex]`) atau class bawaan Tailwind (`bg-red-500`, `bg-blue-600`, dll). Referensi lengkap warna: [Tailwind Colors](https://tailwindcss.com/docs/colors)

---

## 4. Mengubah Layout Utama

File: [admin.blade.php](file:///e:/Mata%20Kuliah/Vibe%20Coding/kopi-ajoe/resources/views/layouts/admin.blade.php)

### 4.1 Sidebar

Sidebar berada di dalam `<div class="fixed ... w-72 bg-[#1A0B0C] ...">`. Struktur utamanya:

```html
<!-- Logo / Brand -->
<div class="flex items-center justify-center h-20 ...">
    <span class="text-2xl font-bold ...">KOPI AJOE</span>  ← Ubah teks di sini
</div>

<!-- Menu Navigasi -->
<nav class="mt-6 px-4 space-y-2">
    <x-sidebar-link :href="..." :active="...">
        <svg ...>...</svg>   ← Ikon (SVG)
        Dashboard            ← Label teks
    </x-sidebar-link>
    <!-- ...menu lainnya... -->
</nav>
```

**Cara menambah menu baru di sidebar:**
```html
<x-sidebar-link :href="route('admin.nama-route')" :active="request()->routeIs('admin.nama-route.*')">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <!-- Salin path SVG dari https://heroicons.com -->
    </svg>
    Nama Menu Baru
</x-sidebar-link>
```

**Mengubah lebar sidebar:**
```html
<!-- Ubah w-72 menjadi w-64 (lebih sempit) atau w-80 (lebih lebar) -->
<div class="... w-72 ...">     →     <div class="... w-64 ...">
```

### 4.2 Topbar

Topbar berada di `<header class="h-20 bg-white shadow-sm ...">`:

```html
<!-- Judul halaman -->
<h1 class="text-2xl font-semibold text-gray-800">
    {{ $header ?? 'Admin Panel' }}    ← Nilai default jika tidak diset
</h1>
```

Judul ini diset dari masing-masing halaman via slot:
```html
<x-slot name="header">
    Dashboard    ← Teks yang muncul di topbar
</x-slot>
```

### 4.3 Area Konten

Konten halaman dirender di:
```html
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F4F6F9] p-6">
    {{ $slot }}    ← Isi halaman masuk di sini
</main>
```

Untuk mengubah padding konten: ubah `p-6` → `p-8` (lebih lebar) atau `p-4` (lebih sempit).

---

## 5. Mengubah Komponen Sidebar Link

File: [sidebar-link.blade.php](file:///e:/Mata%20Kuliah/Vibe%20Coding/kopi-ajoe/resources/views/components/sidebar-link.blade.php)

```php
@php
$classes = ($active ?? false)
    // ← Style saat menu AKTIF (sedang dikunjungi)
    ? 'flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-[#8B5A2B] text-white transition-colors'
    // ← Style saat menu TIDAK AKTIF (default)
    : 'flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-300 hover:bg-[#8B5A2B]/80 hover:text-white transition-colors';
@endphp
```

| Anda ingin...                        | Ubah ini                                         |
|--------------------------------------|--------------------------------------------------|
| Warna background menu aktif          | `bg-[#8B5A2B]` → warna lain                     |
| Warna teks menu tidak aktif          | `text-gray-300` → `text-gray-400` dll            |
| Efek hover                           | `hover:bg-[#8B5A2B]/80` → warna/opacity lain    |
| Ukuran padding                       | `px-4 py-3` → `px-6 py-4` (lebih lebar)         |
| Bentuk sudut                         | `rounded-lg` → `rounded-full` / `rounded-none`  |

---

## 6. Mengubah Halaman Dashboard

File: [dashboard.blade.php](file:///e:/Mata%20Kuliah/Vibe%20Coding/kopi-ajoe/resources/views/admin/dashboard.blade.php)

### Card Statistik

Setiap card statistik memiliki struktur:
```html
<div class="bg-white rounded-xl shadow-md p-6">          ← Card wrapper
    <div class="flex items-center">
        <div class="p-3 rounded-full bg-[#1A0B0C]/10 ...">  ← Lingkaran ikon
            <svg ...>                                         ← Ikon SVG
        </div>
        <div>
            <p class="mb-2 text-sm ...">Total Pengguna</p>   ← Label
            <p class="text-3xl font-bold ...">{{ $stats['total_users'] }}</p>  ← Angka
        </div>
    </div>
</div>
```

**Contoh: menambah card statistik baru:**
```html
<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex items-center">
        <div class="p-3 rounded-full bg-pink-100 text-pink-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Label Baru</p>
            <p class="text-3xl font-bold text-gray-800">{{ $nilaiDariController }}</p>
        </div>
    </div>
</div>
```

**Mengubah jumlah kolom grid:**
```html
<!-- 4 kolom (default) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

<!-- 3 kolom -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

<!-- 2 kolom -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
```

---

## 7. Mengubah Halaman Tabel (Index)

Contoh file: [users/index.blade.php](file:///e:/Mata%20Kuliah/Vibe%20Coding/kopi-ajoe/resources/views/admin/users/index.blade.php)

### Struktur Tabel
```html
<table class="w-full text-left text-sm text-gray-600">
    <thead class="bg-gray-50 text-gray-700 uppercase font-medium border-b ...">
        <tr>
            <th class="px-6 py-4">Nama</th>   ← Kolom header
            <!-- ...kolom lain... -->
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse ($users as $user)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">{{ $user->name }}</td>  ← Data
                <!-- ...kolom lain... -->
            </tr>
        @empty
            <tr><td colspan="5">Tidak ada data.</td></tr>
        @endforelse
    </tbody>
</table>
```

**Menambah kolom baru** (misal: tanggal registrasi):
1. Tambah `<th>` di `<thead>`:
   ```html
   <th class="px-6 py-4">Terdaftar</th>
   ```
2. Tambah `<td>` di `<tbody>`:
   ```html
   <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>
   ```
3. Perbarui `colspan` di bagian `@empty`.

### Badge Status
```html
<!-- Hijau (aktif) -->
<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Aktif</span>

<!-- Merah (non-aktif) -->
<span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">Non-Aktif</span>

<!-- Kuning (pending) -->
<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">Pending</span>
```

---

## 8. Mengubah Halaman Form (Create/Edit)

Contoh file: [users/create.blade.php](file:///e:/Mata%20Kuliah/Vibe%20Coding/kopi-ajoe/resources/views/admin/users/create.blade.php)

### Struktur Input
```html
<div>
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
        Nama Lengkap <span class="text-red-500">*</span>
    </label>
    <input type="text" name="name" id="name"
           value="{{ old('name') }}"
           class="w-full rounded-lg border-gray-300 shadow-sm
                  focus:border-[#1A0B0C] focus:ring-[#1A0B0C] sm:text-sm"
           required>
    @error('name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
```

| Anda ingin...                        | Ubah ini                                              |
|--------------------------------------|-------------------------------------------------------|
| Warna border saat fokus              | `focus:border-[#1A0B0C]` → `focus:border-blue-500`   |
| Warna ring saat fokus                | `focus:ring-[#1A0B0C]` → `focus:ring-blue-500`       |
| Ukuran border radius                 | `rounded-lg` → `rounded-md` / `rounded-xl`           |
| Jumlah kolom form                    | `grid-cols-2` → `grid-cols-1` (1 kolom penuh)        |

---

## 9. Cheat Sheet Class Tailwind yang Sering Dipakai

### Spacing
| Class      | Ukuran   | Kegunaan                    |
|------------|----------|-----------------------------|
| `p-4`      | 16px     | Padding kecil               |
| `p-6`      | 24px     | Padding standar             |
| `p-8`      | 32px     | Padding lebar               |
| `gap-4`    | 16px     | Jarak antar item grid       |
| `gap-6`    | 24px     | Jarak standar               |
| `mb-6`     | 24px     | Margin bawah                |
| `space-y-2`| 8px      | Jarak vertikal antar elemen |

### Typography
| Class                 | Efek                    |
|-----------------------|-------------------------|
| `text-sm`             | 14px (kecil)            |
| `text-base`           | 16px (normal)           |
| `text-lg`             | 18px (agak besar)       |
| `text-xl`             | 20px (besar)            |
| `text-2xl`            | 24px (judul)            |
| `text-3xl`            | 30px (angka statistik)  |
| `font-medium`         | Ketebalan sedang        |
| `font-semibold`       | Ketebalan semi-tebal    |
| `font-bold`           | Ketebalan tebal         |

### Bentuk & Shadow
| Class          | Efek                           |
|----------------|--------------------------------|
| `rounded-md`   | Sudut melengkung kecil (6px)   |
| `rounded-lg`   | Sudut melengkung sedang (8px)  |
| `rounded-xl`   | Sudut melengkung besar (12px)  |
| `rounded-full` | Sudut lingkaran penuh          |
| `shadow-sm`    | Bayangan tipis                 |
| `shadow-md`    | Bayangan standar               |
| `shadow-lg`    | Bayangan besar                 |

---

## 10. Tips & Referensi

1. **Ikon SVG**: Semua ikon berasal dari [Heroicons](https://heroicons.com/). Buka situs, cari ikon, copy SVG-nya.
2. **Tailwind Docs**: Referensi lengkap class → [tailwindcss.com/docs](https://tailwindcss.com/docs)
3. **Alpine.js**: Interaktivitas sidebar mobile dan form dinamis (misal: field seller muncul saat role dipilih) menggunakan Alpine.js. Docs → [alpinejs.dev](https://alpinejs.dev)
4. **Preview cepat**: Setelah menyimpan file `.blade.php`, Vite otomatis me-refresh browser. Tidak perlu restart server.
5. **Production build**: Sebelum deploy, jalankan `npm run build` sekali untuk menghasilkan CSS/JS yang sudah di-minify.

> [!TIP]
> Jika Anda menambahkan warna hex baru yang belum pernah dipakai (misal `bg-[#FF5733]`), Tailwind akan otomatis mendeteksi dan meng-compile-nya selama `npm run dev` berjalan. Tidak perlu konfigurasi tambahan.

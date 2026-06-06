# Full Design Plan: Kopi Ajoe Web Application

Dokumen ini adalah cetak biru (blueprint) komprehensif untuk antarmuka pengguna (UI) dan pengalaman pengguna (UX) web Kopi Ajoe. Meliputi sistem desain (design tokens), komponen UI, arsitektur layout per peran, dan panduan interaksi.

---

## 1. Design System & Design Tokens

Sistem desain ini memastikan konsistensi visual di seluruh platform (Landing Page, Admin, Manager, Seller).

### 1.1. Color Palette (Palet Warna)

Diambil dari identitas visual logo Kopi Ajoe (Dark Maroon & White).

**Brand Colors:**
- `Primary Dark`: `#1A0B0C` (Dark Maroon / Deep Coffee) - Digunakan untuk background Landing Page, Sidebar Admin, teks utama di Light Theme.
- `Primary Light`: `#FFFFFF` (Pure White) - Background utama internal, teks utama di Dark Theme.
- `Accent`: `#8B5A2B` (Classic Brown) - Warna aksen sekunder untuk variasi elemen (icon, border).
- `Accent Highlight`: `#A56F3F` (Lighter Brown) - Untuk efek hover pada elemen Accent.

**Neutral Colors (Light Theme Base):**
- `Background Base`: `#F4F6F9` (Off-white/Light Gray) - Background halaman internal untuk memberi kontras pada Card putih.
- `Surface (Card)`: `#FFFFFF` - Latar belakang komponen card dan form.
- `Text Primary`: `#2D3748` - Warna teks utama pada light theme (bukan hitam pekat agar tidak melelahkan mata).
- `Text Secondary`: `#718096` - Warna teks sekunder, placeholder, meta data.
- `Border Color`: `#E2E8F0` - Warna garis batas halus pada tabel dan pemisah.

**Semantic Colors (Status):**
- `Success (Sukses/Tersedia)`: `#10B981` (Emerald Green)
- `Warning (Peringatan/Stok Menipis)`: `#F59E0B` (Amber)
- `Danger (Error/Habis/Hapus)`: `#EF4444` (Red)
- `Info (Informasi)`: `#3B82F6` (Blue)

### 1.2. Typography (Tipografi)

- **Heading Font:** `Playfair Display` (Serif)
  - Penggunaan: Khusus untuk Landing Page (H1, H2, H3) memberikan kesan klasik, premium, dan elegan.
- **Body & Internal Dashboard Font:** `Inter` (Sans-Serif)
  - Penggunaan: Teks paragraf Landing Page, dan **seluruh UI Internal (Seller, Manager, Admin)**. `Inter` sangat optimal untuk UI padat data dan mudah dibaca di layar kecil.

**Scale (Mobile - Desktop):**
- `H1`: 32px - 48px, Bold
- `H2`: 24px - 36px, Semi-Bold
- `H3`: 20px - 28px, Semi-Bold
- `Body Large`: 16px - 18px, Regular
- `Body Normal`: 14px - 16px, Regular
- `Caption`: 12px, Regular/Medium

### 1.3. Spacing, Grid, & Shape

- **Spacing Unit:** Berbasis 4px (4, 8, 12, 16, 24, 32, 48, 64).
- **Border Radius (Shape):**
  - `Small (4px)`: Checkbox, Badge kecil.
  - `Medium (8px)`: Tombol (Button), Input Field, Dropdown.
  - `Large (12px - 16px)`: Card utama, Modal Dialog, Gambar produk.
- **Elevation (Shadows):**
  - `Shadow-Sm`: `0 1px 2px rgba(0,0,0,0.05)` (Header internal, navigasi bawah)
  - `Shadow-Md`: `0 4px 6px rgba(0,0,0,0.05)` (Cards, Dropdown menu)
  - `Shadow-Lg`: `0 10px 15px rgba(0,0,0,0.1)` (Modal, Popover)

### 1.4. Animation & Transitions

- **Durasi Standar:** `200ms` (Cepat dan responsif untuk internal web).
- **Durasi Landing Page:** `500ms - 800ms` (Lebih lambat dan halus untuk kesan elegan).
- **Easing:** `ease-in-out` atau `cubic-bezier(0.4, 0, 0.2, 1)`.

---

## 2. UI Components Library (Katalog Komponen)

### 2.1. Buttons (Tombol)
Semua tombol menggunakan border-radius 8px.
- **Primary Button:** Background `#1A0B0C`, Text `#FFFFFF`. Hover: background sedikit lebih terang. Digunakan untuk aksi utama (Simpan, Bayar, Check-in).
- **Secondary Button:** Background `#FFFFFF`, Border `#E2E8F0`, Text `#2D3748`. Hover: Background `#F4F6F9`. Digunakan untuk aksi alternatif (Batal, Kembali).
- **Danger Button:** Background `#EF4444`, Text `#FFFFFF`. Khusus untuk aksi destruktif (Hapus Data).

### 2.2. Inputs & Forms
- **Text Field:** Border `#E2E8F0`, Background `#FFFFFF`, Radius 8px. Saat fokus (active), border berubah menjadi `#1A0B0C` dengan *subtle glow*.
- **Search Bar:** Menyertakan icon *magnifying glass* (Feather Icons) di sebelah kiri placeholder.

### 2.3. Cards
- Latar `#FFFFFF`, Shadow-Md, Radius 12px.
- Padding standar `24px` untuk desktop, `16px` untuk mobile.

### 2.4. Badges & Status Indicators
Berbentuk pil bulat memanjang (Radius 999px), teks ukuran 12px, font-weight Semi-Bold.
- *Active/Approved*: Latar `#D1FAE5`, Teks `#065F46`
- *Pending*: Latar `#FEF3C7`, Teks `#92400E`
- *Inactive/Rejected*: Latar `#FEE2E2`, Teks `#991B1B`

---

## 3. Layout Architecture per Role

### 3.1. Landing Page (Public)
*Menargetkan pelanggan / publik. Desain Dark Theme.*

- **Layout Structure:**
  - **Header (Sticky transparent):** Logo Kopi Ajoe (kiri), Navigasi teks sederhana (kanan). Berubah solid Dark Maroon `#1A0B0C` saat di-scroll ke bawah. **Tidak ada tombol login.**
  - **Hero Section:** Full viewport height (`100vh`). Background warna `#1A0B0C` solid dengan tekstur/foto gelap yang menyatu. Tagline Kopi Ajoe di tengah dengan tipografi Playfair Display. Animasi *fade-in-up* yang elegan saat halaman dibuka.
  - **About Section:** Layout 2 kolom (Teks penjelasan di satu sisi, Foto produk/motor di sisi lain).
  - **Menu Preview:** Grid produk unggulan Kopi Ajoe (Card gelap dengan efek hover *soft-glow* untuk interaktivitas).
  - **Footer:** Simple, teks abu-abu terang, menyertakan alamat, media sosial, dan hak cipta.

### 3.2. Seller Application (Mobile-First)
*Menargetkan Seller di lapangan. Desain Light Theme. Harus bisa digunakan secara ergonomis dengan satu tangan.*

- **Viewport Batasan:** `320px - 480px` (Lebar layar smartphone standar).
- **Layout Structure:**
  - **Top Bar (Sticky):** Ringkas. Menampilkan Nama Seller, Waktu berjalan, dan Icon Sinyal/Sinkronisasi. Background `#1A0B0C`, teks `#FFFFFF`.
  - **Main Content Area:** Background `#F4F6F9` terang untuk memberikan kontras. Scrollable.
    - *Bagian atas:* Indikator "Sisa Stok Keseluruhan" berupa Progress Bar tebal.
    - *Daftar Menu:* Ditampilkan dalam format Card vertikal (List). Tiap card berisi Nama Kopi, Harga, dan komponen penambah/pengurang pesanan (Tombol `[-]` besar, Angka Kuantitas, Tombol `[+]` besar).
  - **Bottom Navigation / Action Bar (Sticky Footer):** Selalu menempel di dasar layar ponsel.
    - Menampung tombol raksasa "Proses Transaksi" dan informasi "Total: Rp X". Desain ini memudahkan jempol seller dalam mengeksekusi pesanan dengan cepat.

### 3.3. Manager Dashboard (Tablet / Desktop)
*Menargetkan Manager operasional. Desain Light Theme. Fokus pada pemantauan metrik dan manajemen data harian.*

- **Layout Structure:**
  - **Top Navbar:** Lebar penuh. Menampilkan Logo Kopi Ajoe, Search bar global, Notification Bell, Profil Manager. Background `#1A0B0C`.
  - **Main Content (Grid System):** Layout 12-kolom dengan `max-width: 1440px`. Latar `#F4F6F9`.
    - *Bagian Atas:* 4 Card Statistik Utama (Pendapatan Hari Ini, Seller Aktif, Transaksi Selesai, Peringatan Stok Rendah).
    - *Bagian Tengah:* Layout terpisah (Proporsi 70% vs 30%). Kiri: Tabel Live Daftar Sesi Seller. Kanan: List Permintaan Stok yang Menunggu Approval.
  - **Tabel:** Menggunakan sistem pagination, jarak baris (padding) yang lega, dan badge warna-warni untuk status operasional.

### 3.4. Admin Panel (Desktop)
*Menargetkan Admin sistem. Desain Light Theme. Fokus pada manipulasi data kompleks dan pengaturan basis data.*

- **Layout Structure:**
  - **Left Sidebar (Fixed):** Lebar `280px`. Background `#1A0B0C` (Dark Maroon). Menu navigasi vertikal (Dashboard, Manajemen Akun, Data Motor, Data Menu, Settings). Item menu yang aktif ditandai dengan background warna coklat aksen (`#8B5A2B`).
  - **Top Bar:** Hanya menampung Breadcrumb navigasi dan Profil Admin.
  - **Main Content Area:** Lebar mengisi sisa layar (`calc(100% - 280px)`). Background `#F4F6F9`. Form input dibungkus dalam *Card* putih. Form besar dibagi menjadi layout dua kolom agar tidak membuang ruang layar desktop.

---

## 4. Panduan Micro-Interactions & UX (UX Details)

1. **Feedback Instan Seller:** Saat seller menekan tombol `+` pada menu kopi, interaksi memicu *haptic feedback* (getaran HP) atau transisi warna sangat cepat (`100ms`). Ini memastikan seller mendapat umpan balik tanpa harus fokus lama ke layar.
2. **Skeleton Loading:** Alih-alih *spinner* mutar yang memonopoli layar, gunakan *skeleton screen* (blok abu-abu yang berkedip halus) saat memuat data tabel untuk Manager dan Admin. Transisi terasa lebih mulus dan tidak mengejutkan.
3. **Pencegahan Kesalahan (Error Prevention):** 
   - Tombol destruktif ("Hapus Akun", "Tutup Sesi") wajib memunculkan Modal Konfirmasi (Peringatan: "Apakah Anda yakin? Data tidak dapat dipulihkan.").
   - Jika koneksi terputus di sisi Seller di lapangan, munculkan *Toast Notification* berwarna kuning/merah di bagian atas layar ("Koneksi terputus, menyimpan offline...").
4. **Alur Login Akses Langsung:** Mengakomodasi kebutuhan landing page yang steril dari akses sistem, URL portal login (contoh: `/portal` atau `kopi-ajoe.com/gate`) akan di-set langsung mengarah ke halaman form login. Halaman ini berdesain putih polos, terpusat di tengah layar dengan menonjolkan logo Dark Maroon Kopi Ajoe, memisahkan secara total antara urusan bisnis publik dan operasional internal.

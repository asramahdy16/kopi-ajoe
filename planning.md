# Planning: Sistem Manajemen Kopi Keliling
**Versi:** 2.0  
**Tanggal:** Juni 2026  
**Framework:** Laravel 11  
**Status:** Final Planning

---

## Daftar Isi

1. [Gambaran Umum Proyek](#1-gambaran-umum-proyek)
2. [Analisis Kebutuhan](#2-analisis-kebutuhan)
3. [Flowchart Sistem](#3-flowchart-sistem)
4. [Entity Relationship Diagram (ERD)](#4-entity-relationship-diagram-erd)
5. [Activity Diagram](#5-activity-diagram)
6. [Struktur Fitur per Role](#6-struktur-fitur-per-role)
7. [Rancangan Database](#7-rancangan-database)
8. [Arsitektur Aplikasi](#8-arsitektur-aplikasi)
9. [Struktur Folder Laravel](#9-struktur-folder-laravel)
10. [Rancangan API & Route](#10-rancangan-api--route)
11. [Rancangan UI/UX per Role](#11-rancangan-uiux-per-role)
12. [Tech Stack & Dependensi](#12-tech-stack--dependensi)
13. [Security & Performance](#13-security--performance)
14. [Milestone & Timeline](#14-milestone--timeline)
15. [Risiko & Mitigasi](#15-risiko--mitigasi)

---

## 1. Gambaran Umum Proyek

### 1.1 Deskripsi Bisnis

Usaha kopi keliling adalah bisnis penjualan kopi yang beroperasi menggunakan armada motor listrik. Setiap motor listrik dikendarai oleh satu seller. Seller membawa stok kopi yang telah dikonfirmasi oleh manager setiap harinya, kemudian berkeliling untuk berjualan. Hasil penjualan dicatat secara digital melalui web aplikasi ini.

### 1.2 Tujuan Aplikasi

- Mendigitalisasi seluruh proses operasional penjualan kopi keliling
- Memudahkan manager memantau aktivitas seller dan motor secara real-time
- Menyediakan sistem pencatatan transaksi yang akurat dan mudah digunakan seller di lapangan
- Menghasilkan laporan keuangan dan operasional yang komprehensif
- Mengotomasi perhitungan upah dan komisi seller
- Menyediakan tracking stok global yang akurat dan real-time

### 1.3 Pengguna Sistem

| Role    | Jumlah (estimasi) | Platform Utama    |
|---------|--------------------|-------------------|
| Admin   | 1–2 orang         | Desktop           |
| Manager | 1–3 orang         | Desktop / Tablet  |
| Seller  | Banyak orang      | Mobile (prioritas)|

### 1.4 Batasan Sistem

- Aplikasi berbasis web (bukan native mobile app)
- Seller mengakses via browser mobile (PWA-ready)
- Semua transaksi bersifat offline-aware di fase 2 (fase 1: online only)
- Metode pembayaran: tunai dan QRIS

---

## 2. Analisis Kebutuhan

### 2.1 Kebutuhan Fungsional

#### Admin
- CRUD akun pengguna (Admin, Manager, Seller)
- CRUD armada motor listrik beserta status dan kondisi
- CRUD menu kopi (nama, harga, foto, deskripsi, status aktif)
- Mengatur role dan permission setiap akun
- Laporan daftar akun, motor, dan menu
- Reset password pengguna
- Nonaktifkan / aktifkan akun tanpa menghapus data (soft delete)

#### Manager
- Melihat dashboard operasional real-time (motor aktif, seller aktif, transaksi hari ini)
- Manajemen stok masuk dari supplier (input, catat tanggal, jumlah)
- Melihat stok global per menu (total stok tersedia di gudang)
- Menerima dan mengelola pengajuan stok harian dari seller (approve, tolak, ubah jumlah)
- Memantau sesi berjualan seller (motor yang digunakan, waktu berangkat, jumlah transaksi)
- Menutup sesi penjualan harian setelah seller check-out
- Manajemen keuangan: pencatatan modal, pendapatan, pengeluaran
- Kalkulasi dan persetujuan upah seller (upah pokok + komisi)
- Laporan: penjualan harian/mingguan/bulanan, stok, keuangan, performa seller
- Ekspor laporan ke PDF dan Excel
- Notifikasi: pengajuan stok masuk, seller check-out, stok hampir habis

#### Seller
- Check-in: memilih motor yang tersedia dan memulai sesi berjualan
- Mengajukan stok harian ke manager (pilih menu + jumlah)
- Melihat status persetujuan stok dari manager
- Melihat menu yang aktif beserta harga
- Mencatat transaksi per pembeli (pilih menu, jumlah, hitung total, pilih metode bayar)
- Melihat sisa stok secara real-time selama berjualan
- Menerima notifikasi peringatan jika stok mendekati habis
- Check-out: melaporkan selesai berjualan dan mengembalikan motor
- Melihat rekap penjualan dan estimasi upah hari ini
- Riwayat penjualan dan upah pribadi (harian, mingguan, bulanan)
- Mengelola profil pribadi dan ganti password

### 2.2 Kebutuhan Non-Fungsional

- **Responsif:** UI seller harus optimal di layar mobile (320px–480px), didesain untuk penggunaan satu tangan
- **Performa:** Halaman transaksi seller harus load < 2 detik (digunakan di lapangan)
- **Keamanan:** Autentikasi berbasis session/token, proteksi route per role, rate limiting, session timeout
- **Ketersediaan:** Sistem harus dapat diakses 24/7 (minimal downtime)
- **Kemudahan:** Seller tidak perlu pelatihan teknis panjang untuk menggunakan aplikasi
- **PWA-Ready:** Seller UI dapat di-install sebagai app di home screen mobile
- **Audit Trail:** Seluruh aksi kritis dicatat untuk accountability

---

## 3. Flowchart Sistem

### 3.1 Alur Utama Penjualan Harian

```
[START]
   │
   ▼
[Seller datang ke kantor]
   │
   ▼
[Cek motor tersedia?] ──Tidak──► [Tunggu / jadwal ulang] ──► [END]
   │ Ya
   ▼
[Seller pilih motor & catat di sistem]
   │
   ▼
[Seller ajukan stok harian (menu + qty)]
   │
   ▼
[Manager review pengajuan stok]
   │
   ├──Tolak──► [Seller revisi pengajuan] ──► (kembali ke atas)
   │
   └──Approve──►
         │
         ▼
   [Stok global berkurang sesuai qty_approved]
   [Seller berangkat berjualan | Status sesi: AKTIF]
         │
         ▼
   [Ada pembeli?]
         │
         ├──Tidak / Selesai──►
         │                    │
         ├──Ya──►             ▼
         │      │    [Seller kembali ke kantor]
         ▼      │    [Kembalikan motor]
   [Buat transaksi baru]      │
   [Pilih menu & jumlah]      ▼
   [Pilih metode bayar]  [Seller submit laporan ke manager]
         │                    │
         ▼                    ▼
   [Stok cukup?]    [Manager validasi & cocokkan data]
         │                    │
         ├──Tidak──► (kembali ke "Ada pembeli?")
         │                    ▼
         └──Ya──►    [Sistem hitung upah otomatis]
               │     [Pokok + komisi dari penjualan]
               ▼              │
   [Simpan transaksi]         ▼
   [Kurangi stok sesi otomatis] [Manager tutup sesi harian]
   [Event: TransactionCreated]  │
               │                ▼
               └──► (kembali ke "Ada pembeli?")
                                │
                              [Sisa stok sesi dikembalikan ke stok global]
                                │
                                ▼
                             [END]
```

### 3.2 Alur Manajemen Stok (Manager)

```
[Stok datang dari supplier]
   │
   ▼
[Manager input stok masuk]
[Pilih menu, jumlah, tanggal, supplier]
   │
   ▼
[Sistem update stok global (menu_stocks)]
   │
   ▼
[Dashboard stok ter-update]
   │
   ▼
[Jika stok < threshold ──► Notifikasi low stock]
```

### 3.3 Alur Manajemen Akun (Admin)

```
[Admin buka manajemen akun]
   │
   ├──► [Buat akun baru] ──► [Isi data + pilih role] ──► [Simpan] ──► [Log: AccountCreated]
   │
   ├──► [Edit akun] ──► [Ubah data / role] ──► [Simpan] ──► [Log: AccountUpdated]
   │
   ├──► [Nonaktifkan akun] ──► [Konfirmasi] ──► [Soft delete / is_active=false]
   │
   └──► [Reset password] ──► [Generate password baru] ──► [Simpan] ──► [Notif ke user]
```

---

## 4. Entity Relationship Diagram (ERD)

### 4.1 Entitas dan Atribut

#### users
| Kolom           | Tipe         | Keterangan                    |
|-----------------|--------------|-------------------------------|
| id              | BIGINT PK    | Auto increment                |
| name            | VARCHAR(100) | Nama lengkap                  |
| email           | VARCHAR(150) | Unik, untuk login             |
| password        | VARCHAR(255) | Hashed (bcrypt)               |
| role            | ENUM         | admin, manager, seller        |
| phone           | VARCHAR(20)  | Nomor HP                      |
| address         | TEXT         | Alamat (opsional)             |
| base_salary     | DECIMAL(12,2)| Upah pokok per hari           |
| commission_rate | DECIMAL(5,2) | % komisi dari penjualan       |
| is_active       | BOOLEAN      | Status aktif akun             |
| profile_photo   | VARCHAR(255) | Path foto profil              |
| created_at      | TIMESTAMP    |                               |
| updated_at      | TIMESTAMP    |                               |
| deleted_at      | TIMESTAMP    | Soft delete                   |

#### motors
| Kolom            | Tipe         | Keterangan                         |
|------------------|--------------|-------------------------------------|
| id               | BIGINT PK    | Auto increment                     |
| name             | VARCHAR(100) | Nama/label motor (mis. "Motor A")  |
| plate_number     | VARCHAR(20)  | Nomor plat (unik)                  |
| brand            | VARCHAR(50)  | Merek motor                        |
| battery_capacity | INT          | Kapasitas baterai (kWh)            |
| status           | ENUM         | available, in_use, maintenance, inactive |
| condition_notes  | TEXT         | Catatan kondisi                    |
| photo            | VARCHAR(255) | Foto motor                         |
| is_active        | BOOLEAN      | Aktif di sistem                    |
| created_at       | TIMESTAMP    |                                    |
| updated_at       | TIMESTAMP    |                                    |
| deleted_at       | TIMESTAMP    | Soft delete                        |

#### menus
| Kolom       | Tipe         | Keterangan             |
|-------------|--------------|------------------------|
| id          | BIGINT PK    | Auto increment         |
| name        | VARCHAR(100) | Nama produk kopi       |
| description | TEXT         | Deskripsi produk       |
| price       | DECIMAL(10,2)| Harga jual             |
| photo       | VARCHAR(255) | Foto produk            |
| category    | VARCHAR(50)  | Kategori (panas/dingin/dll) |
| is_active   | BOOLEAN      | Tampil di menu seller  |
| created_at  | TIMESTAMP    |                        |
| updated_at  | TIMESTAMP    |                        |
| deleted_at  | TIMESTAMP    | Soft delete            |

#### menu_stocks (Stok Global per Menu — BARU)
| Kolom           | Tipe         | Keterangan                           |
|-----------------|--------------|--------------------------------------|
| id              | BIGINT PK    | Auto increment                       |
| menu_id         | BIGINT FK    | Referensi ke menus (UNIQUE)          |
| current_stock   | INT          | Jumlah stok tersedia saat ini        |
| low_stock_threshold | INT      | Batas minimum sebelum alert (default: 10) |
| updated_at      | TIMESTAMP    | Terakhir diperbarui                  |

**Catatan:** Tabel ini menjadi single source of truth untuk stok global. Di-update oleh observer saat:
- Stok masuk dari supplier (`+qty`)
- Stok diapprove untuk seller (`-qty_approved`)
- Sisa stok dikembalikan setelah sesi selesai (`+qty_remaining`)

#### stock_entries (Stok Masuk dari Supplier)
| Kolom       | Tipe         | Keterangan                  |
|-------------|--------------|------------------------------|
| id          | BIGINT PK    |                             |
| menu_id     | BIGINT FK    | Referensi ke menus          |
| manager_id  | BIGINT FK    | Siapa yang input            |
| quantity    | INT          | Jumlah stok masuk           |
| notes       | TEXT         | Keterangan / nama supplier  |
| entry_date  | DATE         | Tanggal stok masuk          |
| created_at  | TIMESTAMP    |                             |

#### selling_sessions (Sesi Berjualan Harian)
| Kolom           | Tipe         | Keterangan                       |
|-----------------|--------------|----------------------------------|
| id              | BIGINT PK    |                                  |
| seller_id       | BIGINT FK    | Referensi ke users (seller)      |
| motor_id        | BIGINT FK    | Referensi ke motors              |
| manager_id      | BIGINT FK    | Manager yang approve             |
| session_date    | DATE         | Tanggal sesi                     |
| status          | ENUM         | pending, active, completed, cancelled |
| started_at      | TIMESTAMP    | Waktu berangkat                  |
| ended_at        | TIMESTAMP    | Waktu kembali (nullable)         |
| seller_notes    | TEXT         | Catatan dari seller              |
| manager_notes   | TEXT         | Catatan dari manager             |
| created_at      | TIMESTAMP    |                                  |
| updated_at      | TIMESTAMP    |                                  |

#### session_stocks (Stok yang Dibawa Seller per Sesi)
| Kolom            | Tipe      | Keterangan                        |
|------------------|-----------|-----------------------------------|
| id               | BIGINT PK |                                   |
| session_id       | BIGINT FK | Referensi ke selling_sessions     |
| menu_id          | BIGINT FK | Referensi ke menus                |
| qty_requested    | INT       | Jumlah diminta seller             |
| qty_approved     | INT       | Jumlah disetujui manager (nullable) |
| qty_remaining    | INT       | Sisa stok (dihitung otomatis)     |
| status           | ENUM      | pending, approved, rejected       |
| created_at       | TIMESTAMP |                                   |
| updated_at       | TIMESTAMP |                                   |

#### transactions (Transaksi per Pembeli)
| Kolom          | Tipe         | Keterangan                       |
|----------------|--------------|----------------------------------|
| id             | BIGINT PK    |                                  |
| session_id     | BIGINT FK    | Referensi ke selling_sessions    |
| total_amount   | DECIMAL(12,2)| Total harga transaksi            |
| payment_method | ENUM         | cash, qris, transfer             |
| notes          | TEXT         | Catatan transaksi                |
| created_at     | TIMESTAMP    | Waktu transaksi                  |

#### transaction_items (Item per Transaksi)
| Kolom          | Tipe         | Keterangan                  |
|----------------|--------------|------------------------------|
| id             | BIGINT PK    |                             |
| transaction_id | BIGINT FK    | Referensi ke transactions   |
| menu_id        | BIGINT FK    | Referensi ke menus          |
| quantity       | INT          | Jumlah yang dibeli          |
| price_at_sale  | DECIMAL(10,2)| Harga saat transaksi        |
| subtotal       | DECIMAL(12,2)| qty × price_at_sale         |

#### salary_records (Rekap Upah per Sesi)
| Kolom         | Tipe         | Keterangan                       |
|---------------|--------------|----------------------------------|
| id            | BIGINT PK    |                                  |
| session_id    | BIGINT FK    | Referensi ke selling_sessions (UNIQUE) |
| seller_id     | BIGINT FK    | Referensi ke users               |
| base_salary   | DECIMAL(12,2)| Upah pokok hari itu              |
| total_sales   | DECIMAL(12,2)| Total penjualan sesi             |
| commission    | DECIMAL(12,2)| Komisi yang didapat              |
| total_salary  | DECIMAL(12,2)| base_salary + commission         |
| status        | ENUM         | pending, approved, paid          |
| approved_by   | BIGINT FK    | Manager yang approve (nullable)  |
| paid_at       | TIMESTAMP    | Waktu pembayaran (nullable)      |
| created_at    | TIMESTAMP    |                                  |
| updated_at    | TIMESTAMP    |                                  |

#### notifications (Notifikasi Sistem)
| Kolom      | Tipe         | Keterangan                        |
|------------|--------------|-----------------------------------|
| id         | BIGINT PK    |                                   |
| user_id    | BIGINT FK    | Penerima notifikasi               |
| type       | VARCHAR(50)  | stock_request, low_stock, checkout, salary_approved, dll |
| title      | VARCHAR(150) | Judul notifikasi                  |
| message    | TEXT         | Isi pesan                         |
| data       | JSON         | Data tambahan (opsional)          |
| is_read    | BOOLEAN      | Sudah dibaca?                     |
| created_at | TIMESTAMP    |                                   |

### 4.2 Relasi Antar Entitas

```
users (seller)     ──< selling_sessions >── motors
users (manager)    ──< selling_sessions
selling_sessions   ──< session_stocks    >── menus
selling_sessions   ──< transactions
transactions       ──< transaction_items >── menus
selling_sessions   ──1  salary_records        (UNIQUE constraint on session_id)
users (manager)    ──< stock_entries     >── menus
menus              ──1  menu_stocks           (UNIQUE constraint on menu_id)
users              ──< notifications
```

**Keterangan simbol:**
- `──<` = one-to-many (satu ke banyak)
- `──1` = one-to-one (satu ke satu)
- `>──` = many-to-one (banyak ke satu)

### 4.3 Constraint Penting

| Tabel           | Constraint                  | Tujuan                                |
|-----------------|-----------------------------|---------------------------------------|
| salary_records  | UNIQUE(session_id)          | Mencegah duplikasi upah per sesi      |
| menu_stocks     | UNIQUE(menu_id)             | Satu record stok per menu             |
| motors          | UNIQUE(plate_number)        | Tidak boleh ada plat ganda            |
| users           | UNIQUE(email)               | Tidak boleh ada email ganda           |

---

## 5. Activity Diagram

### 5.1 Activity Diagram — Seller (Alur Lengkap)

```
[Seller login]
      │
      ▼
[Dashboard Seller]
      │
      ▼
[Klik "Mulai Berjualan"]
      │
      ▼
[Pilih motor yang tersedia]
      │
      ▼
[Input stok yang akan dibawa]
[Untuk setiap menu: pilih qty]
      │
      ▼
[Submit pengajuan stok]
      │
      ▼
[Tunggu notifikasi persetujuan]
      │
      ├── [Ditolak] ──► [Lihat catatan manager] ──► [Revisi & submit ulang]
      │
      └── [Disetujui] ──►
            │
            ▼
      [Status sesi: AKTIF]
      [Tombol "Tambah Transaksi" aktif]
      [Event: StockApproved → kurangi stok global]
            │
            ▼
      [LOOP: Selama berjualan]
      ┌─────────────────────────────┐
      │                             │
      │  [Ada pembeli]              │
      │       │                     │
      │       ▼                     │
      │  [Buka form transaksi]      │
      │  [Pilih menu + jumlah]      │
      │  [Pilih metode bayar]       │
      │       │                     │
      │       ▼                     │
      │  [Sistem hitung total]      │
      │       │                     │
      │       ▼                     │
      │  [Konfirmasi & simpan]      │
      │  [Stok sesi berkurang]      │
      │  [Event: TransactionCreated]│
      │  [Feedback: vibration/sound]│
      │       │                     │
      └───────┘ (lanjut berjualan)  │
                                    │
      [Stok habis atau selesai] ────┘
            │
            ▼
      [Klik "Selesai Berjualan"]
            │
            ▼
      [Isi laporan penutup]
      [Catatan opsional]
            │
            ▼
      [Submit check-out]
      [Event: SellerCheckedOut]
      [Sisa stok dikembalikan ke stok global]
            │
            ▼
      [Lihat rekap: total jual, estimasi upah]
            │
            ▼
      [Selesai]
```

### 5.2 Activity Diagram — Manager (Alur Harian)

```
[Manager login]
      │
      ▼
[Dashboard Manager]
[Lihat ringkasan hari ini]
      │
      │── [Ada notifikasi pengajuan stok?]
      │         │ Ya
      │         ▼
      │   [Buka permintaan stok seller]
      │   [Review menu & jumlah vs stok global]
      │         │
      │         ├── [Approve] ──► [Event: StockApproved] ──► [Kirim notif ke seller]
      │         ├── [Tolak]   ──► [Tulis alasan & kirim notif]
      │         └── [Ubah qty]──► [Simpan & kirim notif]
      │
      │── [Pantau sesi aktif]
      │         │
      │         ▼
      │   [Lihat daftar seller aktif]
      │   [Motor digunakan, waktu, total transaksi, sisa stok]
      │
      │── [Input stok masuk dari supplier]
      │         │
      │         ▼
      │   [Pilih menu, input jumlah & tanggal]
      │   [Simpan → Event: StockEntryCreated → stok global ter-update]
      │   [Jika stok < threshold → notif low stock]
      │
      │── [Ada seller check-out?]
      │         │ Ya
      │         ▼
      │   [Validasi laporan seller]
      │   [Cocokkan stok sisa & total uang]
      │         │
      │         ▼
      │   [Sistem kalkulasi upah otomatis]
      │         │
      │         ▼
      │   [Manager approve/ubah upah]
      │         │
      │         ▼
      │   [Tutup sesi harian]
      │   [Event: SessionClosed]
      │
      └── [Lihat laporan & export]
                │
                ▼
          [Pilih jenis laporan]
          [Pilih rentang tanggal]
          [Export PDF / Excel]
```

### 5.3 Activity Diagram — Admin (Manajemen Sistem)

```
[Admin login]
      │
      ▼
[Dashboard Admin]
      │
      ├── [Manajemen Akun]
      │         │
      │         ├── [Buat akun baru]
      │         │     [Input data + role + upah pokok + rate komisi]
      │         │     [Simpan → akun aktif]
      │         │     [Log: Activity Log created]
      │         │
      │         ├── [Edit akun]
      │         │     [Ubah data / role / upah]
      │         │     [Simpan → Log: Activity Log updated]
      │         │
      │         ├── [Nonaktifkan akun]
      │         │     [Konfirmasi → Soft Delete (deleted_at) / is_active = false]
      │         │
      │         └── [Reset password]
      │               [Generate sementara → notif ke user]
      │
      ├── [Manajemen Motor]
      │         │
      │         ├── [Tambah motor baru]
      │         │     [Input plat, merek, kapasitas, foto]
      │         │
      │         ├── [Edit data motor]
      │         │
      │         ├── [Ubah status motor]
      │         │     [available / maintenance / inactive]
      │         │
      │         └── [Lihat riwayat penggunaan motor]
      │
      ├── [Manajemen Menu]
      │         │
      │         ├── [Tambah menu baru]
      │         │     [Nama, harga, foto, kategori, deskripsi]
      │         │     [Otomatis buat record menu_stocks dengan current_stock=0]
      │         │
      │         ├── [Edit menu]
      │         │
      │         ├── [Nonaktifkan menu]
      │         │     [Menu tidak muncul di seller]
      │         │
      │         └── [Update harga]
      │
      └── [Lihat Laporan Admin]
                │
                ▼
          [Laporan daftar akun per role]
          [Laporan inventaris motor]
          [Laporan daftar menu aktif/nonaktif]
          [Export laporan PDF / Excel]
```

---

## 6. Struktur Fitur per Role

### 6.1 Admin

| Modul           | Fitur                                              | Prioritas |
|-----------------|----------------------------------------------------|-----------| 
| Auth            | Login, logout, ganti password                      | Tinggi    |
| Manajemen Akun  | CRUD pengguna, atur role, aktif/nonaktif, soft delete | Tinggi    |
| Manajemen Motor | CRUD motor, ubah status, lihat riwayat pakai       | Tinggi    |
| Manajemen Menu  | CRUD menu, upload foto, nonaktifkan                | Tinggi    |
| Laporan Admin   | Laporan akun, motor, menu; export PDF/Excel        | Sedang    |
| Role Permission | Atur hak akses per role (opsional fase 2)          | Rendah    |

### 6.2 Manager

| Modul               | Fitur                                                    | Prioritas |
|---------------------|----------------------------------------------------------|-----------| 
| Auth                | Login, logout, ganti password                            | Tinggi    |
| Dashboard           | Ringkasan hari ini, motor aktif, seller aktif, total jual, stok global | Tinggi    |
| Manajemen Stok      | Input stok masuk, lihat histori stok per menu, stok global | Tinggi    |
| Konfirmasi Stok     | Approve/tolak/ubah pengajuan stok seller                 | Tinggi    |
| Pantau Sesi         | Daftar sesi aktif, detail per seller                     | Tinggi    |
| Validasi Check-out  | Terima laporan seller, validasi, tutup sesi              | Tinggi    |
| Manajemen Keuangan  | Rekap pemasukan, pengeluaran, arus kas                   | Sedang    |
| Manajemen Upah      | Lihat, approve, ubah upah seller per sesi                | Sedang    |
| Notifikasi          | Terima notif pengajuan stok, check-out seller, low stock | Sedang    |
| Laporan             | Penjualan, stok, keuangan, performa seller; export       | Sedang    |

### 6.3 Seller

| Modul           | Fitur                                                | Prioritas |
|-----------------|------------------------------------------------------|-----------| 
| Auth            | Login, logout, ganti password                        | Tinggi    |
| Dashboard       | Status sesi hari ini, sisa stok, total transaksi     | Tinggi    |
| Check-in        | Pilih motor, ajukan stok, submit ke manager          | Tinggi    |
| Transaksi       | Buat transaksi, pilih menu, pilih metode bayar, simpan, lihat riwayat | Tinggi    |
| Stok Monitor    | Lihat sisa stok per menu secara real-time            | Tinggi    |
| Check-out       | Submit laporan selesai berjualan                     | Tinggi    |
| Notifikasi      | Notif stok diapprove/ditolak, peringatan stok habis  | Sedang    |
| Riwayat Pribadi | Riwayat sesi, total penjualan, estimasi upah         | Sedang    |
| Profil          | Lihat data pribadi, ganti password                   | Sedang    |

---

## 7. Rancangan Database

### 7.1 Skema Lengkap (SQL)

```sql
-- Tabel users (dengan Soft Delete)
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','manager','seller') NOT NULL DEFAULT 'seller',
    phone VARCHAR(20) NULL,
    address TEXT NULL,
    base_salary DECIMAL(12,2) DEFAULT 0,
    commission_rate DECIMAL(5,2) DEFAULT 0 COMMENT 'Persentase komisi dari total penjualan',
    is_active BOOLEAN DEFAULT TRUE,
    profile_photo VARCHAR(255) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    INDEX idx_role (role),
    INDEX idx_is_active (is_active)
);

-- Tabel motors (dengan Soft Delete)
CREATE TABLE motors (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    plate_number VARCHAR(20) UNIQUE NOT NULL,
    brand VARCHAR(50) NULL,
    battery_capacity INT NULL COMMENT 'dalam kWh',
    status ENUM('available','in_use','maintenance','inactive') DEFAULT 'available',
    condition_notes TEXT NULL,
    photo VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    INDEX idx_status (status)
);

-- Tabel menus (dengan Soft Delete)
CREATE TABLE menus (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    price DECIMAL(10,2) NOT NULL,
    photo VARCHAR(255) NULL,
    category VARCHAR(50) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    INDEX idx_category (category),
    INDEX idx_is_active (is_active)
);

-- Tabel menu_stocks (Stok Global per Menu — BARU)
CREATE TABLE menu_stocks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    menu_id BIGINT UNSIGNED NOT NULL UNIQUE,
    current_stock INT NOT NULL DEFAULT 0,
    low_stock_threshold INT NOT NULL DEFAULT 10 COMMENT 'Alert ketika stok di bawah angka ini',
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE
);

-- Tabel stock_entries (stok masuk dari supplier)
CREATE TABLE stock_entries (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    menu_id BIGINT UNSIGNED NOT NULL,
    manager_id BIGINT UNSIGNED NOT NULL,
    quantity INT NOT NULL,
    notes TEXT NULL,
    entry_date DATE NOT NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (menu_id) REFERENCES menus(id),
    FOREIGN KEY (manager_id) REFERENCES users(id),
    INDEX idx_entry_date (entry_date)
);

-- Tabel selling_sessions
CREATE TABLE selling_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    seller_id BIGINT UNSIGNED NOT NULL,
    motor_id BIGINT UNSIGNED NOT NULL,
    manager_id BIGINT UNSIGNED NULL,
    session_date DATE NOT NULL,
    status ENUM('pending','active','completed','cancelled') DEFAULT 'pending',
    started_at TIMESTAMP NULL,
    ended_at TIMESTAMP NULL,
    seller_notes TEXT NULL,
    manager_notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (seller_id) REFERENCES users(id),
    FOREIGN KEY (motor_id) REFERENCES motors(id),
    FOREIGN KEY (manager_id) REFERENCES users(id),
    INDEX idx_session_date (session_date),
    INDEX idx_status (status),
    INDEX idx_seller_date (seller_id, session_date)
);

-- Tabel session_stocks
CREATE TABLE session_stocks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id BIGINT UNSIGNED NOT NULL,
    menu_id BIGINT UNSIGNED NOT NULL,
    qty_requested INT NOT NULL,
    qty_approved INT NULL,
    qty_remaining INT NULL,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (session_id) REFERENCES selling_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menus(id)
);

-- Tabel transactions (dengan payment_method)
CREATE TABLE transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id BIGINT UNSIGNED NOT NULL,
    total_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    payment_method ENUM('cash','qris','transfer') NOT NULL DEFAULT 'cash',
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (session_id) REFERENCES selling_sessions(id),
    INDEX idx_created_at (created_at)
);

-- Tabel transaction_items
CREATE TABLE transaction_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    transaction_id BIGINT UNSIGNED NOT NULL,
    menu_id BIGINT UNSIGNED NOT NULL,
    quantity INT NOT NULL,
    price_at_sale DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menus(id)
);

-- Tabel salary_records (dengan UNIQUE session_id & updated_at)
CREATE TABLE salary_records (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id BIGINT UNSIGNED NOT NULL UNIQUE COMMENT 'Satu sesi = satu record upah',
    seller_id BIGINT UNSIGNED NOT NULL,
    base_salary DECIMAL(12,2) NOT NULL DEFAULT 0,
    total_sales DECIMAL(12,2) NOT NULL DEFAULT 0,
    commission DECIMAL(12,2) NOT NULL DEFAULT 0,
    total_salary DECIMAL(12,2) NOT NULL DEFAULT 0,
    status ENUM('pending','approved','paid') DEFAULT 'pending',
    approved_by BIGINT UNSIGNED NULL,
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (session_id) REFERENCES selling_sessions(id),
    FOREIGN KEY (seller_id) REFERENCES users(id),
    FOREIGN KEY (approved_by) REFERENCES users(id),
    INDEX idx_status (status),
    INDEX idx_seller_id (seller_id)
);

-- Tabel notifications
CREATE TABLE notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    type VARCHAR(50) NOT NULL,
    title VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    data JSON NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_user_unread (user_id, is_read),
    INDEX idx_created_at (created_at)
);
```

### 7.2 Aturan Bisnis Database

- Satu seller hanya boleh memiliki satu sesi berstatus `active` pada waktu yang sama
- Motor tidak bisa digunakan dua sesi sekaligus (status harus `available` untuk bisa dipilih)
- `qty_remaining` pada `session_stocks` dihitung otomatis: `qty_approved - total_sold`
- `total_salary` = `base_salary + commission`, di mana `commission = total_sales × (commission_rate / 100)`
- `price_at_sale` disimpan terpisah agar perubahan harga menu tidak mempengaruhi histori transaksi
- `session_id` pada `salary_records` bersifat UNIQUE — satu sesi hanya boleh punya satu record upah
- `menu_id` pada `menu_stocks` bersifat UNIQUE — satu menu hanya punya satu record stok global
- Stok global (`menu_stocks.current_stock`) harus ≥ 0 (tidak boleh negatif)
- Soft delete diterapkan pada `users`, `motors`, `menus` — data tidak benar-benar dihapus
- Gunakan database transaction & pessimistic locking saat operasi yang melibatkan perubahan stok

---

## 8. Arsitektur Aplikasi

### 8.1 Pola Arsitektur

Aplikasi menggunakan pola **MVC (Model-View-Controller)** bawaan Laravel dengan tambahan:
- **Service Layer** untuk logika bisnis yang kompleks
- **Event/Listener** untuk decouple proses yang saling terkait
- **Queue/Job** untuk proses yang tidak perlu blocking (notifikasi)

```
Request
   │
   ▼
Middleware (Auth, Role, RateLimit)
   │
   ▼
Controller
   │
   ├──► Form Request (validasi input)
   │
   ├──► Service (logika bisnis)
   │         │
   │         ├──► Model (Eloquent ORM)
   │         │         │
   │         │         ▼
   │         │      Database
   │         │
   │         └──► Event / Listener
   │                   │
   │                   ├──► Queue Job (notifikasi, dll)
   │                   └──► Observer (update stok, status motor)
   │
   └──► View (Blade Template)
```

### 8.2 Layer Aplikasi

| Layer       | Tanggung Jawab                                          |
|-------------|---------------------------------------------------------|
| Controller  | Menerima request, validasi input, panggil service       |
| Service     | Logika bisnis (hitung upah, kurangi stok, dsb)         |
| Model       | Eloquent ORM, relasi, accessor/mutator, soft delete     |
| View        | Blade template, layout per role                         |
| Middleware  | Autentikasi, otorisasi role, rate limiting, logging     |
| Observer    | Otomasi saat event model (update stok, buat notifikasi) |
| Policy      | Aturan otorisasi per resource                           |
| Event       | Decouple aksi bisnis (TransactionCreated, StockApproved) |
| Listener    | Handler untuk event (kirim notif, update stok global)   |
| Job/Queue   | Proses asinkron (kirim notifikasi, generate laporan)    |

### 8.3 Daftar Event & Listener

| Event                 | Listener                              | Aksi                                         |
|-----------------------|---------------------------------------|-----------------------------------------------|
| TransactionCreated    | UpdateSessionStock                    | Kurangi `qty_remaining` di `session_stocks`  |
| TransactionCreated    | CheckLowStockAlert                    | Kirim notif jika stok sesi < 20%            |
| StockApproved         | DeductGlobalStock                     | Kurangi `menu_stocks.current_stock`          |
| StockApproved         | NotifySellerStockApproved             | Kirim notif ke seller                        |
| StockRejected         | NotifySellerStockRejected             | Kirim notif ke seller + alasan               |
| StockEntryCreated     | UpdateGlobalStock                     | Tambah `menu_stocks.current_stock`           |
| StockEntryCreated     | CheckLowStockResolved                 | Hapus alert low stock jika sudah cukup       |
| SellerCheckedOut      | ReturnRemainingStock                  | Kembalikan sisa stok ke stok global          |
| SellerCheckedOut      | NotifyManagerCheckout                 | Kirim notif ke manager                       |
| SellerCheckedOut      | CalculateSalary                       | Hitung dan buat salary_record                |
| SessionClosed         | UpdateMotorStatus                     | Set motor status = available                 |
| SalaryApproved        | NotifySellerSalaryApproved            | Kirim notif ke seller                        |

### 8.4 Middleware yang Dibutuhkan

```php
// Daftar middleware kustom
'auth.role:admin'         → hanya admin
'auth.role:manager'       → hanya manager
'auth.role:seller'        → hanya seller
'auth.role:admin,manager' → admin atau manager
'session.active'          → seller harus punya sesi aktif
'throttle:login'          → rate limit untuk login (5 percobaan/menit)
```

---

## 9. Struktur Folder Laravel

```
app/
├── Console/
│   └── Commands/
│       └── CloseExpiredSessions.php    ← Perintah artisan untuk tutup sesi otomatis (>24 jam)
│
├── Events/
│   ├── TransactionCreated.php
│   ├── StockApproved.php
│   ├── StockRejected.php
│   ├── StockEntryCreated.php
│   ├── SellerCheckedOut.php
│   ├── SessionClosed.php
│   └── SalaryApproved.php
│
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── AccountController.php
│   │   │   ├── MotorController.php
│   │   │   ├── MenuController.php
│   │   │   └── ReportController.php
│   │   ├── Manager/
│   │   │   ├── DashboardController.php
│   │   │   ├── StockEntryController.php
│   │   │   ├── StockApprovalController.php
│   │   │   ├── SessionMonitorController.php
│   │   │   ├── SessionCloseController.php
│   │   │   ├── FinanceController.php
│   │   │   ├── SalaryController.php
│   │   │   └── ReportController.php
│   │   ├── Seller/
│   │   │   ├── DashboardController.php
│   │   │   ├── CheckInController.php
│   │   │   ├── StockRequestController.php
│   │   │   ├── TransactionController.php
│   │   │   ├── CheckOutController.php
│   │   │   ├── HistoryController.php
│   │   │   └── ProfileController.php
│   │   ├── Auth/
│   │   │   └── LoginController.php
│   │   └── NotificationController.php     ← Shared notification controller
│   │
│   ├── Middleware/
│   │   ├── RoleMiddleware.php
│   │   ├── ActiveSessionMiddleware.php
│   │   └── ThrottleLoginMiddleware.php
│   │
│   └── Requests/
│       ├── StoreUserRequest.php
│       ├── UpdateUserRequest.php
│       ├── StoreMotorRequest.php
│       ├── StoreMenuRequest.php
│       ├── StoreTransactionRequest.php
│       ├── StoreStockRequestRequest.php
│       ├── StoreStockEntryRequest.php
│       └── ChangePasswordRequest.php
│
├── Jobs/
│   ├── SendNotificationJob.php
│   └── GenerateReportJob.php
│
├── Listeners/
│   ├── UpdateSessionStock.php
│   ├── CheckLowStockAlert.php
│   ├── DeductGlobalStock.php
│   ├── UpdateGlobalStock.php
│   ├── ReturnRemainingStock.php
│   ├── CalculateSalary.php
│   ├── UpdateMotorStatus.php
│   ├── NotifySellerStockApproved.php
│   ├── NotifySellerStockRejected.php
│   ├── NotifyManagerCheckout.php
│   └── NotifySellerSalaryApproved.php
│
├── Models/
│   ├── User.php                  ← SoftDeletes trait
│   ├── Motor.php                 ← SoftDeletes trait
│   ├── Menu.php                  ← SoftDeletes trait
│   ├── MenuStock.php
│   ├── StockEntry.php
│   ├── SellingSession.php
│   ├── SessionStock.php
│   ├── Transaction.php
│   ├── TransactionItem.php
│   ├── SalaryRecord.php
│   └── Notification.php
│
├── Services/
│   ├── SellingSessionService.php   ← logika check-in, check-out
│   ├── StockService.php            ← kalkulasi stok global & sesi
│   ├── TransactionService.php      ← simpan transaksi, kurangi stok
│   ├── SalaryService.php           ← hitung upah + komisi
│   └── NotificationService.php     ← buat & kirim notifikasi
│
├── Observers/
│   ├── TransactionObserver.php     ← fire TransactionCreated event
│   ├── SellingSessionObserver.php  ← update status motor
│   └── MenuObserver.php            ← buat menu_stocks record saat menu baru dibuat
│
└── Policies/
    ├── SellingSessionPolicy.php
    ├── TransactionPolicy.php
    └── SalaryRecordPolicy.php

database/
├── migrations/
│   ├── create_users_table.php
│   ├── create_motors_table.php
│   ├── create_menus_table.php
│   ├── create_menu_stocks_table.php
│   ├── create_stock_entries_table.php
│   ├── create_selling_sessions_table.php
│   ├── create_session_stocks_table.php
│   ├── create_transactions_table.php
│   ├── create_transaction_items_table.php
│   ├── create_salary_records_table.php
│   └── create_notifications_table.php
└── seeders/
    ├── DatabaseSeeder.php
    ├── AdminSeeder.php
    ├── MotorSeeder.php
    └── MenuSeeder.php

resources/
└── views/
    ├── layouts/
    │   ├── admin.blade.php
    │   ├── manager.blade.php
    │   └── seller.blade.php       ← layout mobile-first, PWA-ready
    ├── components/
    │   ├── notification-bell.blade.php
    │   ├── toast.blade.php
    │   └── low-stock-banner.blade.php
    ├── admin/
    │   ├── dashboard.blade.php
    │   ├── accounts/
    │   ├── motors/
    │   ├── menus/
    │   └── reports/
    ├── manager/
    │   ├── dashboard.blade.php
    │   ├── stocks/
    │   ├── sessions/
    │   ├── finance/
    │   ├── salary/
    │   └── reports/
    ├── seller/
    │   ├── dashboard.blade.php
    │   ├── checkin/
    │   ├── transaction/
    │   ├── checkout/
    │   ├── history/
    │   └── profile/
    └── notifications/
        └── index.blade.php

public/
├── manifest.json               ← PWA manifest
└── service-worker.js           ← PWA service worker (fase 2)
```

---

## 10. Rancangan API & Route

### 10.1 Route Auth (Shared)

```php
Route::middleware('guest')->group(function () {
    Route::get('login',  [Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [Auth\LoginController::class, 'login'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('change-password',  [Auth\LoginController::class, 'showChangePasswordForm']);
    Route::post('change-password', [Auth\LoginController::class, 'changePassword']);
});
```

### 10.2 Route Notifikasi (Shared)

```php
Route::middleware('auth')->group(function () {
    Route::get('notifications',              [NotificationController::class, 'index']);
    Route::patch('notifications/{id}/read',  [NotificationController::class, 'markAsRead']);
    Route::post('notifications/read-all',    [NotificationController::class, 'markAllAsRead']);
    Route::get('notifications/unread-count', [NotificationController::class, 'unreadCount']);
});
```

### 10.3 Route Admin

```php
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('dashboard', [Admin\DashboardController::class, 'index']);

    // Akun
    Route::resource('accounts', Admin\AccountController::class);
    Route::patch('accounts/{user}/toggle-status', [Admin\AccountController::class, 'toggleStatus']);
    Route::post('accounts/{user}/reset-password',  [Admin\AccountController::class, 'resetPassword']);
    Route::post('accounts/{user}/restore',          [Admin\AccountController::class, 'restore']);

    // Motor
    Route::resource('motors', Admin\MotorController::class);
    Route::patch('motors/{motor}/status', [Admin\MotorController::class, 'updateStatus']);
    Route::post('motors/{motor}/restore', [Admin\MotorController::class, 'restore']);

    // Menu
    Route::resource('menus', Admin\MenuController::class);
    Route::patch('menus/{menu}/toggle', [Admin\MenuController::class, 'toggle']);
    Route::post('menus/{menu}/restore', [Admin\MenuController::class, 'restore']);

    // Laporan
    Route::get('reports/accounts',       [Admin\ReportController::class, 'accounts']);
    Route::get('reports/motors',         [Admin\ReportController::class, 'motors']);
    Route::get('reports/menus',          [Admin\ReportController::class, 'menus']);
    Route::get('reports/export/{type}',  [Admin\ReportController::class, 'export']);
});
```

### 10.4 Route Manager

```php
Route::prefix('manager')->middleware(['auth', 'role:manager'])->group(function () {

    // Dashboard
    Route::get('dashboard', [Manager\DashboardController::class, 'index']);

    // Stok masuk
    Route::resource('stock-entries', Manager\StockEntryController::class);

    // Stok global
    Route::get('global-stocks', [Manager\StockEntryController::class, 'globalStocks']);

    // Approve stok seller
    Route::get('stock-approvals',                     [Manager\StockApprovalController::class, 'index']);
    Route::post('stock-approvals/{session}/approve',  [Manager\StockApprovalController::class, 'approve']);
    Route::post('stock-approvals/{session}/reject',   [Manager\StockApprovalController::class, 'reject']);

    // Pantau sesi
    Route::get('sessions',              [Manager\SessionMonitorController::class, 'index']);
    Route::get('sessions/{session}',    [Manager\SessionMonitorController::class, 'show']);
    Route::post('sessions/{session}/close', [Manager\SessionCloseController::class, 'close']);

    // Keuangan
    Route::get('finance',               [Manager\FinanceController::class, 'index']);

    // Upah
    Route::get('salaries',              [Manager\SalaryController::class, 'index']);
    Route::patch('salaries/{salary}/approve', [Manager\SalaryController::class, 'approve']);
    Route::patch('salaries/{salary}/mark-paid', [Manager\SalaryController::class, 'markPaid']);

    // Laporan
    Route::get('reports/{type}',        [Manager\ReportController::class, 'show']);
    Route::get('reports/{type}/export', [Manager\ReportController::class, 'export']);
});
```

### 10.5 Route Seller

```php
Route::prefix('seller')->middleware(['auth', 'role:seller'])->group(function () {

    // Dashboard
    Route::get('dashboard', [Seller\DashboardController::class, 'index']);

    // Profil
    Route::get('profile',         [Seller\ProfileController::class, 'index']);
    Route::put('profile',         [Seller\ProfileController::class, 'update']);

    // Check-in
    Route::get('checkin',          [Seller\CheckInController::class, 'index']);
    Route::post('checkin',         [Seller\CheckInController::class, 'store']);

    // Pengajuan stok
    Route::get('stock-request',    [Seller\StockRequestController::class, 'index']);
    Route::post('stock-request',   [Seller\StockRequestController::class, 'store']);

    // Transaksi (hanya bisa saat sesi aktif)
    Route::middleware('session.active')->group(function () {
        Route::get('transactions/create', [Seller\TransactionController::class, 'create']);
        Route::post('transactions',       [Seller\TransactionController::class, 'store']);
        Route::get('transactions',        [Seller\TransactionController::class, 'index']);
        Route::get('stock-monitor',       [Seller\TransactionController::class, 'stockMonitor']);
    });

    // Check-out
    Route::post('checkout', [Seller\CheckOutController::class, 'store']);

    // Riwayat
    Route::get('history',          [Seller\HistoryController::class, 'index']);
    Route::get('history/{session}', [Seller\HistoryController::class, 'show']);
});
```

---

## 11. Rancangan UI/UX per Role

### 11.1 Prinsip Umum

- **Admin & Manager:** Layout desktop full, sidebar navigasi, tabel data lengkap, filter & pencarian
- **Seller:** Layout mobile-first, tombol besar (min 48px), navigasi bawah, minimal text, fokus aksi
- **Semua Role:** Notification bell di header, toast notification untuk aksi real-time

### 11.2 Prinsip Desain Seller (Mobile-First)

Seller mengendarai motor dan melayani pembeli di lapangan. UI harus:
- **Satu tangan:** Tombol dan area sentuh minimal 48px height, posisi di area jangkauan ibu jari
- **Quick-add:** Menu favorit/populer ditampilkan di atas untuk akses cepat
- **Gesture-friendly:** Swipe untuk navigasi antar tab
- **Feedback jelas:** Vibration + sound saat transaksi berhasil disimpan
- **Dark mode:** Tersedia untuk berjualan di malam hari (mengurangi silau)
- **PWA-ready:** Dapat di-install dari home screen, splash screen, ikon app

### 11.3 Halaman Utama per Role

#### Admin
| Halaman              | Komponen Utama                                    |
|----------------------|---------------------------------------------------|
| Dashboard            | Kartu statistik: total akun, motor, menu          |
| Daftar Akun          | Tabel + filter role + tombol tambah + soft delete  |
| Form Akun            | Input data, select role, upload foto              |
| Daftar Motor         | Tabel + badge status (warna) + filter status      |
| Daftar Menu          | Grid/tabel + foto thumbnail + toggle aktif        |
| Laporan              | Filter tanggal + tabel + tombol export            |

#### Manager
| Halaman               | Komponen Utama                                           |
|-----------------------|----------------------------------------------------------|
| Dashboard             | Kartu: motor aktif, seller aktif, total penjualan hari ini, total transaksi, stok global rendah |
| Pengajuan Stok        | Daftar permintaan + detail per item + cek stok global + tombol approve/tolak |
| Pantau Sesi           | Daftar sesi aktif, badge status, link detail             |
| Detail Sesi           | Info seller, motor, waktu, daftar transaksi, sisa stok   |
| Input Stok Masuk      | Form sederhana: pilih menu, qty, tanggal + stok saat ini |
| Stok Global           | Tabel stok per menu + progress bar + alert low stock     |
| Manajemen Upah        | Tabel upah per sesi, kalkulasi, tombol approve, mark paid |
| Laporan               | Tab: penjualan / stok / keuangan / seller; grafik & tabel|

#### Seller (Mobile-First)
| Halaman               | Komponen Utama                                         |
|-----------------------|--------------------------------------------------------|
| Dashboard             | Status sesi hari ini, kartu sisa stok, total transaksi |
| Check-in              | Pilih motor (kartu besar) → form stok (stepper)        |
| Status Pengajuan Stok | Badge status per item, catatan manager, tombol revisi   |
| Form Transaksi        | List menu dengan tombol + / -, total otomatis, pilih metode bayar, tombol simpan besar |
| Sisa Stok             | Progress bar per menu, peringatan merah jika < 20%     |
| Check-out             | Ringkasan sesi, form catatan, tombol selesai besar     |
| Riwayat               | Kartu per sesi: tanggal, total jual, upah              |
| Profil                | Lihat data, ganti password                             |

### 11.4 Notifikasi UI

- Badge merah di ikon notifikasi (jumlah belum dibaca)
- Toast notification untuk aksi real-time (stok diapprove, transaksi tersimpan)
- Banner peringatan kuning jika stok seller < 20% dari awal
- Sound/vibration feedback untuk seller saat transaksi berhasil

---

## 12. Tech Stack & Dependensi

### 12.1 Backend

| Komponen       | Pilihan                    | Keterangan                           |
|----------------|----------------------------|--------------------------------------|
| Framework      | Laravel 11                 | Versi stabil terbaru                 |
| PHP            | PHP 8.2+                   | Minimum requirement Laravel 11       |
| Database       | MySQL 8.0 / MariaDB 10.6   | Relasional, mendukung JSON           |
| Auth           | Laravel Breeze / Fortify   | Autentikasi bawaan Laravel           |
| Role & Permission | Spatie Laravel Permission | Manajemen role & permission fleksibel|
| ORM            | Eloquent (bawaan)          | Relasi, scope, observer              |
| Queue          | Database / Redis           | Untuk async jobs (notifikasi, dll)   |

### 12.2 Frontend

| Komponen       | Pilihan                    | Keterangan                             |
|----------------|----------------------------|----------------------------------------|
| Template Engine| Blade (bawaan Laravel)     | Cukup untuk proyek ini                 |
| CSS Framework  | Tailwind CSS 3             | Utility-first, mobile-friendly         |
| JS Interaktif  | Alpine.js / Livewire       | Reaktif tanpa SPA penuh                |
| Grafik         | Chart.js                   | Grafik laporan manager                 |
| Icon           | Heroicons / Lucide         | Konsisten dengan Tailwind              |
| PWA            | Custom manifest + SW       | Installable web app untuk seller       |

### 12.3 Package Laravel yang Direkomendasikan

| Package                        | Fungsi                                     |
|--------------------------------|--------------------------------------------|
| spatie/laravel-permission      | Role & permission management               |
| barryvdh/laravel-dompdf        | Generate laporan PDF                       |
| maatwebsite/excel              | Import/export Excel (laporan)              |
| spatie/laravel-activitylog     | Log aktivitas pengguna (audit trail)       |
| intervention/image             | Resize & optimasi foto upload              |
| laravel/telescope (dev)        | Debugging dan monitoring (development)     |

### 12.4 Perintah Instalasi

```bash
# Buat proyek baru
composer create-project laravel/laravel kopi-keliling

# Masuk direktori
cd kopi-keliling

# Install packages
composer require spatie/laravel-permission
composer require barryvdh/laravel-dompdf
composer require maatwebsite/excel
composer require spatie/laravel-activitylog
composer require intervention/image

# Install Laravel Breeze (auth scaffolding)
composer require laravel/breeze --dev
php artisan breeze:install blade

# Install Tailwind CSS
npm install
npm run dev

# Publish config spatie permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# Setup queue table (jika menggunakan database driver)
php artisan queue:table
php artisan migrate

# Jalankan migrasi + seeder
php artisan migrate --seed
```

---

## 13. Security & Performance

### 13.1 Security Checklist

| Aspek                    | Implementasi                                              | Prioritas |
|--------------------------|-----------------------------------------------------------|-----------|
| Authentication           | Laravel Breeze / Fortify, bcrypt hashing                  | Tinggi    |
| Authorization            | Middleware role + Laravel Policy per resource              | Tinggi    |
| CSRF Protection          | `@csrf` di semua form Blade (otomatis)                    | Tinggi    |
| Rate Limiting            | Login: 5 percobaan/menit via `throttle` middleware        | Tinggi    |
| Input Validation         | Form Request classes untuk setiap endpoint                | Tinggi    |
| XSS Prevention           | Blade `{{ }}` untuk escape output (hindari `{!! !!}`)     | Tinggi    |
| SQL Injection Prevention | Eloquent ORM + parameterized queries                      | Tinggi    |
| File Upload Validation   | Validasi tipe (jpeg, png, webp), max size 2MB, store di `storage/` | Tinggi    |
| Session Timeout          | Seller: 8 jam, Admin/Manager: 2 jam                       | Sedang    |
| Audit Trail              | spatie/laravel-activitylog untuk aksi kritis              | Sedang    |
| Soft Delete              | Data users, motors, menus tidak benar-benar dihapus       | Sedang    |
| HTTPS                    | Enforce di production via `APP_URL` dan middleware         | Tinggi    |

### 13.2 Performance Optimization

| Aspek                    | Implementasi                                              |
|--------------------------|-----------------------------------------------------------|
| Database Indexing        | Index pada kolom yang sering di-filter (lihat SQL schema) |
| Query Optimization       | Eager loading relasi (N+1 prevention)                     |
| Caching                  | Cache dashboard statistics (5 menit), daftar motor available |
| Image Optimization       | Intervention Image: resize to max 800px, compress quality 80% |
| Lazy Loading Images      | `loading="lazy"` untuk foto produk di halaman seller      |
| Queue Jobs               | Notifikasi dikirim via queue, bukan synchronous           |
| Pagination               | Semua tabel data menggunakan pagination (15 items/page)   |

### 13.3 Database Locking Strategy

```php
// Contoh: Pessimistic locking saat kurangi stok
DB::transaction(function () {
    $menuStock = MenuStock::where('menu_id', $menuId)->lockForUpdate()->first();
    
    if ($menuStock->current_stock < $quantity) {
        throw new InsufficientStockException();
    }
    
    $menuStock->decrement('current_stock', $quantity);
});
```

---

## 14. Milestone & Timeline

### Fase 1 — Fondasi (Minggu 1–2)
- [ ] Setup proyek Laravel, konfigurasi database
- [ ] Install dan konfigurasi semua package
- [ ] Buat semua migrasi database (termasuk `menu_stocks`)
- [ ] Setup autentikasi (login/logout/ganti password)
- [ ] Setup role & middleware (Admin, Manager, Seller)
- [ ] Setup Event/Listener structure
- [ ] Setup Queue driver
- [ ] Seeder data awal (admin, motor contoh, menu contoh, menu_stocks)

### Fase 2 — Modul Admin (Minggu 3–4)
- [ ] CRUD Akun (dengan upload foto, soft delete, restore)
- [ ] CRUD Motor (dengan manajemen status, soft delete)
- [ ] CRUD Menu (dengan upload foto produk, soft delete, auto-create menu_stocks)
- [ ] Dashboard admin (statistik)
- [ ] Laporan admin dasar + export PDF/Excel

### Fase 3 — Modul Manager: Operasional (Minggu 5–6)
- [ ] Dashboard manager (statistik hari ini, stok global rendah)
- [ ] Input stok masuk + update stok global
- [ ] Halaman stok global (daftar semua menu + stok saat ini)
- [ ] Terima & approve/tolak pengajuan stok seller (cek vs stok global)
- [ ] Pantau sesi aktif (daftar + detail)
- [ ] Tutup sesi harian + return sisa stok ke global

### Fase 4 — Modul Seller (Minggu 7–8)
- [ ] Dashboard seller (mobile-first, PWA manifest)
- [ ] Alur check-in: pilih motor + ajukan stok
- [ ] Halaman status pengajuan stok
- [ ] Form transaksi (pilih menu, hitung total, pilih metode bayar, simpan)
- [ ] Monitor sisa stok real-time (progress bar)
- [ ] Alur check-out + laporan akhir
- [ ] Profil seller + ganti password

### Fase 5 — Keuangan & Upah (Minggu 9)
- [ ] Kalkulasi upah otomatis setelah sesi selesai (via event)
- [ ] Halaman manajemen upah manager (approve, mark paid)
- [ ] Rekap keuangan harian
- [ ] Riwayat upah seller

### Fase 6 — Laporan & Notifikasi (Minggu 10)
- [ ] Sistem notifikasi (database notification + queue job)
- [ ] Notification bell component + toast + low stock banner
- [ ] Laporan penjualan (harian/mingguan/bulanan)
- [ ] Laporan performa seller
- [ ] Export PDF & Excel

### Fase 7 — Polish & Testing (Minggu 11–12)
- [ ] Unit test untuk service kritis (SalaryService, StockService, TransactionService)
- [ ] Feature test untuk alur utama (check-in → transaksi → check-out)
- [ ] Perbaikan bug dan penyempurnaan UI
- [ ] Dark mode untuk seller
- [ ] Optimasi performa (caching, eager loading, lazy image)
- [ ] Artisan command: CloseExpiredSessions (>24 jam via scheduler)
- [ ] Dokumentasi penggunaan
- [ ] Deploy ke server

---

## 15. Risiko & Mitigasi

| Risiko                                       | Dampak | Kemungkinan | Mitigasi                                                    |
|----------------------------------------------|--------|-------------|-------------------------------------------------------------|
| Koneksi internet seller buruk di lapangan    | Tinggi | Tinggi      | UI tetap responsif; PWA + service worker; offline-capable di fase 2 |
| Stok tidak sinkron (race condition)          | Tinggi | Sedang      | Database transaction + pessimistic locking pada operasi stok |
| Seller salah input transaksi                 | Sedang | Tinggi      | Tambahkan fitur batal transaksi dengan approval manager      |
| Foto produk memperlambat halaman seller      | Sedang | Sedang      | Kompresi otomatis via Intervention Image + lazy loading      |
| Upah dihitung salah                          | Tinggi | Rendah      | Unit test khusus SalaryService; manager bisa override        |
| Data sesi tidak tertutup (seller tidak CO)   | Sedang | Sedang      | Artisan command otomatis tutup sesi > 24 jam via Scheduler   |
| Akses tidak sah antar role                   | Tinggi | Rendah      | Middleware role ketat + Laravel Policy + rate limiting        |
| Brute force login                            | Tinggi | Sedang      | Rate limiting 5 percobaan/menit + lockout sementara          |
| Data terhapus tidak sengaja                  | Sedang | Rendah      | Soft delete di semua master data + fitur restore             |
| Stok global negatif karena bug               | Tinggi | Rendah      | Validasi stok >= 0 di service layer + database constraint    |
| Session hijacking                            | Tinggi | Rendah      | HTTPS, secure cookie, session timeout per role               |

---

## Changelog

### v2.0 (Juni 2026)
- Menambahkan tabel `menu_stocks` untuk tracking stok global
- Menambahkan `payment_method` (cash/qris/transfer) di tabel `transactions`
- Menambahkan `UNIQUE(session_id)` di `salary_records`
- Menambahkan `updated_at` di `salary_records`
- Menambahkan Soft Delete (`deleted_at`) di tabel `users`, `motors`, `menus`
- Menambahkan database index pada kolom yang sering di-query
- Menambahkan bagian Event/Listener architecture
- Menambahkan Queue/Job untuk proses asinkron
- Menambahkan route notifikasi (shared), profil seller, dan stock-request GET
- Menambahkan route restore untuk soft-deleted records
- Menambahkan prinsip desain seller: satu tangan, quick-add, gesture, dark mode
- Menambahkan bagian Security & Performance (bab 13) — rate limiting, session timeout, file upload validation, caching strategy, locking strategy
- Menyesuaikan timeline dari 10 minggu → 12 minggu (menambah buffer)
- Menambahkan risiko baru: brute force, data terhapus, stok negatif, session hijacking

---

*Dokumen ini merupakan living document — akan diperbarui sesuai perkembangan proyek.*

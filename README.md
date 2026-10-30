# Personal Page dan Aplikasi Bersama (Pra-UTS)

Dokumentasi resmi proyek perkuliahan **Personal Page dan Aplikasi Bersama (Pra-UTS Komputasi Awan)** yang dibangun menggunakan **PHP Native 8.x**, **MySQL / MariaDB (PDO)**, **Semantic HTML5**, **Modern Modular CSS (Unified Dark & Light System)**, dan **Interactive JavaScript (Typographic Silhouette, Marquee, & Dynamic Filters)**.

---

## 1. Informasi Proyek & Daftar Anggota Kelompok

- **Mata Kuliah**: Komputasi Awan (Cloud Computing)
- **Judul Tugas**: Tugas 1 — Personal Page dan Aplikasi Bersama (Pra-UTS)
- **Nama Aplikasi Bersama**: Guestbook Kelompok Terdistribusi (`kelompok_db`)
- **Program Studi / Kelas**: S1 Informatika Telkom University — **IF-48-05**

### Daftar Anggota Kelompok (`m0` – `m4`)

| Route ID | NIM | Nama Anggota | Peran |
| :--- | :--- | :--- | :--- |
| **`m0`** | `103012400134` | **Zulfa Almajid Basyaasyah** | Ketua Kelompok |
| **`m1`** | `103012400106` | **Glen David Hadiono** | Anggota |
| **`m2`** | `103012400` | *Anggota Kelompok* | Anggota |
| **`m3`** | `103012400` | *Anggota Kelompok* | Anggota |
| **`m4`** | `103012400045` | **Yuriko Astiani** | Anggota |

> **Catatan**: Identitas server/node lokal dikonfigurasi melalui file `identity.php` di root direktori mahasiswa masing-masing tanpa mengubah kode inti aplikasi kelompok di folder `app/`.

---

## 2. Struktur Direktori Proyek (`htdocs/personal/`)

Sesuai spesifikasi pada dokumen `Petunjuk_Tugas_1.pdf`, struktur direktori seragam untuk seluruh anggota dan siap di-deploy langsung ke VM Google Compute Engine (GCP):

```text
personal/
├── index.php                  (Halaman utama Personal Page mahasiswa + Embed Guestbook)
├── identity.php               (Konfigurasi identitas mahasiswa lokal: MEMBER_ROUTE, MEMBER_NAMA, MEMBER_NIM)
├── styles/                    (Stylesheet terpadu personal page & banner served_by)
│   └── main.css
├── scripts/                   (Skrip interaktif personal page)
│   ├── app.js                 (Interaksi tema, quick access, audio controller, spotlight)
│   ├── silhouette.js          (Typographic canvas silhouette word-mesh)
│   ├── config.js              (Konfigurasi data profil & tautan kamar)
│   └── catalogData.js         (Katalog proyek & data portfolio)
├── images/                    (Aset gambar potret, thumbnail, dan preview proyek)
├── fonts/                     (Font lokal & typography assets)
├── cv.pdf                     (Dokumen Curriculum Vitae profesional)
├── favicon.png                (Favicon personal page)
├── site.webmanifest           (Web app manifest)
├── engineer/                  (Showcase sub-page Engineer)
├── creative/                  (Showcase sub-page Creative)
├── hire/                      (Showcase sub-page Hire Me & Full CV)
├── work/                      (Showcase sub-page All Projects)
├── personal_page/             (Arsip cadangan sumber asli personal page)
├── assets/                    (Folder aset statis bersama & fallback)
├── config/                    (Folder konfigurasi database lokal)
│   ├── .htaccess              (Proteksi akses langsung web server: Require all denied)
│   ├── db.php                 (Kredensial database lokal: host, name, user, pass)
│   └── db.example.php         (Contoh konfigurasi untuk pengumpulan arsip ZIP)
└── app/                       (Aplikasi Bersama Kelompok - Guestbook)
    ├── index.php              (Antarmuka Guestbook: Form + Daftar Pesan + Paginasi)
    ├── lib/db.php             (Koneksi database PDO modular)
    ├── partials/served_by.php (Banner identitas server/node pelayan)
    └── sql/schema.sql         (Skema database DDL/DML, hak akses user, & data seed)
```

---

## 3. Fitur Utama & Kepatuhan Spesifikasi Tugas

1. **Personal Page Individu ([index.php](file:///c:/Users/Glen/OneDrive/Dokumen/KULIAH/SEMESTER%205/KOMPUTASI%20AWAN/guestbook-1/index.php))**:
   - **Banner Wajib**: Banner `"Anda dilayani oleh laman <nama> (<NIM>)"` dimuat secara dinamis dari `app/partials/served_by.php` di bagian teratas halaman.
   - **Integrasi Identitas**: Terhubung langsung dengan konstanta pada `identity.php`.
   - **Profil & Portofolio Lengkap**: Menampilkan ringkasan profil, rekam jejak akademik (Telkom University), pengalaman magang industri (PT Mekar Armada Jaya, ReuseID), asisten praktikum (Go & C++), dan tutor sebaya (helPhin).
   - **Minimal 3 Portofolio Bergambar**: Memuat *Lunch Attendance & Billing System*, *Valas Company Profile CMS*, *ReuseID Secondhand Donation Platform*, dan *KKN 116 Tamangapa*.
   - **Interaksi JavaScript**:
     - Toggle mode gelap / terang (*Dark/Light Mode*).
     - Kanvas interaktif tipografi siluet wajah (*Typographic Canvas Word-Mesh*).
     - Tab *Spotlight* proyek interaktif.
     - Animasi teks berjalan (*Interactive Marquee Chips*).
   - **Privasi Terjaga**: Sesuai instruksi tugas, **nomor telepon pribadi tidak dicantumkan**.
   - **Sematkan Aplikasi Bersama**: Guestbook disematkan langsung di halaman utama via iframe responsif (`app/index.php?embed=1`) serta tersedia tombol navigasi menuju halaman penuh (`app/index.php`).

2. **Aplikasi Bersama ([app/index.php](file:///c:/Users/Glen/OneDrive/Dokumen/KULIAH/SEMESTER%205/KOMPUTASI%20AWAN/guestbook-1/app/index.php))**:
   - **Pencatatan Node Server**: Setiap data input secara otomatis mencatat `route_id` yang melayani (`m0`..`m4`).
   - **Fitur Lengkap**: Form penambahan pesan, daftar entri terbaru, filter entri per-node, dan paginasi (5 entri per halaman).
   - **Keamanan Berlapis**:
     - *PDO Prepared Statements* untuk semua query (anti SQL Injection).
     - *Anti-XSS Output Escaping* menggunakan `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`.
     - Validasi ganda (*dual-layer validation*) di sisi klien (JavaScript) dan sisi server (PHP).
   - **Path Relatif Penuh**: Bebas dari ketergantungan absolute URL sehingga tidak rusak saat migrasi ke load balancer GCP Compute Engine.

---

## 4. Panduan Instalasi & Penggunaan Lokal

### Langkah 1: Penempatan Proyek di Web Root
Pastikan folder proyek berada pada direktori web server lokal:
- **XAMPP**: `C:\xampp\htdocs\personal\`
- **WAMP**: `C:\wamp64\www\personal\`

### Langkah 2: Nyalakan Modul Apache & MySQL
Buka **XAMPP Control Panel** dan klik **Start** pada modul **Apache** serta **MySQL**.

### Langkah 3: Import Skema Database
1. Buka browser dan kunjungi [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
2. Buat database atau langsung gunakan menu **Import**.
3. Pilih file `app/sql/schema.sql` lalu klik **Go** / **Import**.
4. Skrip otomatis membuat:
   - Database `kelompok_db`
   - User database `app_local` dengan password `password_lokal`
   - Tabel `anggota` dan `guestbook` beserta data awal (*seed*).

### Langkah 4: Sesuaikan File Konfigurasi
1. Periksa `config/db.php`:
   ```php
   return [
       'host'    => '127.0.0.1',
       'name'    => 'kelompok_db',
       'user'    => 'app_local',
       'pass'    => 'password_lokal',
       'charset' => 'utf8mb4',
       'port'    => 3306,
   ];
   ```
2. Periksa `identity.php` dan sesuaikan identitas lokal Anda:
   ```php
   define('MEMBER_ROUTE', 'm1');
   define('MEMBER_NAMA', 'Glen David Hadiono');
   define('MEMBER_NIM', '103012400106');
   ```

---

## 5. URL Akses & Pengujian

- **Halaman Utama (Personal Page & Embed Guestbook)**:
  `http://localhost/personal/` atau `http://localhost/personal/index.php`
- **Halaman Penuh Aplikasi Bersama (Guestbook)**:
  `http://localhost/personal/app/` atau `http://localhost/personal/app/index.php`
- **Pengujian Keamanan Proteksi Folder Konfigurasi**:
  Akses `http://localhost/personal/config/db.php` — Server wajib menampilkan **403 Forbidden** berkat `.htaccess`.
- **Pengujian Keamanan Input**:
  Kirim pesan dengan teks `<script>alert(1)</script>` dan `' OR '1'='1`. Seluruh input wajib tersimpan dan tampil sebagai teks biasa tanpa tereksekusi.

---

## 6. Checklist Pengumpulan Tugas 1

- [x] Personal page tampil di `http://localhost/personal/` dengan banner *"Anda dilayani oleh"*.
- [x] Konten minimum profil, pendidikan, keahlian, dan minimal 3 item portofolio terpenuhi.
- [x] Menu dan sematan (*embed*) aplikasi bersama di halaman utama.
- [x] Tidak ada error maupun warning PHP pada halaman.
- [x] Semua link dan path menggunakan jalur relatif.
- [x] Pengumpulan ZIP: folder `personal/` tanpa `config/db.php` (diganti dengan `db.example.php`).
- [x] Video demo maksimal 5 menit (Personal page, interaksi JS, pengisian form guestbook, dan pengecekan data di phpMyAdmin).

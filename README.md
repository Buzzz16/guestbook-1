# Personal Page dan Aplikasi Bersama (Pra-UTS)

Dokumentasi resmi proyek perkuliahan **Personal Page dan Aplikasi Bersama (Pra-UTS)** yang dibangun menggunakan **PHP Native 8.x**, **MySQL / MariaDB (PDO)**, **Semantic HTML5**, **Custom CSS (Dark Tech-wear / Harbor Grey Theme)**, dan **Vanilla JavaScript**.

---

## 1. Informasi Proyek & Daftar Anggota Kelompok

- **Judul Proyek**: Personal Page dan Aplikasi Bersama (Pra-UTS)
- **Nama Aplikasi Bersama**: Guestbook Kelompok Terdistribusi (`kelompok_db`)
- **Program Studi / Kelas**: S1 Informatika Telkom University — **IF-48-05**
- **Node Pemilik Laman Lokal**: `m0` — **Zulfa Almajid Basyaasyah (Babas)** (`103012400134`)

### Daftar Anggota Kelompok (`m0` – `m4`)

| Route ID | NIM | Nama Anggota | Peran |
| :--- | :--- | :--- | :--- |
| **`m0`** | `103012400134` | **Zulfa Almajid Basyaasyah** | **Ketua Kelompok (Pemilik Personal Page ini)** |
| **`m1`** | `103012400106` | **Glen David Hadiono** | Anggota |
| **`m2`** | `103012400299` | **Meyneza Ari Dwi Astuti** | Anggota |
| **`m3`** | `104012430028` | **Dini Nadia Mawaddah** | Anggota |
| **`m4`** | `103012400045` | **Yuriko Astiani** | Anggota |
| **`m5`** | `103012400117` | **Ravananda Nadzief** | Anggota |
---

## 2. Struktur Direktori (`htdocs/personal/`)

```text
personal/
├── index.php                  (Halaman utama Personal Page)
├── assets/                    (Folder statis individu)
│   ├── css/style.css          (Stylesheet Dark Techwear & Harbor Grey)
│   └── js/main.js             (Interaksi Vanilla JS: Filter, Smooth Scroll, Theme, Validasi)
├── identity.php               (Konfigurasi identitas mahasiswa lokal: m0 - Zulfa)
├── config/                    (Folder konfigurasi lokal)
│   ├── .htaccess              (Proteksi akses langsung: Require all denied)
│   └── db.php                 (Kredensial database: host, name, user, pass)
├── README.md                  (Dokumentasi proyek)
└── app/                       (Folder Aplikasi Bersama - Guestbook)
    ├── index.php              (Halaman antarmuka Guestbook + Paginasi + Validasi)
    ├── lib/db.php             (Koneksi database PDO)
    ├── partials/served_by.php (Banner identitas pelayan laman)
    └── sql/schema.sql         (Skema database lengkap + User + Seed Data)
```

---

## 3. Syarat Pra-Instalasi

Sebelum menjalankan proyek ini di komputer lokal Anda, pastikan perangkat lunak berikut sudah terpasang:

1. **XAMPP / WAMP / Laragon** yang mencakup:
   - **Apache Web Server** (dengan dukungan modul `.htaccess` / `mod_authz_core`).
   - **PHP 8.x** (Native, dengan ekstensi `pdo_mysql` dan `mbstring` aktif).
   - **MySQL 8.x atau MariaDB 10.4+** beserta **phpMyAdmin**.
2. **Git** (opsional, untuk melakukan *cloning* repositori ke dalam direktori `htdocs`).
3. **Browser Modern** (Google Chrome, Mozilla Firefox, Microsoft Edge, atau Brave).

> **Catatan**: **Node.js tidak diperlukan** karena seluruh proyek ini berjalan murni menggunakan arsitektur **PHP Native 8.x** tanpa ketergantungan *build tool* eksternal.

---

## 4. Langkah-Langkah Instalasi Detail

### Langkah 1: Ekstrak atau Clone Proyek ke Folder `htdocs`

1. Buka direktori instalasi XAMPP Anda (umumnya di `C:\xampp\htdocs\` pada Windows atau `/opt/lampp/htdocs/` pada Linux).
2. Ekstrak isi file `Tugas1_PersonalPage_Guestbook.zip` atau *clone* repositori sehingga terbentuk folder `personal` tepat di dalam `htdocs`:
   ```bash
   cd C:/xampp/htdocs
   git clone <url-repositori-anda> personal
   ```
3. Pastikan path akhir dari file utama adalah `C:\xampp\htdocs\personal\index.php`.

### Langkah 2: Nyalakan Apache dan MySQL di XAMPP

1. Buka **XAMPP Control Panel**.
2. Klik tombol **Start** pada modul **Apache** dan **MySQL** hingga keduanya berwarna hijau.

### Langkah 3: Import `schema.sql` dan Buat User Database via phpMyAdmin

Skrip `app/sql/schema.sql` sudah dilengkapi perintah otomatis untuk membuat database `kelompok_db`, membuat user `app_local`, memberikan hak akses (`SELECT, INSERT, UPDATE, DELETE`), membuat tabel `anggota` serta `guestbook`, dan mengisi data awal (*seed*).

**Cara 1 — Melalui Antarmuka phpMyAdmin (Direkomendasikan):**
1. Buka browser dan akses [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
2. Klik tab **Import** pada menu bagian atas.
3. Klik tombol **Choose File** / **Browse**, lalu pilih file:
   `htdocs/personal/app/sql/schema.sql`
4. Klik tombol **Import** / **Go** di bagian bawah halaman.
5. Pastikan muncul pesan sukses dan database `kelompok_db` beserta tabel `anggota` dan `guestbook` telah terbentuk di panel sebelah kiri.

**Cara 2 — Melalui Terminal / Command Prompt MySQL:**
```bash
mysql -u root -p < C:/xampp/htdocs/personal/app/sql/schema.sql
```

**Jika Anda ingin membuat User Database secara manual di phpMyAdmin:**
1. Masuk ke tab **SQL** di phpMyAdmin, lalu jalankan perintah berikut:
   ```sql
   CREATE USER IF NOT EXISTS 'app_local'@'127.0.0.1' IDENTIFIED BY 'password_lokal';
   CREATE USER IF NOT EXISTS 'app_local'@'localhost' IDENTIFIED BY 'password_lokal';
   GRANT SELECT, INSERT, UPDATE, DELETE ON `kelompok_db`.* TO 'app_local'@'127.0.0.1';
   GRANT SELECT, INSERT, UPDATE, DELETE ON `kelompok_db`.* TO 'app_local'@'localhost';
   FLUSH PRIVILEGES;
   ```

### Langkah 4: Penyesuaian File Konfigurasi `config/db.php` & `identity.php`

1. Periksa file `personal/config/db.php`. Secara bawaan, kredensial sudah disesuaikan dengan `schema.sql`:
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
   *(Apabila port MySQL XAMPP Anda diubah, sesuaikan nilai `'port'` pada file tersebut).*
2. Periksa file `personal/identity.php` yang menyimpan konstanta identitas lokal:
   - `MEMBER_ROUTE`: `'m0'`
   - `MEMBER_NAMA`: `'Zulfa Almajid Basyaasyah'`
   - `MEMBER_NIM`: `'103012400134'`

---

## 5. Cara Mengakses Web di Browser

Setelah Apache dan MySQL berjalan serta database selesai diimpor, buka browser Anda dan kunjungi alamat berikut:

1. **Halaman Utama Personal Page (Beserta Embed Guestbook)**:
   - URL: **[http://localhost/personal/](http://localhost/personal/)** atau **[http://localhost/personal/index.php](http://localhost/personal/index.php)**
2. **Halaman Mandiri Aplikasi Bersama (Guestbook)**:
   - URL: **[http://localhost/personal/app/](http://localhost/personal/app/)** atau **[http://localhost/personal/app/index.php](http://localhost/personal/app/index.php)**
3. **Pengujian Proteksi Folder Konfigurasi (`.htaccess`)**:
   - Coba akses `http://localhost/personal/config/db.php` — Apache akan menolak akses dengan status **403 Forbidden** berkat aturan `Require all denied` di dalam `config/.htaccess`.

---

## 6. Fitur Keamanan & Standar Kode

- **PDO Prepared Statements**: Seluruh operasi pembacaan dan penyimpanan pesan pada `app/index.php` menggunakan parameter terikat (`prepare()` & `execute()`) untuk mencegah serangan *SQL Injection*.
- **Anti-XSS Output Escaping**: Setiap data dinamis yang dirender ke HTML dibungkus dengan `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`.
- **Dual-Layer Validation**: Validasi input diterapkan di sisi klien (`assets/js/main.js`) dan divalidasi ulang secara ketat di sisi server (`app/index.php`).
- **Modular & Relatif**: Seluruh pemanggilan file menggunakan `__DIR__` dan path relatif sehingga aplikasi tetap berjalan mulus tanpa bergantung pada konfigurasi *virtual host* khusus.

# Personal Page dan Aplikasi Bersama (Pra-UTS)

- **Nama**: Meyneza Ari Dwi Astuti (`Nejaa`)
- **NIM**: `103012400299`
- **Kelas**: S1 Informatika Telkom University — **IF-48-05**
- **Route ID**: `m2`
- **Aplikasi Bersama**: Guestbook Kelompok Terdistribusi (`kelompok_db`)

## Struktur Direktori (`htdocs/personal/`)

```text
personal/
├── index.php                  <- Personal Page individu (Meyneza Ari - m2)
├── assets/
│   ├── css/style.css          <- Custom CSS responsif + Night Mode
│   ├── js/main.js             <- Interaksi JS (Theme toggle, Filter portofolio, Modal proyek, Toolbar, Validasi form)
│   └── img/                   <- Foto profil & aset portofolio proyek
├── identity.php               <- Identitas lokal mahasiswa (m2 - Meyneza Ari Dwi Astuti)
├── config/
│   ├── .htaccess              <- Proteksi akses langsung: Require all denied
│   └── db.php                 <- Kredensial database lokal
└── app/                       <- Folder Aplikasi Bersama (Guestbook Kelompok)
    ├── index.php              <- Halaman antarmuka Guestbook + Paginasi + Validasi
    ├── lib/db.php             <- Koneksi database PDO
    ├── partials/served_by.php <- Banner identitas pelayan laman
    └── sql/schema.sql         <- Skema database kelompok_db
```

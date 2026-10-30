-- ============================================================================
-- SKEMA DATABASE & KONFIGURASI USER LOKAL
-- Proyek   : Personal Page dan Aplikasi Bersama (Pra-UTS)
-- Database : kelompok_db
-- DBMS     : MySQL 8.x / MariaDB 10.4+ (XAMPP)
-- ============================================================================

-- 1. Buat Database
CREATE DATABASE IF NOT EXISTS `kelompok_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `kelompok_db`;

-- 2. Buat User Lokal & Berikan Hak Akses (DML: SELECT, INSERT, UPDATE, DELETE)
CREATE USER IF NOT EXISTS 'app_local'@'127.0.0.1' IDENTIFIED BY 'password_lokal';
CREATE USER IF NOT EXISTS 'app_local'@'localhost' IDENTIFIED BY 'password_lokal';

GRANT SELECT, INSERT, UPDATE, DELETE ON `kelompok_db`.* TO 'app_local'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON `kelompok_db`.* TO 'app_local'@'localhost';
FLUSH PRIVILEGES;

-- 3. Buat Tabel `anggota`
CREATE TABLE IF NOT EXISTS `anggota` (
    `route_id` VARCHAR(10) NOT NULL,
    `nim` VARCHAR(20) NOT NULL,
    `nama` VARCHAR(120) NOT NULL,
    PRIMARY KEY (`route_id`),
    UNIQUE KEY `uq_anggota_nim` (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Buat Tabel `guestbook`
CREATE TABLE IF NOT EXISTS `guestbook` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `route_id` VARCHAR(10) NOT NULL,
    `nama` VARCHAR(100) NOT NULL,
    `pesan` TEXT NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_guestbook_route` (`route_id`),
    KEY `idx_guestbook_created_at` (`created_at`),
    CONSTRAINT `fk_guestbook_anggota`
        FOREIGN KEY (`route_id`) REFERENCES `anggota` (`route_id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Seed Data Dummy Anggota Kelompok (m0 - m5)
INSERT INTO `anggota` (`route_id`, `nim`, `nama`) VALUES
    ('m0', '103012400134', 'Zulfa Almajid Basyaasyah'),
    ('m1', '1030124001', 'a'),
    ('m2', '1030124002', 'a'),
    ('m3', '1030124003', 'a'),
    ('m4', '1030124004', 'a'),
    ('m5', '1030124005', 'a')
ON DUPLICATE KEY UPDATE
    `nim` = VALUES(`nim`),
    `nama` = VALUES(`nama`);

-- 6. Seed Data Dummy Pesan Guestbook Awal (Untuk Pengujian Paginasi > 5 Entri)
INSERT INTO `guestbook` (`route_id`, `nama`, `pesan`, `created_at`) VALUES
    ('m0', 'Asep', 'Tampilan dark techwear-nya keren banget Bas! Proyek Inventory Management Go dan Rental Uhuuy sangat terstruktur.', DATE_SUB(NOW(), INTERVAL 6 HOUR)),
    ('m1', 'Naufal', 'Tes integrasi database bersama dari node m1. Koneksi PDO berjalan lancar tanpa kendala!', DATE_SUB(NOW(), INTERVAL 5 HOUR)),
    ('m2', 'Yury', 'Halo tim! Sudah cek fitur guestbook dan validasi inputnya, siap untuk demo Pra-UTS minggu ini.', DATE_SUB(NOW(), INTERVAL 4 HOUR)),
    ('m3', 'Nadia', 'Semangat riset Big Data dan Machine Learning-nya Babas! Semoga sukses seleksi MBC Laboratory.', DATE_SUB(NOW(), INTERVAL 3 HOUR)),
    ('m4', 'Adam', 'Paginasi dan prepared statement PDO sudah aman. Good job ketua m0!', DATE_SUB(NOW(), INTERVAL 2 HOUR)),
    ('m0', 'Dosen Pengampu (Simulasi)', 'Struktur direktori rapi, pemisahan kredensial di config/db.php sudah tepat sesuai standar keamanan.', DATE_SUB(NOW(), INTERVAL 1 HOUR));

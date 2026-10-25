<?php
declare(strict_types=1);

/**
 * Konfigurasi Kredensial Database Lokal (MySQL / MariaDB via XAMPP)
 * File ini dilindungi oleh .htaccess dari akses HTTP langsung.
 */

return [
    'host'    => '127.0.0.1',
    'name'    => 'kelompok_db',
    'user'    => 'app_local',
    'pass'    => 'password_lokal',
    'charset' => 'utf8mb4',
    'port'    => 3306,
];

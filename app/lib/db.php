<?php
declare(strict_types=1);

/**
 * Koneksi Database PDO Modular
 * Membaca konfigurasi dari ../../config/db.php secara relatif.
 */

function get_db_connection(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $configPath = __DIR__ . '/../../config/db.php';
    if (!file_exists($configPath)) {
        throw new RuntimeException('File konfigurasi database (config/db.php) tidak ditemukan.');
    }

    $config = require $configPath;

    $host    = $config['host'] ?? '127.0.0.1';
    $dbname  = $config['name'] ?? 'kelompok_db';
    $user    = $config['user'] ?? 'app_local';
    $pass    = $config['pass'] ?? 'password_lokal';
    $charset = $config['charset'] ?? 'utf8mb4';
    $port    = $config['port'] ?? 3306;

    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);
    return $pdo;
}

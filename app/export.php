<?php
declare(strict_types=1);

/**
 * MODUL EKSPOR DATA GUESTBOOK (CSV & JSON)
 * Proyek : Personal Page dan Aplikasi Bersama (Pra-UTS)
 * Berkas : app/export.php
 *
 * Fitur:
 * 1. Unduh format CSV siap pakai untuk Microsoft Excel / Spreadsheet (UTF-8 BOM).
 * 2. Unduh format JSON terstruktur untuk developer / konsumsi data programatik.
 * 3. Filter opsional berdasarkan node anggota (?route=m0).
 * 4. Antarmuka interaktif Web Download Center jika diakses langsung di browser.
 */

require_once __DIR__ . '/../identity.php';
require_once __DIR__ . '/lib/db.php';

$format = isset($_GET['format']) ? strtolower(trim((string) $_GET['format'])) : '';
$route  = isset($_GET['route']) ? trim((string) $_GET['route']) : '';

// 1. Eksekusi Ekspor Data jika parameter format disertakan (CSV / JSON)
if ($format === 'csv' || $format === 'json') {
    try {
        $pdo = get_db_connection();

        $sql = '
            SELECT 
                g.id,
                g.route_id,
                g.nama AS pengirim,
                g.pesan,
                g.created_at AS waktu_kirim,
                COALESCE(a.nama, "Unknown") AS nama_host,
                COALESCE(a.nim, "-") AS nim_host
            FROM guestbook g
            LEFT JOIN anggota a ON g.route_id = a.route_id
        ';
        $params = [];

        if ($route !== '') {
            $sql .= ' WHERE g.route_id = :route';
            $params[':route'] = $route;
        }

        $sql .= ' ORDER BY g.id ASC';

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $timestampStr = date('Ymd_His');
        $routeSuffix  = ($route !== '') ? "_{$route}" : '_all';

        if ($format === 'csv') {
            $filename = "guestbook_export{$routeSuffix}_{$timestampStr}.csv";

            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
            header('Expires: 0');

            $output = fopen('php://output', 'w');
            if ($output !== false) {
                // Tuliskan UTF-8 Byte Order Mark (BOM) agar Microsoft Excel membuka aksen & simbol dengan benar
                fwrite($output, "\xEF\xBB\xBF");

                // Header Kolom CSV
                fputcsv($output, [
                    'ID Pesan',
                    'Simpul Route',
                    'Nama Pengirim',
                    'Isi Pesan',
                    'Waktu Kirim (Server)',
                    'Host Penerima',
                    'NIM Host'
                ]);

                foreach ($rows as $r) {
                    fputcsv($output, [
                        $r['id'],
                        $r['route_id'],
                        $r['pengirim'],
                        $r['pesan'],
                        $r['waktu_kirim'],
                        $r['nama_host'],
                        $r['nim_host']
                    ]);
                }
                fclose($output);
            }
            exit;
        }

        if ($format === 'json') {
            $filename = "guestbook_export{$routeSuffix}_{$timestampStr}.json";

            header('Content-Type: application/json; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
            header('Expires: 0');

            $payload = [
                'metadata' => [
                    'app'         => 'Distributed Guestbook Kelompok (Pra-UTS)',
                    'exported_at' => date('c'),
                    'node_origin' => defined('MEMBER_ROUTE') ? MEMBER_ROUTE : 'm0',
                    'node_host'   => defined('MEMBER_NAMA') ? MEMBER_NAMA : 'Unknown',
                    'filter_node' => ($route !== '') ? $route : 'all',
                    'total_rows'  => count($rows),
                ],
                'entries'  => $rows,
            ];

            echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }

    } catch (Throwable $e) {
        http_response_code(500);
        header('Content-Type: text/plain; charset=UTF-8');
        echo "Gagal mengekspor data: " . $e->getMessage();
        exit;
    }
}

// 2. Tampilan Web Interaktif (Export Center) jika tidak ada format yang diunduh langsung
$dbError = null;
$totalEntries = 0;
$sampleRows = [];
$availableRoutes = [];

try {
    $pdo = get_db_connection();

    $countStmt = $pdo->query('SELECT COUNT(*) FROM guestbook');
    $totalEntries = (int) ($countStmt ? $countStmt->fetchColumn() : 0);

    $routesStmt = $pdo->query('SELECT DISTINCT route_id FROM guestbook ORDER BY route_id ASC');
    $availableRoutes = $routesStmt ? $routesStmt->fetchAll(PDO::FETCH_COLUMN) : [];

    // Ambil 5 baris terakhir sebagai sampel preview
    $sampleStmt = $pdo->query('
        SELECT g.id, g.route_id, g.nama, g.pesan, g.created_at 
        FROM guestbook g 
        ORDER BY g.id DESC 
        LIMIT 5
    ');
    $sampleRows = $sampleStmt ? $sampleStmt->fetchAll(PDO::FETCH_ASSOC) : [];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Ekspor Data // <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .export-actions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .export-format-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.5rem;
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }
        .export-format-card:hover {
            border-color: var(--accent-lime);
            transform: translateY(-2px);
        }
        .preview-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            font-size: 0.84rem;
        }
        .preview-table th, .preview-table td {
            padding: 0.65rem 0.8rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        .preview-table th {
            font-family: var(--font-mono);
            color: var(--accent-lime);
            background-color: var(--bg-primary);
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        .preview-table tr:hover td {
            background-color: var(--bg-surface-hover, rgba(255,255,255,0.02));
        }
        @media (max-width: 768px) {
            .export-actions-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="standalone-guestbook-body">

    <?php require_once __DIR__ . '/partials/served_by.php'; ?>

    <header class="site-header">
        <div class="container header-inner">
            <a href="index.php" class="brand-logo" aria-label="Kembali ke Guestbook">
                <span class="brand-bracket">[</span><?= htmlspecialchars(mb_strtoupper(defined('MEMBER_NICKNAME') ? MEMBER_NICKNAME : 'MEMBER'), ENT_QUOTES, 'UTF-8') ?><span class="brand-accent">//</span><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?><span class="brand-bracket">]</span>
            </a>
            <div class="header-actions">
                <a href="index.php" class="btn btn-primary btn-sm">&larr; Kembali ke Guestbook</a>
                <a href="../index.php" class="btn btn-outline btn-sm">Laman Personal &nearr;</a>
            </div>
        </div>
    </header>

    <main class="container section-block">
        <div class="section-header">
            <span class="section-tag">DATA MANAGEMENT // PORTABILITY</span>
            <h1 class="section-title">Pusat Ekspor Data Guestbook</h1>
            <p class="section-subtitle">
                Unduh seluruh rekaman buku tamu kelompok ke dalam berkas format CSV untuk analisis spreadsheet atau JSON untuk interoperabilitas API terdistribusi.
            </p>
        </div>

        <?php if ($dbError !== null): ?>
            <div class="alert alert-danger" role="alert">
                <div class="alert-title">Koneksi Database Bermasalah</div>
                <p><?= htmlspecialchars($dbError, ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        <?php endif; ?>

        <!-- Telemetry Info -->
        <div class="telemetry-strip" aria-label="Status Data Tersedia">
            <div class="telemetry-item">
                <span class="telemetry-val"><?= $totalEntries ?> Entri</span>
                <span class="telemetry-lbl">TOTAL REKAMAN DI DATABASE</span>
            </div>
            <div class="telemetry-item">
                <span class="telemetry-val"><?= count($availableRoutes) ?> Simpul</span>
                <span class="telemetry-lbl">JUMLAH NODE TERDETEKSI</span>
            </div>
            <div class="telemetry-item">
                <span class="telemetry-val">UTF-8 / BOM</span>
                <span class="telemetry-lbl">ENCODING FORMAT</span>
            </div>
            <div class="telemetry-item">
                <span class="telemetry-val">Real-Time</span>
                <span class="telemetry-lbl">GENERASI BERKAS LANGSUNG</span>
            </div>
        </div>

        <!-- Kartu Pilihan Ekspor -->
        <div class="export-actions-grid">
            <!-- Format CSV -->
            <article class="tech-card export-format-card">
                <div>
                    <div class="card-top-bar">
                        <span class="mono-label">FORMAT // CSV</span>
                        <span class="status-chip">EXCEL READY</span>
                    </div>
                    <h2 class="card-heading">Comma Separated Values (.csv)</h2>
                    <p class="card-desc">
                        Cocok dibuka di Microsoft Excel, Google Sheets, atau aplikasi data kuantitatif lainnya. Dilengkapi UTF-8 BOM agar nama dan isi pesan tidak rusak.
                    </p>
                    <ul class="spec-bullet-list" style="margin-bottom: 1.5rem;">
                        <li>Mencakup ID, Simpul Route, Pengirim, Pesan, Waktu, dan Nama Host.</li>
                        <li>Format tabel tabular terstruktur dan mudah diolah untuk laporan.</li>
                    </ul>
                </div>
                <div>
                    <a href="export.php?format=csv" class="btn btn-primary btn-block">
                        <span>Unduh Semua Pesan (.CSV)</span>
                        <span class="btn-arrow">&darr;</span>
                    </a>
                </div>
            </article>

            <!-- Format JSON -->
            <article class="tech-card export-format-card">
                <div>
                    <div class="card-top-bar">
                        <span class="mono-label">FORMAT // JSON</span>
                        <span class="status-chip">API PAYLOAD</span>
                    </div>
                    <h2 class="card-heading">JavaScript Object Notation (.json)</h2>
                    <p class="card-desc">
                        Format standar untuk integrasi sistem, backup data programatik, atau konsumsi data oleh aplikasi frontend modern maupun service eksternal.
                    </p>
                    <ul class="spec-bullet-list" style="margin-bottom: 1.5rem;">
                        <li>Dilengkapi metadata ekspor (waktu ekspor, node asal, jumlah entri).</li>
                        <li>Format Pretty-Print terstruktur dan valid JSON RFC 8259.</li>
                    </ul>
                </div>
                <div>
                    <a href="export.php?format=json" class="btn btn-secondary btn-block">
                        <span>Unduh Semua Pesan (.JSON)</span>
                        <span class="btn-arrow">&darr;</span>
                    </a>
                </div>
            </article>
        </div>

        <!-- Filter Spesifik Node -->
        <?php if (!empty($availableRoutes)): ?>
            <div class="tech-card" style="margin-top: 1.5rem;">
                <div class="card-top-bar">
                    <span class="mono-label">FILTER // PER NODE EXPORT</span>
                </div>
                <h3 class="card-heading" style="font-size: 1.1rem; margin-bottom: 0.5rem;">Unduh Parsial Berdasarkan Simpul Anggota</h3>
                <p class="card-desc" style="margin-bottom: 1rem;">
                    Pilih simpul khusus jika Anda hanya ingin mengekspor data yang diterima oleh anggota tertentu.
                </p>
                <div style="display: flex; flex-wrap: wrap; gap: 0.6rem;">
                    <?php foreach ($availableRoutes as $rCode): ?>
                        <div style="display: inline-flex; border: 1px solid var(--border-color); background-color: var(--bg-primary);">
                            <span style="font-family: var(--font-mono); font-size: 0.78rem; padding: 0.4rem 0.7rem; background-color: var(--harbor-grey); color: var(--accent-lime); font-weight: 700;"><?= htmlspecialchars((string) $rCode, ENT_QUOTES, 'UTF-8') ?></span>
                            <a href="export.php?format=csv&route=<?= urlencode((string) $rCode) ?>" style="font-family: var(--font-mono); font-size: 0.74rem; padding: 0.4rem 0.6rem; color: var(--text-primary); border-right: 1px solid var(--border-color);" title="Unduh CSV untuk <?= htmlspecialchars((string) $rCode, ENT_QUOTES, 'UTF-8') ?>">CSV &darr;</a>
                            <a href="export.php?format=json&route=<?= urlencode((string) $rCode) ?>" style="font-family: var(--font-mono); font-size: 0.74rem; padding: 0.4rem 0.6rem; color: var(--accent-cyan);" title="Unduh JSON untuk <?= htmlspecialchars((string) $rCode, ENT_QUOTES, 'UTF-8') ?>">JSON &darr;</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Preview Sampel Data -->
        <?php if (!empty($sampleRows)): ?>
            <div class="tech-card" style="margin-top: 1.5rem;">
                <div class="card-top-bar">
                    <span class="mono-label">PREVIEW // 5 REKAMAN TERBARU</span>
                </div>
                <h3 class="card-heading" style="font-size: 1.1rem; margin-bottom: 0.5rem;">Pratinjau Struktur Data</h3>
                <div style="overflow-x: auto;">
                    <table class="preview-table">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>SIMPUL</th>
                                <th>PENGIRIM</th>
                                <th>ISI PESAN</th>
                                <th>WAKTU</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sampleRows as $row): ?>
                                <tr>
                                    <td style="font-family: var(--font-mono); color: var(--accent-cyan);">#<?= (int) $row['id'] ?></td>
                                    <td><span style="font-family: var(--font-mono); color: var(--accent-lime); font-weight: 700;"><?= htmlspecialchars((string) $row['route_id'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                    <td style="font-weight: 600;"><?= htmlspecialchars((string) $row['nama'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td style="color: var(--text-secondary);"><?= htmlspecialchars(mb_strimwidth((string) $row['pesan'], 0, 75, '...'), ENT_QUOTES, 'UTF-8') ?></td>
                                    <td style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--harbor-muted);"><?= htmlspecialchars((string) $row['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <p class="mono-small">&copy; <?= date('Y') ?> <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?>) &mdash; <?= defined('MEMBER_KELAS') ? htmlspecialchars((string) MEMBER_KELAS, ENT_QUOTES, 'UTF-8') : 'IF-48-05' ?>.</p>
            <p class="mono-small">MODUL:DATA_EXPORT_V1 // ROUTE:<?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    </footer>

</body>
</html>


<?php
declare(strict_types=1);

/**
 * Halaman Antarmuka Aplikasi Bersama (Guestbook)
 * Mendukung mode standalone maupun mode embed di halaman utama.
 */

require_once __DIR__ . '/../identity.php';
require_once __DIR__ . '/lib/db.php';

$isEmbed = isset($_GET['embed']) && $_GET['embed'] === '1';
$perPage = 5;
$page    = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

$errors     = [];
$successMsg = '';
$oldNama    = '';
$oldPesan   = '';
$dbError    = null;

if (isset($_GET['status']) && $_GET['status'] === 'created') {
    $successMsg = 'Pesan Anda berhasil tercatat ke dalam Guestbook melalui node ' . htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') . '.';
}

try {
    $pdo = get_db_connection();

    // Pastikan data anggota lokal (m0) terdaftar di tabel anggota agar FK selalu valid
    $ensureMemberStmt = $pdo->prepare(
        'INSERT IGNORE INTO anggota (route_id, nim, nama) VALUES (:route_id, :nim, :nama)'
    );
    $ensureMemberStmt->execute([
        ':route_id' => MEMBER_ROUTE,
        ':nim'      => MEMBER_NIM,
        ':nama'     => MEMBER_NAMA,
    ]);

    // Proses form POST (Validasi Sisi Server + PDO Prepared Statement)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $oldNama  = trim((string) ($_POST['nama'] ?? ''));
        $oldPesan = trim((string) ($_POST['pesan'] ?? ''));

        if ($oldNama === '') {
            $errors['nama'] = 'Nama pengirim wajib diisi.';
        } elseif (mb_strlen($oldNama) < 2) {
            $errors['nama'] = 'Nama pengirim minimal terdiri dari 2 karakter.';
        } elseif (mb_strlen($oldNama) > 100) {
            $errors['nama'] = 'Nama pengirim maksimal 100 karakter.';
        }

        if ($oldPesan === '') {
            $errors['pesan'] = 'Isi pesan tidak boleh kosong.';
        } elseif (mb_strlen($oldPesan) < 5) {
            $errors['pesan'] = 'Isi pesan minimal terdiri dari 5 karakter.';
        } elseif (mb_strlen($oldPesan) > 1000) {
            $errors['pesan'] = 'Isi pesan maksimal 1000 karakter.';
        }

        if (empty($errors)) {
            $insertStmt = $pdo->prepare(
                'INSERT INTO guestbook (route_id, nama, pesan) VALUES (:route_id, :nama, :pesan)'
            );
            $insertStmt->execute([
                ':route_id' => MEMBER_ROUTE,
                ':nama'     => $oldNama,
                ':pesan'    => $oldPesan,
            ]);

            $redirectParams = ['status' => 'created', 'page' => 1];
            if ($isEmbed) {
                $redirectParams['embed'] = '1';
            }
            header('Location: index.php?' . http_build_query($redirectParams));
            exit;
        }
    }

    // Filter opsional berdasarkan route_id
    $filterRoute = isset($_GET['route']) ? trim((string) $_GET['route']) : '';
    $validRoutes = ['m0', 'm1', 'm2', 'm3', 'm4', 'm5'];
    if (!in_array($filterRoute, $validRoutes, true)) {
        $filterRoute = '';
    }

    // Hitung total baris untuk paginasi
    if ($filterRoute !== '') {
        $countStmt = $pdo->prepare('SELECT COUNT(*) FROM guestbook WHERE route_id = :route_id');
        $countStmt->execute([':route_id' => $filterRoute]);
    } else {
        $countStmt = $pdo->prepare('SELECT COUNT(*) FROM guestbook');
        $countStmt->execute();
    }
    $totalEntries = (int) $countStmt->fetchColumn();
    $totalPages   = max(1, (int) ceil($totalEntries / $perPage));

    if ($page > $totalPages) {
        $page = $totalPages;
    }
    $offset = ($page - 1) * $perPage;

    // Ambil daftar pesan beserta informasi anggota (JOIN)
    if ($filterRoute !== '') {
        $listSql = '
            SELECT g.id, g.route_id, g.nama, g.pesan, g.created_at, a.nama AS anggota_nama, a.nim AS anggota_nim
            FROM guestbook g
            LEFT JOIN anggota a ON g.route_id = a.route_id
            WHERE g.route_id = :route_id
            ORDER BY g.created_at DESC, g.id DESC
            LIMIT :limit OFFSET :offset
        ';
        $listStmt = $pdo->prepare($listSql);
        $listStmt->bindValue(':route_id', $filterRoute, PDO::PARAM_STR);
        $listStmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $listStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $listStmt->execute();
    } else {
        $listSql = '
            SELECT g.id, g.route_id, g.nama, g.pesan, g.created_at, a.nama AS anggota_nama, a.nim AS anggota_nim
            FROM guestbook g
            LEFT JOIN anggota a ON g.route_id = a.route_id
            ORDER BY g.created_at DESC, g.id DESC
            LIMIT :limit OFFSET :offset
        ';
        $listStmt = $pdo->prepare($listSql);
        $listStmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $listStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $listStmt->execute();
    }
    $entries = $listStmt->fetchAll();

    // Ambil daftar anggota kelompok untuk direktori node
    $anggotaStmt = $pdo->prepare('SELECT route_id, nim, nama FROM anggota ORDER BY route_id ASC');
    $anggotaStmt->execute();
    $daftarAnggota = $anggotaStmt->fetchAll();

    // Statistik jumlah pesan per node (seluruh data, tidak terpengaruh filter)
    $statStmt = $pdo->prepare('
        SELECT a.route_id, a.nama, COUNT(g.id) AS jumlah
        FROM anggota a
        LEFT JOIN guestbook g ON g.route_id = a.route_id
        GROUP BY a.route_id, a.nama
        ORDER BY a.route_id ASC
    ');
    $statStmt->execute();
    $statNode = $statStmt->fetchAll();

} catch (Throwable $e) {
    $dbError       = $e->getMessage();
    $entries       = [];
    $daftarAnggota = [];
    $statNode      = [];
    $totalEntries  = 0;
    $totalPages    = 1;
    $filterRoute   = '';
}

function build_page_url(int $targetPage, bool $isEmbed, string $filterRoute): string
{
    $params = ['page' => $targetPage];
    if ($filterRoute !== '') {
        $params['route'] = $filterRoute;
    }
    if ($isEmbed) {
        $params['embed'] = '1';
    }
    return 'index.php?' . http_build_query($params);
}
?>
<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook Bersama // <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="<?= $isEmbed ? 'embed-body' : 'standalone-guestbook-body' ?>">

    <?php if (!$isEmbed): ?>
        <?php require_once __DIR__ . '/partials/served_by.php'; ?>

        <header class="site-header">
            <div class="container header-inner">
                <a href="../index.php" class="brand-logo" aria-label="Kembali ke Personal Page">
                    <span class="brand-bracket">[</span>BABAS<span class="brand-accent">//</span><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?><span class="brand-bracket">]</span>
                </a>
                <div class="header-actions">
                    <a href="../index.php" class="btn btn-outline btn-sm">&larr; Kembali ke Personal Page</a>
                </div>
            </div>
        </header>
    <?php endif; ?>

    <main class="<?= $isEmbed ? 'embed-container' : 'container section-block' ?>">
        <?php if (!$isEmbed): ?>
            <div class="section-header">
                <span class="section-tag">SHARED APPLICATION // PRA-UTS</span>
                <h1 class="section-title">Guestbook Kelompok Terdistribusi</h1>
            </div>
        <?php endif; ?>

        <?php if ($dbError !== null): ?>
            <div class="alert alert-danger" role="alert">
                <div class="alert-title">Koneksi Database Belum Siap</div>
                <p> Aplikasi tidak dapat terhubung ke database <code>kelompok_db</code>. Pastikan layanan MySQL/MariaDB di XAMPP sudah berjalan dan Anda telah mengimpor <code>app/sql/schema.sql</code>.</p>
                <pre class="error-detail"><?= htmlspecialchars($dbError, ENT_QUOTES, 'UTF-8') ?></pre>
            </div>
        <?php endif; ?>

        <?php if ($successMsg !== ''): ?>
            <div class="alert alert-success" role="status">
                <div class="alert-title">TRANSMISSION SUCCESS // 200 OK</div>
                <p><?= $successMsg ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger" role="alert">
                <div class="alert-title">VALIDASI SERVER GAGAL</div>
                <ul class="error-list">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="guestbook-grid">
            <!-- Kolom Form Input -->
            <section class="guestbook-form-card tech-card" aria-labelledby="form-heading">
                <div class="card-top-bar">
                    <span class="mono-label">FORM</span>
                    <span class="badge-route">ORIGIN: <?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <h2 id="form-heading" class="card-heading">Tulis Pesan Baru</h2>

                <form id="guestbookForm" method="POST" action="index.php<?= $isEmbed ? '?embed=1' : '' ?>" novalidate>
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Lengkap / Panggilan <span class="req">*</span></label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>"
                            placeholder="Contoh: Raka Pratama"
                            maxlength="100"
                            required
                            value="<?= htmlspecialchars($oldNama, ENT_QUOTES, 'UTF-8') ?>"
                        >
                        <div class="field-feedback" id="namaFeedback">
                            <?= isset($errors['nama']) ? htmlspecialchars($errors['nama'], ENT_QUOTES, 'UTF-8') : '' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="label-row">
                            <label for="pesan" class="form-label">Pesan / Catatan <span class="req">*</span></label>
                            <span id="charCounter" class="mono-counter">0 / 1000</span>
                        </div>
                        <textarea
                            id="pesan"
                            name="pesan"
                            rows="4"
                            class="form-control <?= isset($errors['pesan']) ? 'is-invalid' : '' ?>"
                            placeholder="Tuliskan pesan Anda di sini (minimal 5 karakter)..."
                            maxlength="1000"
                            required
                        ><?= htmlspecialchars($oldPesan, ENT_QUOTES, 'UTF-8') ?></textarea>
                        <div class="field-feedback" id="pesanFeedback">
                            <?= isset($errors['pesan']) ? htmlspecialchars($errors['pesan'], ENT_QUOTES, 'UTF-8') : '' ?>
                        </div>
                    </div>

                    <div class="form-meta-box">
                        <span class="mono-small">ROUTE_ID: <strong><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></strong></span>
                        <span class="mono-small">HOST: <strong><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></strong></span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <span>Kirim Pesan ke Guestbook</span>
                        <span class="btn-arrow">&rarr;</span>
                    </button>
                </form>

                <?php if (!empty($daftarAnggota)): ?>
                    <div class="node-directory">
                        <h3 class="mono-label">REGISTERED GROUP NODES (m0 - m5)</h3>
                        <ul class="node-list">
                            <?php foreach ($daftarAnggota as $agt): ?>
                                <?php
                                $rId   = htmlspecialchars((string) $agt['route_id'], ENT_QUOTES, 'UTF-8');
                                $rNama = htmlspecialchars((string) $agt['nama'], ENT_QUOTES, 'UTF-8');
                                $rNim  = htmlspecialchars((string) $agt['nim'], ENT_QUOTES, 'UTF-8');
                                $isCurrent = ($agt['route_id'] === MEMBER_ROUTE);
                                ?>
                                <li class="node-item <?= $isCurrent ? 'is-active-node' : '' ?>">
                                    <span class="node-code"><?= $rId ?></span>
                                    <span class="node-name"><?= $rNama ?></span>
                                    <span class="node-nim"><?= $rNim ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($statNode)): ?>
                    <?php
                    $statTotal = array_sum(array_column($statNode, 'jumlah'));
                    $statMax   = max(1, ...array_map('intval', array_column($statNode, 'jumlah')));
                    ?>
                    <div class="node-stats">
                        <div class="label-row">
                            <h3 class="mono-label">NODE TRAFFIC STATS</h3>
                            <span class="mono-small"><?= $statTotal ?> PESAN</span>
                        </div>
                        <ul class="stat-list">
                            <?php foreach ($statNode as $st): ?>
                                <?php
                                $sRoute  = (string) $st['route_id'];
                                $sJumlah = (int) $st['jumlah'];
                                $sPersen = $statTotal > 0 ? round($sJumlah / $statTotal * 100) : 0;
                                $sLebar  = round($sJumlah / $statMax * 100);
                                ?>
                                <li>
                                    <a class="stat-item <?= $sRoute === MEMBER_ROUTE ? 'is-active-node' : '' ?> <?= $sRoute === $filterRoute ? 'is-filtered' : '' ?>"
                                       href="<?= htmlspecialchars(build_page_url(1, $isEmbed, $sRoute), ENT_QUOTES, 'UTF-8') ?>"
                                       title="Lihat pesan dari <?= htmlspecialchars((string) $st['nama'], ENT_QUOTES, 'UTF-8') ?>">
                                        <span class="node-code"><?= htmlspecialchars($sRoute, ENT_QUOTES, 'UTF-8') ?></span>
                                        <span class="stat-track" aria-hidden="true"><span class="stat-bar" style="width: <?= $sLebar ?>%"></span></span>
                                        <span class="stat-count"><?= $sJumlah ?> <span class="node-nim">(<?= $sPersen ?>%)</span></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Kolom Daftar Entri & Paginasi -->
            <section class="guestbook-feed-card tech-card" aria-labelledby="feed-heading">
                <div class="card-top-bar">
                    <span class="mono-label">FEED</span>
                    <span class="mono-label">TOTAL: <?= $totalEntries ?> PESAN</span>
                </div>

                <div class="feed-header-row">
                    <h2 id="feed-heading" class="card-heading">Daftar Entri Terbaru</h2>

                    <!-- Filter Node -->
                    <div class="route-filter-pills" role="group" aria-label="Filter berdasarkan route anggota">
                        <a href="<?= htmlspecialchars(build_page_url(1, $isEmbed, ''), ENT_QUOTES, 'UTF-8') ?>"
                           class="filter-pill <?= $filterRoute === '' ? 'active' : '' ?>">Semua</a>
                        <?php foreach (['m0', 'm1', 'm2', 'm3', 'm4', 'm5'] as $rCode): ?>
                            <a href="<?= htmlspecialchars(build_page_url(1, $isEmbed, $rCode), ENT_QUOTES, 'UTF-8') ?>"
                               class="filter-pill <?= $filterRoute === $rCode ? 'active' : '' ?>"><?= $rCode ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if (empty($entries)): ?>
                    <div class="empty-state">
                        <p class="mono-label">NO_DATA_FOUND</p>
                        <p>Belum ada pesan buku tamu untuk kriteria ini. Jadilah yang pertama menulis pesan!</p>
                    </div>
                <?php else: ?>
                    <div class="entries-list">
                        <?php foreach ($entries as $item): ?>
                            <?php
                            $eId          = (int) $item['id'];
                            $eRoute       = htmlspecialchars((string) $item['route_id'], ENT_QUOTES, 'UTF-8');
                            $eNama        = htmlspecialchars((string) $item['nama'], ENT_QUOTES, 'UTF-8');
                            $ePesan       = nl2br(htmlspecialchars((string) $item['pesan'], ENT_QUOTES, 'UTF-8'));
                            $eTime        = htmlspecialchars((string) $item['created_at'], ENT_QUOTES, 'UTF-8');
                            $eAnggotaNama = !empty($item['anggota_nama'])
                                ? htmlspecialchars((string) $item['anggota_nama'], ENT_QUOTES, 'UTF-8')
                                : 'Node ' . $eRoute;
                            ?>
                            <article class="entry-item">
                                <div class="entry-header">
                                    <div class="entry-author-wrap">
                                        <span class="entry-avatar" aria-hidden="true"><?= htmlspecialchars(mb_strtoupper(mb_substr((string) $item['nama'], 0, 1)), ENT_QUOTES, 'UTF-8') ?></span>
                                        <div>
                                            <h3 class="entry-author"><?= $eNama ?></h3>
                                            <span class="entry-via">via Node <strong><?= $eRoute ?></strong> (<?= $eAnggotaNama ?>)</span>
                                        </div>
                                    </div>
                                    <div class="entry-meta">
                                        <span class="entry-id">#<?= $eId ?></span>
                                        <time class="entry-time" datetime="<?= $eTime ?>"><?= $eTime ?></time>
                                    </div>
                                </div>
                                <div class="entry-body">
                                    <?= $ePesan ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <!-- Navigasi Paginasi (5 Pesan per Halaman) -->
                    <nav class="pagination-bar" aria-label="Paginasi Guestbook">
                        <div class="pagination-info mono-small">
                            Halaman <strong><?= $page ?></strong> dari <strong><?= $totalPages ?></strong> (<?= $perPage ?> entri/hal)
                        </div>
                        <div class="pagination-controls">
                            <?php if ($page > 1): ?>
                                <a class="page-btn" href="<?= htmlspecialchars(build_page_url($page - 1, $isEmbed, $filterRoute), ENT_QUOTES, 'UTF-8') ?>">&laquo; Prev</a>
                            <?php else: ?>
                                <span class="page-btn is-disabled" aria-disabled="true">&laquo; Prev</span>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a class="page-btn <?= $i === $page ? 'is-current' : '' ?>"
                                   href="<?= htmlspecialchars(build_page_url($i, $isEmbed, $filterRoute), ENT_QUOTES, 'UTF-8') ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <a class="page-btn" href="<?= htmlspecialchars(build_page_url($page + 1, $isEmbed, $filterRoute), ENT_QUOTES, 'UTF-8') ?>">Next &raquo;</a>
                            <?php else: ?>
                                <span class="page-btn is-disabled" aria-disabled="true">Next &raquo;</span>
                            <?php endif; ?>
                        </div>
                    </nav>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <?php if (!$isEmbed): ?>
        <footer class="site-footer">
            <div class="container footer-inner">
                <p class="mono-small">&copy; <?= date('Y') ?> <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?>) &mdash; IF-48-05 Telkom University.</p>
                <p class="mono-small">MODUL:GUESTBOOK_PDO_V1 // ROUTE:<?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </footer>
    <?php endif; ?>

    <script src="assets/js/main.js"></script>
</body>
</html>

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
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

$errors = [];
$successMsg = '';
$oldNama = '';
$oldPesan = '';
$dbError = null;

if (isset($_GET['status']) && $_GET['status'] === 'created') {
    $successMsg = 'Pesan Anda berhasil dikirim ke Buku Tamu melalui laman ' . htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') . ' (' . htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') . ').';
}

try {
    $pdo = get_db_connection();

    // Pastikan data anggota lokal terdaftar di tabel anggota agar FK selalu valid
    $ensureMemberStmt = $pdo->prepare(
        'INSERT IGNORE INTO anggota (route_id, nim, nama) VALUES (:route_id, :nim, :nama)'
    );
    $ensureMemberStmt->execute([
        ':route_id' => MEMBER_ROUTE,
        ':nim' => MEMBER_NIM,
        ':nama' => MEMBER_NAMA,
    ]);

    // Proses form POST (Validasi Sisi Server + PDO Prepared Statement)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $oldNama = trim((string) ($_POST['nama'] ?? ''));
        $oldPesan = trim((string) ($_POST['pesan'] ?? ''));

        if ($oldNama === '') {
            $errors['nama'] = 'Nama pengirim wajib diisi.';
        } elseif (strlen($oldNama) < 2) {
            $errors['nama'] = 'Nama pengirim minimal terdiri dari 2 karakter.';
        } elseif (strlen($oldNama) > 100) {
            $errors['nama'] = 'Nama pengirim maksimal 100 karakter.';
        }

        if ($oldPesan === '') {
            $errors['pesan'] = 'Isi pesan tidak boleh kosong.';
        } elseif (strlen($oldPesan) < 5) {
            $errors['pesan'] = 'Isi pesan minimal terdiri dari 5 karakter.';
        } elseif (strlen($oldPesan) > 1000) {
            $errors['pesan'] = 'Isi pesan maksimal 1000 karakter.';
        }

        if (empty($errors)) {
            $insertStmt = $pdo->prepare(
                'INSERT INTO guestbook (route_id, nama, pesan) VALUES (:route_id, :nama, :pesan)'
            );
            $insertStmt->execute([
                ':route_id' => MEMBER_ROUTE,
                ':nama' => $oldNama,
                ':pesan' => $oldPesan,
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
    $validRoutes = ['m0', 'm1', 'm2', 'm3', 'm4'];
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
    $totalPages = max(1, (int) ceil($totalEntries / $perPage));

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

} catch (Throwable $e) {
    // Fallback penyimpanan lokal JSON apabila layanan MySQL belum dinyalakan saat pratinjau lokal
    $dbError = null;
    $fallbackFile = __DIR__ . '/sql/local_guestbook.json';

    if (!file_exists($fallbackFile)) {
        @file_put_contents($fallbackFile, "[]\n");
    }

    $allEntries = json_decode((string) @file_get_contents($fallbackFile), true);
    if (!is_array($allEntries)) {
        $allEntries = [];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $oldNama = trim((string) ($_POST['nama'] ?? ''));
        $oldPesan = trim((string) ($_POST['pesan'] ?? ''));

        if ($oldNama === '' || strlen($oldNama) < 2) {
            $errors['nama'] = 'Nama pengirim minimal terdiri dari 2 karakter.';
        } elseif (strlen($oldNama) > 100) {
            $errors['nama'] = 'Nama pengirim maksimal 100 karakter.';
        }

        if ($oldPesan === '' || strlen($oldPesan) < 5) {
            $errors['pesan'] = 'Isi pesan minimal terdiri dari 5 karakter.';
        } elseif (strlen($oldPesan) > 1000) {
            $errors['pesan'] = 'Isi pesan maksimal 1000 karakter.';
        }

        if (empty($errors)) {
            $nextId = empty($allEntries) ? 1 : (max(array_column($allEntries, 'id')) + 1);
            array_unshift($allEntries, [
                'id' => $nextId,
                'route_id' => MEMBER_ROUTE,
                'nama' => $oldNama,
                'pesan' => $oldPesan,
                'created_at' => date('Y-m-d H:i:s'),
                'anggota_nama' => MEMBER_NAMA,
                'anggota_nim' => MEMBER_NIM,
            ]);
            @file_put_contents($fallbackFile, json_encode($allEntries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            $redirectParams = ['status' => 'created', 'page' => 1];
            if ($isEmbed) {
                $redirectParams['embed'] = '1';
            }
            header('Location: index.php?' . http_build_query($redirectParams));
            exit;
        }
    }

    $filterRoute = isset($_GET['route']) ? trim((string) $_GET['route']) : '';
    $validRoutes = ['m0', 'm1', 'm2', 'm3', 'm4'];
    if (!in_array($filterRoute, $validRoutes, true)) {
        $filterRoute = '';
    }

    $filtered = $filterRoute === ''
        ? $allEntries
        : array_values(array_filter($allEntries, static fn($row) => ($row['route_id'] ?? '') === $filterRoute));

    $totalEntries = count($filtered);
    $totalPages = max(1, (int) ceil($totalEntries / $perPage));
    if ($page > $totalPages) {
        $page = $totalPages;
    }
    $offset = ($page - 1) * $perPage;
    $entries = array_slice($filtered, $offset, $perPage);
    $daftarAnggota = [];
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
    <title>Guestbook // <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cabinet+Grotesk:wght@700;800;900&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=25">
</head>

<body class="<?= $isEmbed ? 'embed-body' : 'standalone-guestbook-body' ?>">

    <?php if (!$isEmbed): ?>
        <?php require_once __DIR__ . '/partials/served_by.php'; ?>

        <header class="site-header">
            <div class="container header-inner" style="justify-content: space-between;">
                <div class="header-actions" style="margin-left: 0;">
                    <a href="../index.php" class="btn btn-outline btn-sm">&larr; Kembali ke Personal Page</a>
                </div>
                <div class="header-actions">
                    <button type="button" id="themeToggleBtn" class="btn btn-icon"
                        aria-label="Ubah tema Overworld / Underground" title="Toggle Mario World Theme">
                        <span class="theme-indicator-dot"></span>
                        <span class="mono-small" id="themeLabel"
                            style="font-family: var(--font-pixel); font-size: 0.65rem;">UNDERGROUND</span>
                    </button>
                </div>
            </div>
        </header>
    <?php endif; ?>

    <main class="<?= $isEmbed ? 'embed-container' : 'container section-block' ?>">
        <?php if (!$isEmbed): ?>
            <div class="section-header">
                <span class="section-tag">★ SHARED APPLICATION // GUESTBOOK</span>
                <h1 class="section-title">Buku Tamu Kelompok</h1>
            </div>
        <?php endif; ?>

        <?php if ($successMsg !== ''): ?>
            <div class="alert alert-success" role="status">
                <div class="alert-title">★ PESAN TERKIRIM</div>
                <p><?= $successMsg ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger" role="alert">
                <div class="alert-title">PERIKSA KEMBALI INPUT ANDA</div>
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
                    <span class="mono-label">✍️ FORM BUKU TAMU</span>
                    <span class="badge-route">NODE <?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <h2 id="form-heading" class="card-heading">Tulis Pesan Baru</h2>

                <form id="guestbookForm" method="POST" action="index.php<?= $isEmbed ? '?embed=1' : '' ?>" novalidate>
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Anda <span class="req">*</span></label>
                        <input type="text" id="nama" name="nama"
                            class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>"
                            placeholder="Masukkan nama Anda..." maxlength="100" required
                            value="<?= htmlspecialchars($oldNama, ENT_QUOTES, 'UTF-8') ?>">
                        <div class="field-feedback" id="namaFeedback">
                            <?= isset($errors['nama']) ? htmlspecialchars($errors['nama'], ENT_QUOTES, 'UTF-8') : '' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="label-row">
                            <label for="pesan" class="form-label">Pesan / Kesan <span class="req">*</span></label>
                            <span id="charCounter" class="mono-counter">0 / 1000</span>
                        </div>

                        <!-- Chip Reaksi & Template Cepat Interaktif -->
                        <div class="quick-reaction-bar" aria-label="Template pesan cepat">
                            <button type="button" class="reaction-chip" data-text="🍄 Semangat terus kuliahnya Nadia! ">🍄 Semangat!</button>
                            <button type="button" class="reaction-chip" data-text="⭐ Tampilan web Mario Bros-nya keren banget! ">⭐ Web Keren!</button>
                            <button type="button" class="reaction-chip" data-text="🔥 Sukses buat proyek SuperKost & PoluSee-nya! ">🔥 Sukses Proyek!</button>
                            <button type="button" class="reaction-chip" data-text="🎮 Salam kenal dari pengunjung Node m3! ">🎮 Salam Kenal!</button>
                        </div>

                        <textarea id="pesan" name="pesan" rows="4"
                            class="form-control <?= isset($errors['pesan']) ? 'is-invalid' : '' ?>"
                            placeholder="Tulis pesan atau klik reaksi cepat di atas..." maxlength="1000"
                            required><?= htmlspecialchars($oldPesan, ENT_QUOTES, 'UTF-8') ?></textarea>
                        <div class="field-feedback" id="pesanFeedback">
                            <?= isset($errors['pesan']) ? htmlspecialchars($errors['pesan'], ENT_QUOTES, 'UTF-8') : '' ?>
                        </div>
                    </div>

                    <!-- Pratinjau Pesan Langsung (Live Preview Saat Mengetik) -->
                    <div class="live-preview-box" id="guestbookLivePreview" style="display: none;" aria-live="polite">
                        <div class="live-preview-header">
                            <span class="mono-label">👁️ LIVE PREVIEW PESAN ANDA</span>
                        </div>
                        <div class="entry-header" style="margin-bottom: 0.35rem;">
                            <div class="entry-author-wrap">
                                <span class="entry-avatar" id="previewAvatar">?</span>
                                <div>
                                    <h3 class="entry-author" id="previewAuthor">Nama Anda</h3>
                                    <span class="entry-via">via <strong><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></strong> (<?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>)</span>
                                </div>
                            </div>
                        </div>
                        <div class="entry-body" id="previewBody">...</div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <span>Kirim Pesan &rarr;</span>
                    </button>
                </form>
            </section>

            <!-- Kolom Daftar Entri & Paginasi -->
            <section class="guestbook-feed-card tech-card" aria-labelledby="feed-heading">
                <div class="card-top-bar">
                    <span class="mono-label">💬 DAFTAR PESAN</span>
                    <div style="display: inline-flex; align-items: center; gap: 0.65rem;">
                        <button type="button" class="time-format-toggle-btn" id="timeFormatToggleBtn"
                            title="Klik untuk beralih antara Waktu Relatif (lalu) dan Tanggal Asli">
                            <span class="time-toggle-icon">⏱️</span>
                            <span class="time-toggle-label">Waktu Relatif</span>
                        </button>
                        <span class="mono-label"><?= $totalEntries ?> PESAN</span>
                    </div>
                </div>

                <div class="feed-header-row">
                    <h2 id="feed-heading" class="card-heading">Pesan Terbaru</h2>

                    <!-- Filter Node -->
                    <div class="route-filter-pills" role="group" aria-label="Filter berdasarkan route anggota">
                        <a href="<?= htmlspecialchars(build_page_url(1, $isEmbed, ''), ENT_QUOTES, 'UTF-8') ?>"
                            class="filter-pill <?= $filterRoute === '' ? 'active' : '' ?>">Semua</a>
                        <?php foreach (['m0', 'm1', 'm2', 'm3', 'm4'] as $rCode): ?>
                            <a href="<?= htmlspecialchars(build_page_url(1, $isEmbed, $rCode), ENT_QUOTES, 'UTF-8') ?>"
                                class="filter-pill <?= $filterRoute === $rCode ? 'active' : '' ?>"><?= $rCode ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if (empty($entries)): ?>
                    <div class="empty-state">
                        <p class="mono-label">BELUM ADA PESAN</p>
                        <p>Belum ada pesan untuk filter ini. Jadilah yang pertama menulis pesan!</p>
                    </div>
                <?php else: ?>
                    <div class="entries-list">
                        <?php foreach ($entries as $item): ?>
                            <?php
                            $eId = (int) $item['id'];
                            $eRoute = htmlspecialchars((string) $item['route_id'], ENT_QUOTES, 'UTF-8');
                            $eNama = htmlspecialchars((string) $item['nama'], ENT_QUOTES, 'UTF-8');
                            $ePesan = nl2br(htmlspecialchars((string) $item['pesan'], ENT_QUOTES, 'UTF-8'));
                            $eTime = htmlspecialchars((string) $item['created_at'], ENT_QUOTES, 'UTF-8');
                            $eAnggotaNama = !empty($item['anggota_nama'])
                                ? htmlspecialchars((string) $item['anggota_nama'], ENT_QUOTES, 'UTF-8')
                                : 'Node ' . $eRoute;
                            ?>
                            <article class="entry-item">
                                <div class="entry-header">
                                    <div class="entry-author-wrap">
                                        <span class="entry-avatar"
                                            aria-hidden="true"><?= htmlspecialchars(strtoupper(substr((string) $item['nama'], 0, 1)), ENT_QUOTES, 'UTF-8') ?></span>
                                        <div>
                                            <h3 class="entry-author"><?= $eNama ?></h3>
                                            <span class="entry-via">via <strong><?= $eRoute ?></strong> (<?= $eAnggotaNama ?>)</span>
                                        </div>
                                    </div>
                                    <div class="entry-meta">
                                        <time class="entry-time" datetime="<?= $eTime ?>"><?= $eTime ?></time>
                                    </div>
                                </div>
                                <div class="entry-body">
                                    <?= $ePesan ?>
                                </div>
                                <div class="entry-actions-bar">
                                    <button type="button" class="entry-coin-btn" data-entry-id="<?= $eId ?>" title="Berikan Koin Mario!">
                                        <span>🪙</span> <span class="coin-like-num">1</span>
                                    </button>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($totalPages > 1): ?>
                        <nav class="pagination-bar" aria-label="Paginasi Guestbook">
                            <div class="pagination-info mono-small">
                                Hal <strong><?= $page ?></strong> dari <strong><?= $totalPages ?></strong>
                            </div>
                            <div class="pagination-controls">
                                <?php if ($page > 1): ?>
                                    <a class="page-btn"
                                        href="<?= htmlspecialchars(build_page_url($page - 1, $isEmbed, $filterRoute), ENT_QUOTES, 'UTF-8') ?>">&laquo; Prev</a>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <a class="page-btn <?= $i === $page ? 'is-current' : '' ?>"
                                        href="<?= htmlspecialchars(build_page_url($i, $isEmbed, $filterRoute), ENT_QUOTES, 'UTF-8') ?>">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <a class="page-btn"
                                        href="<?= htmlspecialchars(build_page_url($page + 1, $isEmbed, $filterRoute), ENT_QUOTES, 'UTF-8') ?>">Next &raquo;</a>
                                <?php endif; ?>
                            </div>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <?php if (!$isEmbed): ?>
        <div class="mario-brick-ground" aria-hidden="true"></div>
        <footer class="site-footer">
            <div class="container footer-inner" style="justify-content: center; text-align: center;">
                <p class="mono-small" style="margin: 0 auto; text-align: center;">&copy; <?= date('Y') ?> <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>
                    (<?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?>) &mdash; IF-48-05 Telkom University.</p>
            </div>
        </footer>
    <?php endif; ?>

    <script src="../assets/js/main.js?v=25"></script>
</body>

</html>

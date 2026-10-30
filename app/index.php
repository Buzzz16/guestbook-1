<?php
declare(strict_types=1);

/**
 * Halaman Antarmuka Aplikasi Bersama (Guestbook)
 * Mendukung mode standalone maupun mode embed di halaman utama.
 */

require_once __DIR__ . '/../identity.php';
require_once __DIR__ . '/lib/db.php';

$isEmbed = isset($_GET['embed']) && $_GET['embed'] === '1';
$memberNickname = defined('MEMBER_NICKNAME') && !empty(MEMBER_NICKNAME)
    ? (string) MEMBER_NICKNAME
    : (defined('MEMBER_NAMA') ? (string) MEMBER_NAMA : 'MEMBER');
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
        $wordCount = $oldPesan === '' ? 0 : count(preg_split('/\s+/', $oldPesan, -1, PREG_SPLIT_NO_EMPTY));

        if ($oldNama === '') {
            $errors['nama'] = 'Nama pengirim wajib diisi.';
        } elseif (mb_strlen($oldNama) < 2) {
            $errors['nama'] = 'Nama pengirim minimal terdiri dari 2 karakter.';
        } elseif (mb_strlen($oldNama) > 100) {
            $errors['nama'] = 'Nama pengirim maksimal 100 karakter.';
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $oldNama)) {
            $errors['nama'] = 'Nama hanya boleh berupa huruf dan spasi (tidak boleh mengandung simbol atau angka).';
        }

        if ($oldPesan === '') {
            $errors['pesan'] = 'Isi pesan tidak boleh kosong.';
        } elseif (mb_strlen($oldPesan) < 5) {
            $errors['pesan'] = 'Isi pesan minimal terdiri dari 5 karakter.';
        } elseif ($wordCount > 1000) {
            $errors['pesan'] = "Isi pesan tidak boleh melebihi 1000 kata (saat ini: {$wordCount} kata).";
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


    // Keyword pencarian opsional (berdasarkan nama ATAU keyword isi pesan)
    $searchQuery = isset($_GET['q']) ? trim((string) $_GET['q']) : '';

    // Susun WHERE clauses dan PDO parameter bindings secara aman (Prepared Statement)
    $whereConditions = [];
    $queryParams     = [];

    if ($filterRoute !== '') {
        $whereConditions[] = 'g.route_id = :route_id';
        $queryParams[':route_id'] = $filterRoute;
    }

    if ($searchQuery !== '') {
        $whereConditions[] = '(g.nama LIKE :search OR g.pesan LIKE :search)';
        $queryParams[':search'] = '%' . $searchQuery . '%';
    }

    $whereSql = !empty($whereConditions) ? ' WHERE ' . implode(' AND ', $whereConditions) : '';

    // Hitung total baris untuk paginasi berdasarkan filter & search
    $countSql  = 'SELECT COUNT(*) FROM guestbook g' . $whereSql;
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($queryParams);
    $totalEntries = (int) $countStmt->fetchColumn();
    $totalPages   = max(1, (int) ceil($totalEntries / $perPage));

    if ($page > $totalPages) {
        $page = $totalPages;
    }
    $offset = ($page - 1) * $perPage;

    // Ambil daftar pesan beserta informasi anggota (JOIN)
    $listSql = "
        SELECT g.id, g.route_id, g.nama, g.pesan, g.created_at, a.nama AS anggota_nama, a.nim AS anggota_nim
        FROM guestbook g
        LEFT JOIN anggota a ON g.route_id = a.route_id
        {$whereSql}
        ORDER BY g.created_at DESC, g.id DESC
        LIMIT :limit OFFSET :offset
    ";
    $listStmt = $pdo->prepare($listSql);
    foreach ($queryParams as $paramKey => $paramVal) {
        $listStmt->bindValue($paramKey, $paramVal, PDO::PARAM_STR);
    }
    $listStmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $listStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $listStmt->execute();
    $entries = $listStmt->fetchAll();

    // Ambil daftar anggota kelompok untuk direktori node
    $anggotaStmt = $pdo->prepare('SELECT route_id, nim, nama FROM anggota ORDER BY route_id ASC');
    $anggotaStmt->execute();
    $daftarAnggota = $anggotaStmt->fetchAll();

} catch (Throwable $e) {
    $dbError       = $e->getMessage();
    $entries       = [];
    $daftarAnggota = [];
    $totalEntries  = 0;
    $totalPages    = 1;
    $filterRoute   = '';
    $searchQuery   = '';
}

function build_page_url(int $targetPage, bool $isEmbed, string $filterRoute, string $searchQuery = ''): string
{
    $params = ['page' => $targetPage];
    if ($filterRoute !== '') {
        $params['route'] = $filterRoute;
    }
    if ($searchQuery !== '') {
        $params['q'] = $searchQuery;
    }
    if ($isEmbed) {
        $params['embed'] = '1';
    }
    return 'index.php?' . http_build_query($params);
}

function highlight_match(string $text, string $query): string
{
    $escaped = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    if ($query === '') {
        return nl2br($escaped);
    }
    $pattern = '/' . preg_quote($query, '/') . '/i';
    $highlighted = preg_replace($pattern, '<mark class="search-highlight">$0</mark>', $escaped);
    return nl2br($highlighted ?? $escaped);
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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="<?= $isEmbed ? 'embed-body' : 'standalone-guestbook-body' ?>">

    <?php if (!$isEmbed): ?>
        <?php require_once __DIR__ . '/partials/served_by.php'; ?>

        <header class="site-header">
            <div class="container header-inner">
                <a href="../index.php" class="brand-logo" aria-label="Kembali ke Personal Page">
                    <span class="brand-bracket">[</span><?= htmlspecialchars(mb_strtoupper($memberNickname), ENT_QUOTES, 'UTF-8') ?><span class="brand-accent">//</span><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?><span class="brand-bracket">]</span>
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
                            placeholder="Contoh: Glen David"
                            maxlength="100"
                            pattern="[a-zA-Z\s]+"
                            title="Nama hanya boleh berupa huruf dan spasi (tanpa angka atau simbol)"
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
                            <span id="charCounter" class="mono-counter">0 / 1000 kata</span>
                        </div>
                        <textarea
                            id="pesan"
                            name="pesan"
                            rows="4"
                            class="form-control <?= isset($errors['pesan']) ? 'is-invalid' : '' ?>"
                            placeholder="Tuliskan pesan Anda di sini (minimal 5 karakter, maksimal 1000 kata)..."
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
                        <h3 class="mono-label">REGISTERED GROUP NODES (m0 - m4)</h3>
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
                        <a href="<?= htmlspecialchars(build_page_url(1, $isEmbed, '', $searchQuery), ENT_QUOTES, 'UTF-8') ?>"
                           class="filter-pill <?= $filterRoute === '' ? 'active' : '' ?>">Semua</a>
                        <?php foreach (['m0', 'm1', 'm2', 'm3', 'm4', 'm5'] as $rCode): ?>
                            <a href="<?= htmlspecialchars(build_page_url(1, $isEmbed, $rCode, $searchQuery), ENT_QUOTES, 'UTF-8') ?>"
                               class="filter-pill <?= $filterRoute === $rCode ? 'active' : '' ?>"><?= $rCode ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Formulir Pencarian Pesan / Nama -->
                <form method="GET" action="index.php" class="guestbook-search-form" role="search">
                    <?php if ($isEmbed): ?>
                        <input type="hidden" name="embed" value="1">
                    <?php endif; ?>
                    <?php if ($filterRoute !== ''): ?>
                        <input type="hidden" name="route" value="<?= htmlspecialchars($filterRoute, ENT_QUOTES, 'UTF-8') ?>">
                    <?php endif; ?>
                    <div class="search-input-wrap">
                        <input
                            type="search"
                            name="q"
                            class="form-control search-input"
                            placeholder="Cari berdasarkan nama pengirim atau kata kunci pesan..."
                            value="<?= htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8') ?>"
                            aria-label="Cari nama atau keyword pesan"
                        >
                    </div>
                    <button type="submit" class="btn btn-primary search-btn" aria-label="Lakukan pencarian">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 256 256"><path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path></svg>
                        <span>Cari</span>
                    </button>
                    <?php if ($searchQuery !== ''): ?>
                        <a href="<?= htmlspecialchars(build_page_url(1, $isEmbed, $filterRoute, ''), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline search-reset-btn" title="Hapus pencarian">
                            &times; Reset
                        </a>
                    <?php endif; ?>
                </form>

                <?php if ($searchQuery !== ''): ?>
                    <div class="search-result-badge">
                        <span>Pencarian: <strong>&ldquo;<?= htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8') ?>&rdquo;</strong> &mdash; Ditemukan <?= $totalEntries ?> pesan</span>
                    </div>
                <?php endif; ?>

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
                            $eNamaRaw     = htmlspecialchars((string) $item['nama'], ENT_QUOTES, 'UTF-8');
                            $eNama        = highlight_match((string) $item['nama'], $searchQuery);
                            $ePesan       = highlight_match((string) $item['pesan'], $searchQuery);
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
                                <a class="page-btn" href="<?= htmlspecialchars(build_page_url($page - 1, $isEmbed, $filterRoute, $searchQuery), ENT_QUOTES, 'UTF-8') ?>">&laquo; Prev</a>
                            <?php else: ?>
                                <span class="page-btn is-disabled" aria-disabled="true">&laquo; Prev</span>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a class="page-btn <?= $i === $page ? 'is-current' : '' ?>"
                                   href="<?= htmlspecialchars(build_page_url($i, $isEmbed, $filterRoute, $searchQuery), ENT_QUOTES, 'UTF-8') ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <a class="page-btn" href="<?= htmlspecialchars(build_page_url($page + 1, $isEmbed, $filterRoute, $searchQuery), ENT_QUOTES, 'UTF-8') ?>">Next &raquo;</a>
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

    <script src="../assets/js/main.js"></script>
</body>
</html>

<?php
declare(strict_types=1);

/**
 * Halaman Utama Personal Page (Root `index.php`)
 * Mahasiswa : Yuriko Astiani (Yury) - 103012400045 - Node m4
 * Tema      : Gojo Satoru Edition (Dashboard Top + Architectural Editorial Grid Bottom)
 */

require_once __DIR__ . '/identity.php';

$portfolios = [
    [
        'id' => '01',
        'title' => 'SUPERKOST',
        'subtitle' => 'Platform Manajemen & Digitalisasi Hunian Indekos',
        'category' => 'web-app',
        'tags' => ['PHP / JAVA', 'MYSQL DB', 'WEB APP'],
        'year' => '2025',
        'status' => 'Featured',
        'preview_headline' => "Elevating Kost\nManagement",
        'preview_kicker' => 'HUNIAN DIGITAL // 2025',
        'preview_img' => 'assets/img/gojo-art-1.png',
        'summary' => 'Aplikasi pengelolaan kamar kos dan hunian terpadu untuk monitoring ketersediaan unit, pencatatan sewa penghuni, tagihan berkala, dan rekap keuangan pemilik kos.',
        'highlights' => [
            'Manajemen ketersediaan unit kamar dan data penghuni real-time',
            'Pencatatan otomatis histori tagihan bulanan dan pembayaran sewa',
            'Dashboard ringkas untuk laporan keuangan dan rekap hunian',
        ],
    ],
    [
        'id' => '02',
        'title' => 'REDESAIN IGRACIAS',
        'subtitle' => 'UI/UX Redesign Portal Akademik Terintegrasi',
        'category' => 'ui-ux',
        'tags' => ['UI/UX', 'FIGMA', 'WEB DESIGN'],
        'year' => '2025',
        'status' => 'Featured',
        'preview_headline' => "Modern Academic\nPortal Living",
        'preview_kicker' => 'TELKOM UNIVERSITY // UI/UX',
        'preview_img' => 'assets/img/gojo-banner.png',
        'summary' => 'Pembaruan antarmuka portal akademik iGracias Telkom University yang lebih bersih, modern, dan intuitif untuk kemudahan registrasi mata kuliah (KRS), cek jadwal kuliah, dan pantau nilai.',
        'highlights' => [
            'Antarmuka modern yang segar, minim distraksi, dan mudah dipahami',
            'Tata letak jadwal perkuliahan serta grafik nilai yang lebih rapi',
            'Navigasi responsif yang nyaman diakses melalui perangkat smartphone',
        ],
    ],
    [
        'id' => '03',
        'title' => 'FINSMART',
        'subtitle' => 'Aplikasi Pelacak & Pengatur Keuangan Mandiri',
        'category' => 'fintech',
        'tags' => ['FINTECH', 'JAVASCRIPT', 'DATA CHARTS'],
        'year' => '2025',
        'status' => 'Verified',
        'preview_headline' => "Focus\nTrack\nElevate",
        'preview_kicker' => 'SMART FINANCE // 2025',
        'preview_img' => 'assets/img/gojo-art-2.png',
        'summary' => 'Platform pengatur keuangan cerdas untuk mencatat arus kas harian (pemasukan & pengeluaran), menetapkan alokasi anggaran belanja, dan menyajikan ringkasan visual.',
        'highlights' => [
            'Pencatatan transaksi harian cepat dengan kategorisasi pengeluaran',
            'Fitur penetapan target anggaran dan peringatan batas belanja',
            'Visualisasi grafik arus kas interaktif yang informatif',
        ],
    ],
    [
        'id' => '04',
        'title' => 'POLUSEE',
        'subtitle' => 'Platform Web Pemantau & Cek Kualitas Udara',
        'category' => 'env-web',
        'tags' => ['AIR QUALITY', 'WEB APP', 'MONITORING'],
        'year' => '2025',
        'status' => 'Verified',
        'preview_headline' => "Clean Air\nReal-Time\nVision",
        'preview_kicker' => 'ENVIRONMENT // AQI MONITOR',
        'preview_img' => 'assets/img/gojo-aura.png',
        'summary' => 'Aplikasi web interaktif untuk memantau dan mengecek indeks kualitas udara (AQI) secara real-time, memberikan informasi tingkat polusi, serta rekomendasi kesehatan lingkungan.',
        'highlights' => [
            'Pengecekan indeks kualitas udara (AQI) dan status polusi secara akurat',
            'Indikator visual kategori udara bersih hingga berbahaya yang mudah dipahami',
            'Informasi edukasi dan rekomendasi aktivitas luar ruangan berdasarkan kondisi udara',
        ],
    ],
];

$tools = [
    ['abbr' => 'Ph', 'name' => 'PHP & MYSQL', 'desc' => 'Backend & Relasional PDO'],
    ['abbr' => 'Jv', 'name' => 'JAVA OOP', 'desc' => 'Object-Oriented Architecture'],
    ['abbr' => 'Fg', 'name' => 'FIGMA', 'desc' => 'UI/UX & Interactive Prototype'],
    ['abbr' => 'Hc', 'name' => 'HTML5 & CSS3', 'desc' => 'Responsive Editorial Layout'],
    ['abbr' => 'Js', 'name' => 'JAVASCRIPT', 'desc' => 'DOM & Client Validation'],
    ['abbr' => 'Gt', 'name' => 'GIT & GITHUB', 'desc' => 'Version Control & Team Sync'],
    ['abbr' => 'Pr', 'name' => 'PUBLIC RELATION', 'desc' => 'Communication & Engagement'],
    ['abbr' => 'Vs', 'name' => 'VS CODE', 'desc' => 'Development Environment'],
];
?>
<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Personal Page <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars(MEMBER_NICKNAME, ENT_QUOTES, 'UTF-8') ?>) - Mahasiswa S1 Informatika Telkom University (<?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?>).">
    <title><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> // Gojo Satoru Edition // Personal Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,600&family=Dancing+Script:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=59">
</head>

<body>

    <!-- Watermark Background Gojo Satoru Halus -->
    <div class="bg-watermark-layer" aria-hidden="true"></div>

    <!-- Banner Identitas Node (`app/partials/served_by.php`) -->
    <?php require_once __DIR__ . '/app/partials/served_by.php'; ?>

    <!-- =====================================================================
         TOP NAVIGATION BAR
         ===================================================================== -->
    <header class="site-header" id="top">
        <div class="container header-inner">
            <!-- Kiri: Identitas Singkat Mahasiswa (Non-Redundan dengan Menu & Guestbook) -->
            <div class="header-left-icons">
                <a href="#top" class="sq-icon-btn sq-dark"
                    title="Identitas Mahasiswa: <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>"
                    aria-label="Identitas Mahasiswa">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
                <span class="sq-icon-btn sq-accent"
                    title="Node Aktif: <?= strtoupper(htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8')) ?> (<?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?>)"
                    style="font-family: var(--font-display); font-size: 0.78rem; font-weight: 800; letter-spacing: 0.04em; cursor: default;">
                    <?= strtoupper(htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8')) ?>
                </span>
                <button class="mobile-nav-toggle" id="mobileNavToggle" aria-expanded="false" aria-controls="primaryNav"
                    aria-label="Buka menu navigasi">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
            </div>

            <!-- Tengah: Menu Navigasi Ringkas (4 Bagian Utama) -->
            <nav class="site-nav" id="primaryNav" aria-label="Navigasi Utama">
                <ul class="nav-list">
                    <li><a href="#profil" class="nav-link active">Home</a></li>
                    <li><a href="#portofolio" class="nav-link">Projects</a></li>
                    <li><a href="#pendidikan" class="nav-link">Journey &amp; Tools</a></li>
                    <li><a href="#kontak" class="nav-link">Contact</a></li>
                </ul>
            </nav>

            <!-- Kanan: Tombol Outlined & Filled -->
            <div class="header-actions">
                <button type="button" id="themeToggleBtn" class="pill-btn pill-outline" aria-label="Ubah tema tampilan"
                    title="Ganti Mode Terang / Gelap">
                    <span id="themeLabel">Night Mode</span>
                </button>
                <a href="app/index.php" class="pill-btn pill-filled">
                    Guestbook
                </a>
            </div>
        </div>
    </header>

    <main>
        <!-- =================================================================
             BAGIAN ATAS: DASHBOARD GOJO SATORU
             ================================================================= -->
        <section id="profil" class="dashboard-showcase-section">
            <div class="container">

                <!-- 1. HERO BANNER LEBAR DENGAN KARAKTER GOJO KELUAR FRAME DI KANAN -->
                <div class="gojo-hero-banner">
                    <div class="gojo-banner-bg">
                        <div class="banner-soft-arc" aria-hidden="true"></div>
                        <div class="banner-sparkles" aria-hidden="true">
                            <span class="sp-dot d1"></span>
                            <span class="sp-dot d2"></span>
                            <span class="sp-dot d3"></span>
                            <span class="sp-dot d4"></span>
                            <span class="sp-dot d5"></span>
                            <span class="sp-dot d6"></span>
                            <span class="sp-dot d7"></span>
                            <span class="sp-dot d8"></span>
                            <span class="sp-dot d9"></span>
                            <span class="sp-dot d10"></span>
                            <span class="sp-dot d11"></span>
                            <span class="sp-dot d12"></span>
                        </div>

                        <div class="gojo-banner-content">
                            <div class="gojo-emblem-logo">
                                <span class="emblem-jp">五条悟</span>
                                <span class="emblem-sub">NODE //
                                    <?= strtoupper(htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8')) ?></span>
                            </div>

                            <h1 class="gojo-banner-title" id="bannerSlideTitle">
                                <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>
                            </h1>

                            <p class="gojo-banner-desc" id="bannerSlideDesc">
                                Halo, panggil aku
                                <strong><?= htmlspecialchars(MEMBER_NICKNAME, ENT_QUOTES, 'UTF-8') ?></strong>!
                                Mahasiswa S1 Informatika Telkom University
                                (<?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?> &bull; NIM
                                <?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?>) yang aktif di bidang teknologi
                                web, UI/UX, serta kolaborasi komunikasi &amp; komunitas.
                            </p>

                            <div class="gojo-banner-dots" role="tablist" aria-label="Slide Banner">
                                <button type="button" class="banner-dot active" data-slide="0"
                                    aria-label="Slide Profil"></button>
                                <button type="button" class="banner-dot" data-slide="1"
                                    aria-label="Slide Gojo Satoru"></button>
                            </div>
                        </div>
                    </div>

                    <div class="gojo-banner-char-wrap">
                        <span class="floating-heart heart-lg" aria-hidden="true">💜</span>
                        <span class="floating-heart heart-sm" aria-hidden="true">✦</span>
                        <img src="assets/img/foto_yury.jpeg"
                            alt="Foto Yuriko Astiani"
                            class="gojo-banner-char-img"
                            draggable="false">
                    </div>
                </div>

                <!-- 2. GRID 3 KOLOM DI BAWAH BANNER -->
                <div class="gojo-dashboard-grid">

                    <!-- KOLOM 1: Recent Search (Filter Langsung Selected Projects) -->
                    <div class="dash-col dash-col-search">
                        <div class="dash-heading-row">
                            <h2 class="dash-col-heading">Recent Search</h2>
                            <span class="search-sync-chip" id="activeSearchChip">All (04)</span>
                        </div>

                        <div class="recent-search-stack" role="tablist" aria-label="Filter dan Pratinjau Proyek">
                            <button type="button" class="search-pill-item tone-1" data-search-filter="web-app"
                                data-label="SuperKost">
                                <svg class="search-icon" viewBox="0 0 24 24" width="16" height="16" fill="none"
                                    stroke="currentColor" stroke-width="2.4">
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <line x1="20" y1="20" x2="16.2" y2="16.2"></line>
                                </svg>
                                <span class="pill-text">SuperKost Web App</span>
                                <span class="pill-tag">01</span>
                            </button>

                            <button type="button" class="search-pill-item tone-2" data-search-filter="ui-ux"
                                data-label="iGracias UI/UX">
                                <svg class="search-icon" viewBox="0 0 24 24" width="16" height="16" fill="none"
                                    stroke="currentColor" stroke-width="2.4">
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <line x1="20" y1="20" x2="16.2" y2="16.2"></line>
                                </svg>
                                <span class="pill-text">Redesain iGracias UI/UX</span>
                                <span class="pill-tag">02</span>
                            </button>

                            <button type="button" class="search-pill-item tone-3" data-search-filter="fintech"
                                data-label="FinSmart">
                                <svg class="search-icon" viewBox="0 0 24 24" width="16" height="16" fill="none"
                                    stroke="currentColor" stroke-width="2.4">
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <line x1="20" y1="20" x2="16.2" y2="16.2"></line>
                                </svg>
                                <span class="pill-text">FinSmart Finance 2025</span>
                                <span class="pill-tag">03</span>
                            </button>

                            <button type="button" class="search-pill-item tone-4" data-search-filter="env-web"
                                data-label="PoluSee">
                                <svg class="search-icon" viewBox="0 0 24 24" width="16" height="16" fill="none"
                                    stroke="currentColor" stroke-width="2.4">
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <line x1="20" y1="20" x2="16.2" y2="16.2"></line>
                                </svg>
                                <span class="pill-text">PoluSee Air Quality</span>
                                <span class="pill-tag">04</span>
                            </button>

                            <button type="button" class="search-pill-item tone-5 is-active" data-search-filter="all"
                                data-label="All (04)">
                                <svg class="search-icon" viewBox="0 0 24 24" width="16" height="16" fill="none"
                                    stroke="currentColor" stroke-width="2.4">
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <line x1="20" y1="20" x2="16.2" y2="16.2"></line>
                                </svg>
                                <span class="pill-text"><?= htmlspecialchars(MEMBER_NICKNAME, ENT_QUOTES, 'UTF-8') ?> //
                                    Semua Proyek</span>
                                <span class="pill-tag">ALL</span>
                            </button>
                        </div>
                    </div>

                    <!-- KOLOM 2: 2 Kartu Sticker Persegi -->
                    <div class="dash-col dash-col-stickers">
                        <div class="sticker-card-box">
                            <button type="button" class="sticker-close-badge badge-tone-1"
                                aria-label="Animasi karakter 1" title="Klik untuk interaksi">&times;</button>
                            <img src="assets/img/gojo-sticker-1.png?v=58" alt="Gojo Satoru Avatar 1"
                                class="sticker-square-img">
                        </div>

                        <div class="sticker-card-box">
                            <button type="button" class="sticker-close-badge badge-tone-2"
                                aria-label="Animasi karakter 2" title="Klik untuk interaksi">&times;</button>
                            <img src="assets/img/gojo-sticker-2.png?v=58" alt="Gojo Satoru Avatar 2"
                                class="sticker-square-img">
                        </div>
                    </div>

                    <!-- KOLOM 4: 3 Kartu Ringkasan Cepat (Navigasi Sekali Klik ke Masing-Masing Section) -->
                    <div class="dash-col dash-col-features">
                        <a href="#portofolio" class="feature-horiz-card">
                            <div class="feature-icon-wrap">
                                <span class="big-number-01">04</span>
                            </div>
                            <div class="feature-text-wrap">
                                <h3 class="feature-card-title">Selected Works</h3>
                                <p class="feature-card-desc">
                                    4 Proyek utama: SuperKost, Redesain iGracias, FinSmart, &amp; PoluSee.
                                </p>
                            </div>
                        </a>

                        <a href="#pendidikan" class="feature-horiz-card">
                            <div class="feature-icon-wrap">
                                <div class="circle-emblem-icon">
                                    <span>♾️</span>
                                </div>
                            </div>
                            <div class="feature-text-wrap">
                                <h3 class="feature-card-title">Journey &amp; PR</h3>
                                <p class="feature-card-desc">
                                    S1 Informatika (<?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?>),
                                    INTELECTA &amp; PR Hello World 2025.
                                </p>
                            </div>
                        </a>

                        <a href="#kontak" class="feature-horiz-card">
                            <div class="feature-icon-wrap">
                                <div class="spark-emblem-icon">
                                    <span>✦</span>
                                </div>
                            </div>
                            <div class="feature-text-wrap">
                                <h3 class="feature-card-title">Connect //
                                    <?= strtoupper(htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8')) ?></h3>
                                <p class="feature-card-desc">
                                    Terbuka untuk kolaborasi proyek web, UI/UX, &amp; kegiatan komunitas.
                                </p>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- =================================================================
             BAGIAN BAWAH: ARCHITECTURAL EDITORIAL GRID (SESUAI GAMBAR KEDUA)
             ================================================================= -->
        <div class="container editorial-monolith-wrap">
            <div class="editorial-monolith-sheet">

                <!-- ─────────────────────────────────────────────────────────
                     ROW 1: SELECTED PROJECTS ✦ (PORTOFOLIO PROYEK)
                     ───────────────────────────────────────────────────────── -->
                <section id="portofolio" class="ed-section ed-projects-section">
                    <div class="ed-topbar">
                        <div class="ed-topbar-left">
                            <span class="ed-label-title">SELECTED PROJECTS</span>
                            <span class="ed-star">✦</span>
                        </div>
                    </div>

                    <div class="ed-projects-grid" id="portfolioGrid">
                        <?php foreach ($portfolios as $proj): ?>
                            <article class="portfolio-card ed-project-cell"
                                data-category="<?= htmlspecialchars($proj['category'], ENT_QUOTES, 'UTF-8') ?>" tabindex="0"
                                role="button"
                                aria-label="Lihat rincian proyek <?= htmlspecialchars($proj['title'], ENT_QUOTES, 'UTF-8') ?>">

                                <!-- Hidden data for Modal Dialog -->
                                <span
                                    class="status-chip is-hidden"><?= htmlspecialchars($proj['status'], ENT_QUOTES, 'UTF-8') ?></span>
                                <p class="portfolio-summary is-hidden">
                                    <?= htmlspecialchars($proj['summary'], ENT_QUOTES, 'UTF-8') ?>
                                </p>
                                <ul class="portfolio-highlights is-hidden">
                                    <?php foreach ($proj['highlights'] as $hl): ?>
                                        <li><?= htmlspecialchars($hl, ENT_QUOTES, 'UTF-8') ?></li>
                                    <?php endforeach; ?>
                                </ul>

                                <div class="ed-proj-head">
                                    <span
                                        class="ed-proj-num"><?= htmlspecialchars($proj['id'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <div class="ed-proj-titles">
                                        <h3 class="portfolio-title ed-proj-name">
                                            <?= htmlspecialchars($proj['title'], ENT_QUOTES, 'UTF-8') ?>
                                        </h3>
                                        <p class="portfolio-subtitle ed-proj-sub">
                                            <?= htmlspecialchars($proj['subtitle'], ENT_QUOTES, 'UTF-8') ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="ed-proj-mockup">
                                    <div class="mockup-browser-bar">
                                        <span class="m-dot"></span><span class="m-dot"></span><span class="m-dot"></span>
                                        <span
                                            class="m-kicker"><?= htmlspecialchars($proj['preview_kicker'], ENT_QUOTES, 'UTF-8') ?></span>
                                    </div>

                                    <div class="mockup-Visual-stage">
                                        <div class="mockup-domain-glow" aria-hidden="true"></div>
                                        <div class="mockup-overlay-content">
                                            <p class="mockup-serif-headline">
                                                <?= nl2br(htmlspecialchars($proj['preview_headline'], ENT_QUOTES, 'UTF-8')) ?>
                                            </p>
                                            <span class="mockup-mini-cta">EXPLORE CASE &rarr;</span>
                                        </div>
                                        <div class="mockup-bottom-subcard">
                                            <span><?= htmlspecialchars($proj['title'], ENT_QUOTES, 'UTF-8') ?> //
                                                <?= htmlspecialchars($proj['year'], ENT_QUOTES, 'UTF-8') ?></span>
                                            <span><?= htmlspecialchars($proj['status'], ENT_QUOTES, 'UTF-8') ?> ✦</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="ed-proj-tags">
                                    <?php foreach ($proj['tags'] as $tag): ?>
                                        <span class="ed-rect-tag"><?= htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- ─────────────────────────────────────────────────────────
                     ROW 2: MY PROCESS & JOURNEY ✦ (KIRI) | TOOLS I USE ✦ (KANAN)
                     ───────────────────────────────────────────────────────── -->
                <section id="pendidikan" class="ed-section ed-split-process-tools">
                    <!-- KIRI: PENDIDIKAN & PENGALAMAN KEPANITIAAN YURY -->
                    <div class="ed-half-col ed-process-col">
                        <div class="ed-subhead">
                            <span class="ed-label-title">MY PROCESS &amp; JOURNEY</span>
                            <span class="ed-star">✦</span>
                        </div>

                        <div class="ed-process-inner">
                            <div class="ed-process-list">
                                <div class="ed-step-item">
                                    <span class="ed-step-num">01</span>
                                    <div class="ed-step-body">
                                        <h3 class="ed-step-title">S1 INFORMATIKA &mdash; TELKOM UNIVERSITY</h3>
                                        <p class="ed-step-desc">Kelas
                                            <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?> &bull; NIM
                                            <?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?>
                                            (2024&ndash;Sekarang). Mendalami rekayasa perangkat lunak, basis data, &amp;
                                            arsitektur web.
                                        </p>
                                    </div>
                                </div>

                                <div class="ed-step-item">
                                    <span class="ed-step-num">02</span>
                                    <div class="ed-step-body">
                                        <h3 class="ed-step-title">INTELECTA &mdash; COMMUNITY ENGAGEMENT</h3>
                                        <p class="ed-step-desc">Kepanitiaan INTELECTA Fakultas Informatika. Membangun
                                            keterlibatan komunitas, komunikasi interaktif, dan kolaborasi partisipatif.
                                        </p>
                                    </div>
                                </div>

                                <div class="ed-step-item">
                                    <span class="ed-step-num">03</span>
                                    <div class="ed-step-body">
                                        <h3 class="ed-step-title">HELLO WORLD 2025 &mdash; PUBLIC RELATION</h3>
                                        <p class="ed-step-desc">Divisi Public Relation Kepanitiaan Hello World 2025.
                                            Mengelola hubungan masyarakat, publikasi informasi, dan jembatan komunikasi
                                            acara.</p>
                                    </div>
                                </div>

                                <div class="ed-step-item">
                                    <span class="ed-step-num">04</span>
                                    <div class="ed-step-body">
                                        <h3 class="ed-step-title">DESIGN &amp; PROTOTYPE</h3>
                                        <p class="ed-step-desc">Merancang wireframe, tata letak responsif, dan prototipe
                                            UI/UX interaktif di Figma.</p>
                                    </div>
                                </div>

                                <div class="ed-step-item">
                                    <span class="ed-step-num">05</span>
                                    <div class="ed-step-body">
                                        <h3 class="ed-step-title">DEVELOP &amp; DELIVER</h3>
                                        <p class="ed-step-desc">Implementasi kode bersih dengan PHP Native 8.x, PDO
                                            anti-SQL Injection, Java OOP, dan pengujian menyeluruh.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Lingkaran Orbital Artistik Gojo + Kutipan Editorial (Tanpa Foto) -->
                            <div class="ed-orbital-showcase">
                                <div class="ed-orbital-ring">
                                    <span class="ed-orbital-emblem" aria-hidden="true">♾️</span>
                                    <span class="ed-orbital-kicker">UNLIMITED VOID // M4</span>
                                    <p class="ed-orbital-quote">
                                        A thoughtful<br>
                                        process for<br>
                                        meaningful<br>
                                        results.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KANAN: TOOLS I USE ✦ -->
                    <div id="keahlian" class="ed-half-col ed-tools-col">
                        <div class="ed-subhead">
                            <span class="ed-label-title">TOOLS I USE</span>
                            <span class="ed-star">✦</span>
                        </div>

                        <div class="ed-tools-grid">
                            <?php foreach ($tools as $tool): ?>
                                <div class="ed-tool-box"
                                    title="<?= htmlspecialchars($tool['desc'], ENT_QUOTES, 'UTF-8') ?>">
                                    <span
                                        class="ed-tool-monogram"><?= htmlspecialchars($tool['abbr'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <div class="ed-tool-info">
                                        <span
                                            class="ed-tool-name"><?= htmlspecialchars($tool['name'], ENT_QUOTES, 'UTF-8') ?></span>
                                        <span
                                            class="ed-tool-sub"><?= htmlspecialchars($tool['desc'], ENT_QUOTES, 'UTF-8') ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <p class="ed-tools-footer-note">
                            &amp; MORE GREAT TECHNOLOGIES // NODE
                            <?= strtoupper(htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8')) ?>
                        </p>
                    </div>
                </section>

                <!-- ─────────────────────────────────────────────────────────
                     ROW 3: LET'S CREATE SOMETHING AMAZING (KONTAK, CTA & FOOTER TERPADU)
                     ───────────────────────────────────────────────────────── -->
                <section id="kontak" class="ed-section ed-contact-footer-row">
                    <!-- Kolom 1: LET'S CREATE SOMETHING Amazing -->
                    <div class="ed-contact-col ed-col-amazing">
                        <h2 class="ed-create-heading">
                            <span>LET&rsquo;S CREATE</span>
                            <span>SOMETHING</span>
                        </h2>
                        <span class="ed-amazing-script">Amazing</span>
                    </div>

                    <!-- Kolom 2: I'M CURRENTLY OPEN FOR COLLABORATION -->
                    <div class="ed-contact-col ed-col-cta">
                        <h3 class="ed-open-title">
                            I&rsquo;M CURRENTLY OPEN<br>
                            FOR NEW PROJECTS
                        </h3>
                        <p class="ed-open-desc">
                            Mari terhubung bersama <?= htmlspecialchars(MEMBER_NICKNAME, ENT_QUOTES, 'UTF-8') ?> untuk
                            kolaborasi proyek web maupun kegiatan kampus.
                        </p>
                        <a href="app/index.php" class="ed-send-msg-btn">
                            <span>OPEN GUESTBOOK</span>
                            <span class="ed-star">✦</span>
                        </a>
                    </div>

                    <!-- Kolom 3: 3 Baris Kontak & Navigasi Cepat -->
                    <div class="ed-contact-col ed-col-links">
                        <a href="mailto:yurikoastiani@gmail.com" class="ed-contact-line">
                            <span class="ed-c-icon">&#9993;</span>
                            <span>YURIKOASTIANI@GMAIL.COM</span>
                        </a>
                        <div class="ed-contact-line">
                            <span class="ed-c-icon">&#9672;</span>
                            <span><?= strtoupper(htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8')) ?> //
                                <?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <a href="#top" class="ed-contact-line">
                            <span class="ed-c-icon">&uarr;</span>
                            <span>BACK TO TOP // <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?> (NODE
                                <?= strtoupper(htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8')) ?>)</span>
                        </a>
                    </div>
                </section>

            </div>
        </div>
    </main>

    <!-- Modal Dialog Detail Portofolio -->
    <div class="modal-backdrop" id="projectModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-dialog">
            <button type="button" class="modal-close-btn" id="modalCloseBtn" aria-label="Tutup jendela">&times;</button>
            <div class="card-top-bar">
                <span class="mono-label">PROJECT SPECIFICATION</span>
                <span class="status-chip" id="modalStatus">STATUS</span>
            </div>
            <h3 class="portfolio-title" id="modalTitle" style="margin-top: 0.4rem;">Judul Proyek</h3>
            <p class="portfolio-subtitle" id="modalSubtitle" style="margin-bottom: 0.9rem;">Subjudul Proyek</p>
            <p class="portfolio-summary" id="modalSummary" style="margin-bottom: 1.1rem;"></p>

            <h4 class="modal-sec-label">Fitur Utama:</h4>
            <ul class="spec-bullet-list" id="modalHighlights" style="margin-bottom: 1.2rem;"></ul>

            <h4 class="modal-sec-label">Teknologi:</h4>
            <div class="tag-row" id="modalTags"></div>
        </div>
    </div>

    <script src="assets/js/main.js?v=59"></script>
</body>

</html>
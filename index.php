<?php
declare(strict_types=1);

/**
 * Halaman Utama Personal Page (Root `index.php`)
 * Mahasiswa : Dini Nadia Mawaddah - 103012430028
 * Kelas     : S1 Informatika Telkom University (IF-48-05)
 */

require_once __DIR__ . '/identity.php';

$skills = [
    [
        'name'     => 'PHP & MySQL (Backend)',
        'category' => 'Web Backend & Database',
        'level'    => 'Advanced',
        'desc'     => 'Pemrograman backend terstruktur dengan PHP 8 Native, integrasi PDO Prepared Statements anti-SQL injection, dan manajemen basis data relasional.',
        'code'     => 'PH-01',
    ],
    [
        'name'     => 'Java (OOP Architecture)',
        'category' => 'Object-Oriented Programming',
        'level'    => 'Advanced',
        'desc'     => 'Penerapan prinsip OOP (Inheritance, Polymorphism, Encapsulation, Abstraction), struktur data linier, dan pemodelan arsitektur MVC.',
        'code'     => 'JV-02',
    ],
    [
        'name'     => 'Frontend UI (HTML5 & CSS3)',
        'category' => 'Responsive UI Engineering',
        'level'    => 'Advanced',
        'desc'     => 'Markup semantik ramah aksesibilitas, layout modern menggunakan Flexbox & CSS Grid, serta implementasi sistem tema Stealth Dark / Harbor Light.',
        'code'     => 'FE-03',
    ],
    [
        'name'     => 'JavaScript (Vanilla)',
        'category' => 'Client-Side Scripting',
        'level'    => 'Intermediate',
        'desc'     => 'Manipulasi DOM reaktif, filter data portofolio, modal interaktif, validasi formulir sisi klien, dan penanganan event berbasis asynchronous.',
        'code'     => 'JS-04',
    ],
    [
        'name'     => 'Git & GitHub Collaboration',
        'category' => 'Version Control System',
        'level'    => 'Intermediate',
        'desc'     => 'Manajemen source code kolaboratif, branch workflow terisolasi, commit terstruktur, dan integrasi repositori bersama tim.',
        'code'     => 'GT-05',
    ],
    [
        'name'     => 'Event & Team Coordination',
        'category' => 'Leadership & Organization',
        'level'    => 'Competent',
        'desc'     => 'Pengalaman kepanitiaan aktif pada INTELECTA (Informatics Intellectual Arena) dalam manajemen acara, komunikasi tim, dan alur teknis kegiatan.',
        'code'     => 'ORG-06',
    ],
];

$portfolios = [
    [
        'id'       => 'PRJ-01',
        'title'    => 'MediCare Portal',
        'subtitle' => 'Sistem Reservasi & Antrean Layanan Kesehatan Terpadu',
        'category' => 'backend',
        'tags'     => ['PHP 8 Native', 'MySQL (PDO)', 'Responsive CSS', 'Clean Architecture'],
        'year'     => '2025',
        'status'   => 'PRODUCTION READY',
        'summary'  => 'Aplikasi web manajemen klinik yang memfasilitasi pendaftaran pasien, penjadwalan dokter secara real-time, pencatatan histori layanan medis, serta verifikasi data berbasis role-based access.',
        'highlights' => [
            'Autentikasi role-based untuk Admin, Tenaga Medis, dan Pasien',
            'Implementasi PDO Prepared Statements untuk pencegahan SQL Injection menyeluruh',
            'Antarmuka adaptif yang responsif pada layar desktop maupun smartphone',
        ],
    ],
    [
        'id'       => 'PRJ-02',
        'title'    => 'SmartInventory Core',
        'subtitle' => 'Sistem Manajemen Pergudangan & Pelacakan Stok Aset',
        'category' => 'java-app',
        'tags'     => ['Java 17', 'OOP Architecture', 'MySQL', 'Desktop UI'],
        'year'     => '2025',
        'status'   => 'COMPLETED',
        'summary'  => 'Perangkat lunak enterprise untuk pengelolaan logistik pergudangan yang dilengkapi fitur pelacakan otomatis pergerakan stok, verifikasi batas minimum barang, serta pelaporan transaksi inventaris.',
        'highlights' => [
            'Penerapan konsep OOP murni dengan arsitektur berlapis yang rapi',
            'Integritas data transaksi ACID untuk menghindari anomali kuantitas stok',
            'Modul pencarian cepat dan penyaringan data inventaris multi-kriteria',
        ],
    ],
    [
        'id'       => 'PRJ-03',
        'title'    => 'Intelecta Event System',
        'subtitle' => 'Web Portal Informasi & Pendaftaran Peserta INTELECTA',
        'category' => 'event-web',
        'tags'     => ['HTML5 Semantic', 'Custom CSS', 'JavaScript', 'PHP Backend'],
        'year'     => '2025',
        'status'   => 'ACTIVE RELEASE',
        'summary'  => 'Platform web resmi kepanitiaan INTELECTA (Informatics Intellectual Arena) untuk menyajikan jadwal perlombaan, panduan teknis, pendaftaran delegasi peserta lomba, dan pengumuman tahap kompetisi.',
        'highlights' => [
            'Portal registrasi digital terintegrasi untuk peserta kompetisi informatika',
            'Tampilan jadwal dan lini masa perlombaan interaktif yang informatif',
            'Dukungan koordinasi divisi acara dan sekretariat dalam verifikasi berkas',
        ],
    ],
    [
        'id'       => 'PRJ-04',
        'title'    => 'Distributed Guestbook Node',
        'subtitle' => 'Aplikasi Buku Tamu Terdistribusi Multi-Node (m0 - m5)',
        'category' => 'fullstack',
        'tags'     => ['PHP 8 PDO', 'MySQL Server', 'Vanilla JS', 'Harbor Grey UI'],
        'year'     => '2026',
        'status'   => 'PRA-UTS COMPONENT',
        'summary'  => 'Node aplikasi bersama pra-UTS yang menghubungkan personal page ke sistem buku tamu terpusat dengan filter route mahasiswa, paginasi dinamis, dan validasi sisi klien & server.',
        'highlights' => [
            'Berfungsi sebagai node pelayan lokal terverifikasi (Node m3)',
            'Mendukung mode standalone maupun mode embed iframe di halaman utama',
            'Validasi karakter ganda serta pencegahan XSS dengan htmlspecialchars',
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Personal Page <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> - Mahasiswa S1 Informatika Telkom University (<?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?>) & Aplikasi Bersama Guestbook.">
    <title><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> // Personal Page &amp; Guestbook</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Banner Identitas Wajib di Bagian Paling Atas (served_by.php) -->
    <?php require_once __DIR__ . '/app/partials/served_by.php'; ?>

    <!-- Header & Navigasi Semantik HTML5 -->
    <header class="site-header" id="top">
        <div class="container header-inner">
            <a href="#profil" class="brand-logo" aria-label="Beranda <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>">
                <span class="brand-bracket">[</span><?= htmlspecialchars(strtoupper(MEMBER_NICKNAME), ENT_QUOTES, 'UTF-8') ?><span class="brand-accent">//</span><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?><span class="brand-bracket">]</span>
            </a>

            <button class="mobile-nav-toggle" id="mobileNavToggle" aria-expanded="false" aria-controls="primaryNav" aria-label="Buka menu navigasi">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <nav class="site-nav" id="primaryNav" aria-label="Navigasi Utama">
                <ul class="nav-list">
                    <li><a href="#profil" class="nav-link active">01. Profil</a></li>
                    <li><a href="#pendidikan" class="nav-link">02. Pendidikan &amp; Organisasi</a></li>
                    <li><a href="#keahlian" class="nav-link">03. Keahlian</a></li>
                    <li><a href="#portofolio" class="nav-link">04. Portofolio</a></li>
                    <li><a href="#aplikasi" class="nav-link">05. Aplikasi</a></li>
                    <li><a href="#kontak" class="nav-link">06. Kontak</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <button type="button" id="themeToggleBtn" class="btn btn-icon" aria-label="Ubah mode kontras tampilan" title="Toggle Harbor Contrast Theme">
                    <span class="theme-indicator-dot"></span>
                    <span class="mono-small" id="themeLabel">STEALTH DARK</span>
                </button>
                <a href="app/index.php" class="btn btn-primary btn-sm">Buka Guestbook &nearr;</a>
            </div>
        </div>
    </header>

    <main>
        <!-- SECTION 1: PROFIL (HERO SECTION) -->
        <section id="profil" class="hero-section section-block">
            <div class="container hero-grid">
                <div class="hero-content">
                    <div class="spec-pill-row">
                        <span class="spec-pill">NODE // <?= htmlspecialchars(strtoupper(MEMBER_ROUTE), ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="spec-pill">NIM // <?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="spec-pill">CLASS // <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>

                    <h1 class="hero-title">
                        <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>
                        <span class="hero-alias">CALLSIGN &ldquo;<?= htmlspecialchars(strtoupper(MEMBER_NICKNAME), ENT_QUOTES, 'UTF-8') ?>&rdquo;</span>
                    </h1>

                    <p class="hero-lead">
                        Mahasiswa <strong><?= htmlspecialchars(MEMBER_PRODI, ENT_QUOTES, 'UTF-8') ?></strong> kelas <strong><?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?></strong> dan panitia aktif pada kepanitiaan <strong>INTELECTA</strong>. Berfokus pada perancangan rekayasa perangkat lunak modern, basis data relasional terstruktur, serta eksplorasi antarmuka web yang intuitif, aman, dan responsif.
                    </p>

                    <div class="hero-cta-group">
                        <a href="#portofolio" class="btn btn-primary">
                            <span>Lihat Portofolio</span>
                            <span class="btn-arrow">&rarr;</span>
                        </a>
                        <a href="#aplikasi" class="btn btn-outline">
                            <span>Isi Buku Tamu Bersama</span>
                        </a>
                        <a href="app/index.php" class="btn btn-ghost">
                            <span>Halaman Penuh Guestbook &nearr;</span>
                        </a>
                    </div>

                    <div class="telemetry-strip" aria-label="Ringkasan Akademik dan Proyek">
                        <div class="telemetry-item">
                            <span class="telemetry-val"><?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?></span>
                            <span class="telemetry-lbl">KELAS AKTIF</span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-val">INTELECTA</span>
                            <span class="telemetry-lbl">KEPANITIAAN</span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-val">04 APPS</span>
                            <span class="telemetry-lbl">PORTOFOLIO UTAMA</span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-val">NODE <?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></span>
                            <span class="telemetry-lbl">STATUS SERVER</span>
                        </div>
                    </div>
                </div>

                <!-- Kartu Identitas Teknis (Techwear ID Tag) -->
                <aside class="hero-id-card tech-card" aria-label="Kartu Identitas Mahasiswa">
                    <div class="card-top-bar">
                        <span class="mono-label">ID_BADGE // TELKOM_UNIV</span>
                        <span class="status-chip">VERIFIED</span>
                    </div>

                    <div class="id-avatar-box">
                        <img src="assets/img/avatar.png" alt="Avatar <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>" class="avatar-img" width="64" height="64" onerror="this.style.display='none'; document.getElementById('avatarFallback').style.display='flex';">
                        <div class="avatar-monogram" id="avatarFallback" style="display: none;" aria-hidden="true">DNM</div>
                        <div class="avatar-meta">
                            <span class="mono-small">CALLSIGN: <?= htmlspecialchars(strtoupper(MEMBER_NICKNAME), ENT_QUOTES, 'UTF-8') ?></span>
                            <span class="mono-small">DIVISI: KEPANITIAAN INTELECTA</span>
                            <span class="mono-small">SECTOR: BANDUNG, ID</span>
                        </div>
                    </div>

                    <dl class="id-spec-list">
                        <div class="spec-row">
                            <dt>NAMA LENGKAP</dt>
                            <dd><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div class="spec-row">
                            <dt>NIM</dt>
                            <dd class="mono-val"><?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div class="spec-row">
                            <dt>PROGRAM STUDI</dt>
                            <dd>S1 Informatika</dd>
                        </div>
                        <div class="spec-row">
                            <dt>INSTITUSI</dt>
                            <dd>Telkom University</dd>
                        </div>
                        <div class="spec-row">
                            <dt>KELAS</dt>
                            <dd class="mono-val"><?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div class="spec-row">
                            <dt>NODE ROUTE</dt>
                            <dd class="mono-val"><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?> (Anggota)</dd>
                        </div>
                    </dl>

                    <div class="id-barcode" aria-hidden="true">
                        <span>||| || |||| | ||| |||| || | |||| ||| || | ||||</span>
                        <span class="mono-small"><?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?>-IF4805-<?= htmlspecialchars(strtoupper(MEMBER_ROUTE), ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </aside>
            </div>
        </section>

        <!-- SECTION 2: PENDIDIKAN & KEPANITIAAN -->
        <section id="pendidikan" class="section-block section-alt">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">02 // ACADEMIC &amp; COMMITTEE EXPERIENCE</span>
                    <h2 class="section-title">Pendidikan &amp; Kepanitiaan</h2>
                    <p class="section-subtitle">
                        Perjalanan studi di Program Studi S1 Informatika Telkom University serta keterlibatan aktif dalam kepanitiaan INTELECTA.
                    </p>
                </div>

                <div class="timeline-grid">
                    <!-- Card Pendidikan -->
                    <article class="tech-card timeline-card">
                        <div class="card-top-bar">
                            <span class="mono-label">EDU // UNDERGRADUATE</span>
                            <span class="badge-route">2024 &mdash; SEKARANG</span>
                        </div>
                        <h3 class="card-heading">S1 Informatika &mdash; Telkom University</h3>
                        <p class="card-sub">Kelas <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?> &bull; Bandung, Jawa Barat</p>
                        <p class="card-desc">
                            Menempuh pendidikan sarjana informatika dengan fokus pemahaman algoritma dan struktur data, pemrograman berorientasi objek menggunakan Java, arsitektur basis data relasional MySQL, jaringan komputer, dan rekayasa web modern.
                        </p>
                        <ul class="spec-bullet-list">
                            <li>Anggota Node <code><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></code> pada Proyek Kolaborasi Aplikasi Bersama Guestbook Pra-UTS.</li>
                            <li>Mengembangkan berbagai aplikasi web dan sistem desktop dengan standar clean code dan keamanan data.</li>
                        </ul>
                    </article>

                    <!-- Card Kepanitiaan INTELECTA -->
                    <article class="tech-card timeline-card highlight-border">
                        <div class="card-top-bar">
                            <span class="mono-label">COMMITTEE // INTELECTA</span>
                            <span class="badge-route">ACTIVE MEMBER</span>
                        </div>
                        <h3 class="card-heading">Kepanitiaan INTELECTA</h3>
                        <p class="card-sub">Informatics Intellectual Arena &bull; Fakultas Informatika</p>
                        <p class="card-desc">
                            Berperan aktif dalam kepanitiaan <strong>INTELECTA</strong>, agenda perlombaan dan festival teknologi tahunan mahasiswa Informatika yang menguji wawasan komputasi, kreativitas, dan inovasi digital.
                        </p>
                        <ul class="spec-bullet-list">
                            <li>Terlibat dalam koordinasi alur operasional acara, manajemen teknis kompetisi, dan briefing peserta.</li>
                            <li>Bekerja sama lintas divisi untuk memastikan kelancaran logistik, administrasi, dan registrasi digital delegasi.</li>
                            <li>Melatih kapabilitas pemecahan masalah (problem-solving), kepemimpinan tim, serta komunikasi interpersonal.</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <!-- SECTION 3: KEAHLIAN (SKILLS) -->
        <section id="keahlian" class="section-block">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">03 // TECHNICAL ARSENAL</span>
                    <h2 class="section-title">Keahlian &amp; Kompetensi</h2>
                    <p class="section-subtitle">
                        Tumpukan teknologi dan keahlian teknis yang saya kuasai dalam rekayasa backend, perancangan antarmuka, basis data, dan kolaborasi tim.
                    </p>
                </div>

                <div class="skills-grid">
                    <?php foreach ($skills as $skill): ?>
                        <article class="tech-card skill-card">
                            <div class="card-top-bar">
                                <span class="mono-label"><?= htmlspecialchars($skill['code'], ENT_QUOTES, 'UTF-8') ?> // <?= htmlspecialchars($skill['category'], ENT_QUOTES, 'UTF-8') ?></span>
                                <span class="skill-level"><?= htmlspecialchars($skill['level'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <h3 class="skill-title"><?= htmlspecialchars($skill['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="skill-desc"><?= htmlspecialchars($skill['desc'], ENT_QUOTES, 'UTF-8') ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- SECTION 4: PORTOFOLIO PROYEK -->
        <section id="portofolio" class="section-block section-alt">
            <div class="container">
                <div class="section-header-flex">
                    <div>
                        <span class="section-tag">04 // SELECTED PROJECTS</span>
                        <h2 class="section-title">Portofolio Proyek</h2>
                        <p class="section-subtitle">
                            Koleksi karya proyek perangkat lunak pilihan. Klik kartu untuk melihat ringkasan detail.
                        </p>
                    </div>

                    <!-- Filter Interaktif via assets/js/main.js -->
                    <div class="portfolio-filters" role="group" aria-label="Filter kategori portofolio">
                        <button type="button" class="filter-btn active" data-filter="all">Semua (4)</button>
                        <button type="button" class="filter-btn" data-filter="backend">PHP &amp; MySQL</button>
                        <button type="button" class="filter-btn" data-filter="java-app">Java OOP</button>
                        <button type="button" class="filter-btn" data-filter="event-web">Intelecta</button>
                        <button type="button" class="filter-btn" data-filter="fullstack">Guestbook Node</button>
                    </div>
                </div>

                <div class="portfolio-grid" id="portfolioGrid">
                    <?php foreach ($portfolios as $proj): ?>
                        <article class="tech-card portfolio-card" data-category="<?= htmlspecialchars($proj['category'], ENT_QUOTES, 'UTF-8') ?>" tabindex="0" role="button" aria-label="Lihat detail proyek <?= htmlspecialchars($proj['title'], ENT_QUOTES, 'UTF-8') ?>">
                            <div class="card-top-bar">
                                <span class="mono-label"><?= htmlspecialchars($proj['id'], ENT_QUOTES, 'UTF-8') ?> // <?= htmlspecialchars($proj['year'], ENT_QUOTES, 'UTF-8') ?></span>
                                <span class="status-chip"><?= htmlspecialchars($proj['status'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>

                            <h3 class="portfolio-title"><?= htmlspecialchars($proj['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="portfolio-subtitle"><?= htmlspecialchars($proj['subtitle'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="portfolio-summary"><?= htmlspecialchars($proj['summary'], ENT_QUOTES, 'UTF-8') ?></p>

                            <ul class="spec-bullet-list portfolio-highlights">
                                <?php foreach ($proj['highlights'] as $hl): ?>
                                    <li><?= htmlspecialchars($hl, ENT_QUOTES, 'UTF-8') ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="tag-row">
                                <?php foreach ($proj['tags'] as $tag): ?>
                                    <span class="tech-tag"><?= htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') ?></span>
                                <?php endforeach; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- SECTION 5: APLIKASI BERSAMA (GUESTBOOK EMBED & RINGKASAN) -->
        <section id="aplikasi" class="section-block">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">05 // SHARED APPLICATION</span>
                    <h2 class="section-title">Aplikasi Bersama &mdash; Guestbook Kelompok</h2>
                    <p class="section-subtitle">
                        Aplikasi buku tamu terdistribusi yang terhubung ke basis data terpusat <code>kelompok_db</code>. Anda dapat menuliskan pesan secara langsung melalui form tersemat di bawah ini, atau membuka tautan langsung ke <a href="app/index.php" class="inline-link">halaman mandiri aplikasi (app/) &nearr;</a>.
                    </p>
                </div>

                <div class="app-embed-card">
                    <div class="app-embed-topbar">
                        <div class="topbar-left">
                            <span class="mono-label">LIVE_EMBED // app/index.php</span>
                            <span class="route-badge">NODE <?= htmlspecialchars(strtoupper(MEMBER_ROUTE), ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <div class="topbar-right">
                            <a href="app/index.php" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">Buka di Tab Baru &nearr;</a>
                        </div>
                    </div>
                    <div class="app-embed-wrapper">
                        <iframe src="app/index.php?embed=1" title="Aplikasi Bersama — Guestbook Kelompok Terdistribusi" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 6: KONTAK -->
        <section id="kontak" class="section-block section-alt">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">06 // COMMUNICATION &amp; NETWORK</span>
                    <h2 class="section-title">Kontak &amp; Jejaring Profesional</h2>
                    <p class="section-subtitle">
                        Terbuka untuk diskusi kolaborasi proyek informatika, kegiatan kepanitiaan kampus, serta jejaring profesional. Sesuai kebijakan keamanan privasi, nomor kontak telepon tidak dipublikasikan secara terbuka.
                    </p>
                </div>

                <div class="contact-grid">
                    <a href="mailto:dininadia2005@gmail.com" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">CHANNEL // 01</span>
                            <span class="contact-arrow">&nearr;</span>
                        </div>
                        <h3 class="contact-title">Email Resmi</h3>
                        <p class="contact-handle">dininadia2005@gmail.com</p>
                        <span class="contact-hint">Kirim pesan via surat elektronik</span>
                    </a>

                    <a href="https://github.com/DiniNadia13" target="_blank" rel="noopener noreferrer" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">CHANNEL // 02</span>
                            <span class="contact-arrow">&nearr;</span>
                        </div>
                        <h3 class="contact-title">GitHub Repository</h3>
                        <p class="contact-handle">github.com/DiniNadia13</p>
                        <span class="contact-hint">Eksplorasi repositori kode &amp; proyek</span>
                    </a>

                    <a href="https://www.linkedin.com/in/dini-nadia-mawaddah-098132405/" target="_blank" rel="noopener noreferrer" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">CHANNEL // 03</span>
                            <span class="contact-arrow">&nearr;</span>
                        </div>
                        <h3 class="contact-title">LinkedIn Profile</h3>
                        <p class="contact-handle">linkedin.com/in/dini-nadia-mawaddah</p>
                        <span class="contact-hint">Jejaring profesional dan rekam jejak</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Dialog Interaktif Portofolio -->
    <div class="modal-backdrop" id="projectModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-dialog">
            <button type="button" class="modal-close-btn" id="modalCloseBtn" aria-label="Tutup jendela rincian proyek">&times;</button>
            <div class="card-top-bar">
                <span class="mono-label">DETAIL // PROYEK</span>
                <span class="status-chip" id="modalStatus">STATUS</span>
            </div>
            <h3 class="portfolio-title" id="modalTitle" style="margin-top: 0.5rem;">Judul Proyek</h3>
            <p class="portfolio-subtitle" id="modalSubtitle" style="margin-bottom: 1rem; color: var(--accent-lime);">Subjudul Proyek</p>
            <p class="portfolio-summary" id="modalSummary" style="margin-bottom: 1rem;"></p>
            
            <h4 style="font-size: 0.95rem; font-family: var(--font-mono); margin-bottom: 0.5rem; color: var(--text-primary);">HIGHLIGHT FITUR:</h4>
            <ul class="spec-bullet-list" id="modalHighlights" style="margin-bottom: 1.25rem;"></ul>

            <h4 style="font-size: 0.95rem; font-family: var(--font-mono); margin-bottom: 0.5rem; color: var(--text-primary);">TEKNOLOGI:</h4>
            <div class="tag-row" id="modalTags"></div>
        </div>
    </div>

    <!-- Footer Semantik HTML5 -->
    <footer class="site-footer">
        <div class="container footer-inner">
            <div class="footer-brand">
                <span class="mono-small"><strong><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></strong> (<?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?>)</span>
                <span class="mono-small">S1 Informatika Telkom University &bull; Kelas <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?> &bull; Panitia INTELECTA</span>
            </div>
            <div class="footer-links">
                <a href="#top" class="mono-small">BACK_TO_TOP &uarr;</a>
                <a href="app/index.php" class="mono-small">GUESTBOOK_APP &nearr;</a>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>

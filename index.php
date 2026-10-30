<?php
declare(strict_types=1);

/**
 * Halaman Utama Personal Page (Root `personal/index.php`)
 * Mahasiswa : Zulfa Almajid Basyaasyah (Babas) - 103012400134
 * Kelas     : S1 Informatika Telkom University (IF-48-05)
 * Minat     : Big Data & Machine Learning (MBC Laboratory Aspirant)
 */

require_once __DIR__ . '/identity.php';

$skills = [
    [
        'name'     => 'Go (Golang)',
        'category' => 'Programming Language',
        'level'    => 'Academic & Personal Projects',
        'desc'     => 'Pengembangan aplikasi CLI berbasis CRUD, manipulasi struktur data, implementasi algoritma pencarian (sequential & binary) serta pengurutan data (insertion & selection).',
        'code'     => 'GO-01',
    ],
    [
        'name'     => 'SQL & Relational DB',
        'category' => 'Database Engineering',
        'level'    => 'Academic & Personal Projects',
        'desc'     => 'Perancangan skema database relasional (customers, vehicles, transactions), integritas data (foreign keys & constraints), optimasi query, dan MySQL Workbench.',
        'code'     => 'SQL-02',
    ],
    [
        'name'     => 'Big Data & Machine Learning',
        'category' => 'Fields of Interest',
        'level'    => 'Research Exploration',
        'desc'     => 'Minat komputasi mendalam pada pemrosesan Big Data, analisis statistik, dan model Machine Learning. Beraspirasi bergabung dalam riset MBC Laboratory.',
        'code'     => 'AI-03',
    ],
    [
        'name'     => 'Git, VS Code & MySQL Workbench',
        'category' => 'Tools & Platforms',
        'level'    => 'Daily Workflow',
        'desc'     => 'Version control terdistribusi Git/GitHub, perancangan skema visual EER di MySQL Workbench, serta ekosistem code editing efisien berbasis VS Code.',
        'code'     => 'TL-04',
    ],
    [
        'name'     => 'Ms. Excel (Statistics) & Productivity',
        'category' => 'Data Analytics & Collaboration',
        'level'    => 'Applied Analytics',
        'desc'     => 'Pengolahan dan pemodelan statistik kuantitatif menggunakan Ms. Excel (Excel Skills for Statistics), utilisasi cerdas ChatGPT, dan koordinasi Ms. Teams.',
        'code'     => 'EX-05',
    ],
    [
        'name'     => 'Adobe Photoshop & Premiere Pro',
        'category' => 'Creative & Media',
        'level'    => 'Media & Publication',
        'desc'     => 'Desain grafis materi kehumasan (flyer/banner) menggunakan Photoshop serta editing dokumentasi video kegiatan kepanitiaan via Premiere Pro.',
        'code'     => 'MD-06',
    ],
];

$portfolios = [
    [
        'id'       => 'PRJ-01',
        'title'    => 'Inventory Management APP – GO',
        'subtitle' => 'CLI-Based Food Stock CRUD & Algorithmic Monitoring',
        'category' => 'go',
        'tags'     => ['Go (Golang)', 'CLI CRUD', 'Sequential & Binary Search', 'Insertion & Selection Sort'],
        'year'     => 'Apr – Mei 2025',
        'status'   => 'ACADEMIC PROJECT',
        'summary'  => 'Aplikasi Command Line Interface (CLI) berbasis CRUD (Create, Read, Update, Delete) untuk mencatat dan memantau stok bahan makanan dengan implementasi algoritma pencarian dan pengurutan data.',
        'highlights' => [
            'Pencatatan dan pemantauan stok bahan makanan dinamis berbasis CLI',
            'Fitur pencarian data menggunakan algoritma Sequential Search dan Binary Search',
            'Fitur pengurutan data menggunakan algoritma Insertion Sort dan Selection Sort',
        ],
    ],
    [
        'id'       => 'PRJ-02',
        'title'    => 'Rental Uhuuy – SQL Database',
        'subtitle' => 'Relational Database System for Vehicle Rental Service',
        'category' => 'sql',
        'tags'     => ['SQL', 'Relational Database', 'MySQL Workbench', 'Data Integrity', 'Schema Design'],
        'year'     => 'Jan – Mei 2025',
        'status'   => 'ACADEMIC PROJECT',
        'summary'  => 'Perancangan dan implementasi sistem basis data relasional komprehensif untuk layanan persewaan kendaraan "Rental Uhuuy", mencakup entitas pelanggan, armada kendaraan, transaksi, dan histori rental.',
        'highlights' => [
            'Perancangan tabel relasional untuk customers, vehicles, transactions, dan rental history',
            'Penegakan integritas data ketat, foreign key constraints, dan relasi multi-entitas',
            'Optimalisasi query SQL terstruktur untuk pelaporan transaksi dan manajemen relasi entitas',
        ],
    ],
    [
        'id'       => 'PRJ-03',
        'title'    => 'Personal Page & Guestbook',
        'subtitle' => 'Distributed Academic Web Node & Multi-Node Guestbook',
        'category' => 'web',
        'tags'     => ['PHP 8 Native', 'MySQL / PDO', 'Semantic HTML5', 'Vanilla JS', 'Dark Techwear'],
        'year'     => '2026',
        'status'   => 'PRODUCTION READY',
        'summary'  => 'Sistem laman profil pribadi terdistribusi dan aplikasi buku tamu (Guestbook) berbasis PHP Native 8.x dan MariaDB/MySQL PDO untuk proyek kelompok Pra-UTS S1 Informatika Telkom University.',
        'highlights' => [
            'Koneksi basis data PDO Prepared Statements aman terhadap SQL Injection dan sanitasi XSS',
            'Banner interkoneksi terdistribusi via served_by.php untuk node m0 (Ketua Kelompok)',
            'Paginasi dinamis (5 entri/halaman) serta validasi input ganda di sisi klien dan server',
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Personal Page <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars(MEMBER_NICKNAME, ENT_QUOTES, 'UTF-8') ?>) - Mahasiswa <?= htmlspecialchars(MEMBER_PRODI, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?>), Minat Big Data & Machine Learning, Aspiran MBC Laboratory.">
    <title><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars(MEMBER_NICKNAME, ENT_QUOTES, 'UTF-8') ?>) // Personal Page &amp; Guestbook</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Banner Identitas Wajib di Bagian Paling Atas -->
    <?php require_once __DIR__ . '/app/partials/served_by.php'; ?>
    <!-- Header & Navigasi Semantic HTML5 -->
    <header class="site-header" id="top">
        <div class="container header-inner">
            <a href="#profil" class="brand-logo" aria-label="Beranda <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>">
                <span class="brand-bracket">[</span><?= htmlspecialchars(mb_strtoupper(MEMBER_NICKNAME), ENT_QUOTES, 'UTF-8') ?><span class="brand-accent">//</span><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?><span class="brand-bracket">]</span>
            </a>

            <button class="mobile-nav-toggle" id="mobileNavToggle" aria-expanded="false" aria-controls="primaryNav" aria-label="Buka menu navigasi">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <nav class="site-nav" id="primaryNav" aria-label="Navigasi Utama">
                <ul class="nav-list">
                    <li><a href="#profil" class="nav-link active">01. Profil</a></li>
                    <li><a href="#pendidikan" class="nav-link">02. Pengalaman</a></li>
                    <li><a href="#keahlian" class="nav-link">03. Keahlian</a></li>
                    <li><a href="#portofolio" class="nav-link">04. Portofolio</a></li>
                    <li><a href="#guestbook" class="nav-link">05. Guestbook</a></li>
                    <li><a href="#kontak" class="nav-link">06. Kontak</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <button type="button" id="themeToggleBtn" class="btn btn-icon" aria-label="Ubah mode kontras tampilan" title="Toggle Harbor Contrast Theme">
                    <span class="theme-indicator-dot"></span>
                    <span class="mono-small" id="themeLabel">STEALTH DARK</span>
                </button>
                <a href="#guestbook" class="btn btn-primary btn-sm">Guestbook Node &darr;</a>
            </div>
        </div>
    </header>

    <main>
        <!-- SECTION 1: PROFIL (HERO ID BADGE EXPANDED) -->
        <section id="profil" class="hero-section section-block">
            <div class="container">
                <!-- Kartu Identitas Teknis (Techwear ID Tag - Full Width Showcase) -->
                <aside class="hero-id-card tech-card id-badge-expanded" aria-label="Kartu Identitas Mahasiswa">
                    <div class="card-top-bar">
                        <span class="mono-label">ID_BADGE // TELKOM_UNIV</span>
                    </div>

                    <div class="id-badge-body">
                        <!-- Kolom Foto Besar (Tingginya sebanding dengan seluruh data di sampingnya) -->
                        <div class="id-photo-col">
                            <div class="avatar-frame-large">
                                <img src="assets/img/foto.JPG" alt="Foto Profil <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>" class="avatar-photo-large" loading="eager">
                            </div>
                        </div>

                        <!-- Kolom Seluruh Data-Data di Samping Foto -->
                        <div class="id-data-col">
                            <div class="id-header-block">
                                <h1 class="id-fullname"><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></h1>
                                <p class="id-callsign">A.K.A. &ldquo;<?= htmlspecialchars(mb_strtoupper(MEMBER_NICKNAME), ENT_QUOTES, 'UTF-8') ?>&rdquo; &bull; <?= htmlspecialchars(MEMBER_PRODI, ENT_QUOTES, 'UTF-8') ?></p>
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
                                    <dd class="mono-val"><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?> (Ketua Kelompok)</dd>
                                </div>                                
                            </dl>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <!-- SECTION 2: PENDIDIKAN, PENGALAMAN ORGANISASI & SERTIFIKASI -->
        <section id="pendidikan" class="section-block section-alt">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">02 // TRACK RECORD</span>
                    <h2 class="section-title">Pendidikan, Pengalaman Organisasi &amp; Sertifikasi</h2>
                    <p class="section-subtitle">
                        Rekam jejak studi akademik S1 Informatika Telkom University (IPK 3.58), kontribusi aktif dalam kepanitiaan dan kehumasan (Public Relations &amp; Event Organizer), serta sertifikasi kecakapan bahasa Inggris.
                    </p>
                </div>

                <div class="timeline-grid">
                    <!-- Card 1: Pendidikan Sarjana -->
                    <article class="tech-card timeline-card">
                        <div class="card-top-bar">
                            <span class="mono-label">EDU // UNDERGRADUATE</span>
                            <span class="badge-route">AUG 2024 &mdash; PRESENT</span>
                        </div>
                        <h3 class="card-heading">S1 Informatika &mdash; Telkom University</h3>
                        <p class="card-sub"><?= htmlspecialchars(MEMBER_CITY, ENT_QUOTES, 'UTF-8') ?> &bull; Kelas <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?> &bull; Semester 2</p>
                        <p class="card-desc">
                            Menempuh perkuliahan sarjana pada Program Studi Informatika (Bachelor of Computer Science) dengan pencapaian <strong>IPK <?= htmlspecialchars(MEMBER_GPA, ENT_QUOTES, 'UTF-8') ?> dari skala 4.00</strong>. Berfokus pada penguasaan algoritma, basis data relasional (SQL), bahasa Go, serta eksplorasi Big Data dan Machine Learning.
                        </p>
                        <ul class="spec-bullet-list">
                            <li>Indeks Prestasi Kumulatif (IPK): <strong><?= htmlspecialchars(MEMBER_GPA, ENT_QUOTES, 'UTF-8') ?> / 4.00</strong>.</li>
                            <li>Ketua Kelompok (Node <code><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></code>) pada Proyek Aplikasi Bersama Pra-UTS Informatika.</li>
                            <li>Beraspirasi untuk bergabung dalam riset laboratorium <strong>MBC Laboratory</strong>.</li>
                        </ul>
                    </article>

                    <!-- Card 2: Pengalaman Organisasi - Hello World -->
                    <article class="tech-card timeline-card highlight-border">
                        <div class="card-top-bar">
                            <span class="mono-label">EXP // PUBLIC RELATIONS</span>
                            <span class="badge-route">JUNE 2025 &mdash; PRESENT</span>
                        </div>
                        <h3 class="card-heading">Public Relations &mdash; Hello World</h3>
                        <p class="card-sub">Fakultas Informatika &bull; Telkom University</p>
                        <p class="card-desc">
                            Bertindak sebagai jembatan komunikasi (intermediary) antara panitia dengan seluruh pemangku kepentingan (stakeholders), termasuk dosen-dosen laboratorium, serta bertugas memfasilitasi orientasi mahasiswa baru.
                        </p>
                        <ul class="spec-bullet-list">
                            <li>Menghubungkan komite dengan para dosen laboratorium dan pihak akademisi secara profesional.</li>
                            <li>Bertugas sebagai Liaison Officer (LO) untuk program orientasi mahasiswa baru angkatan 2025.</li>
                            <li>Memfasilitasi koordinasi lintas divisi dan kelancaran alur komunikasi kegiatan terpadu.</li>
                        </ul>
                    </article>

                    <!-- Card 3: Pengalaman Organisasi - AlFath & Prada -->
                    <article class="tech-card timeline-card">
                        <div class="card-top-bar">
                            <span class="mono-label">EXP // ORGANIZATIONAL &amp; EVENT</span>
                            <span class="badge-route">JAN 2025 &mdash; PRESENT</span>
                        </div>
                        <h3 class="card-heading">Public Relations (AlFath) &amp; Event Organizer (Prada)</h3>
                        <p class="card-sub">Humas Organisasi &bull; Manajemen Acara (Jan &ndash; Mei 2025)</p>
                        <p class="card-desc">
                            Memegang peran kehumasan publik pada organisasi AlFath serta tanggung jawab operasional kepanitiaan acara pada kegiatan Prada.
                        </p>
                        <ul class="spec-bullet-list">
                            <li><strong>Public Relations – AlFath (Jan 2025 – Present):</strong> Menyampaikan ide dan wawasan kepada audiens publik, mengelola saluran komunikasi kelembagaan, dan merawat keterlibatan positif eksternal.</li>
                            <li><strong>Event Organizer – Prada (Jan – Mei 2025):</strong> Mengawal kelancaran dan kesuksesan event dari tahap perencanaan, persiapan teknis, eksekusi hari-H, hingga evaluasi penutupan acara.</li>
                            <li>Terbiasa dalam dokumentasi kegiatan dan kerja sama tim lintas fungsional.</li>
                        </ul>
                    </article>

                    <!-- Card 4: Sertifikasi Bahasa Inggris -->
                    <article class="tech-card timeline-card highlight-border">
                        <div class="card-top-bar">
                            <span class="mono-label">CERT // LANGUAGE PROFICIENCY</span>
                            <span class="badge-route">SEP 2024</span>
                        </div>
                        <h3 class="card-heading">EPrT (English Proficiency Test)</h3>
                        <p class="card-sub">Telkom University Language Center &bull; Skor 480 / CEFR B1</p>
                        <p class="card-desc">
                            Telah tersertifikasi secara resmi dalam tes kecakapan bahasa Inggris (EPrT) dengan perolehan skor <strong>480</strong> (setara level <strong>CEFR B1</strong>), mendukung kelancaran studi literatur riset internasional.
                        </p>
                        <ul class="spec-bullet-list">
                            <li>Kemampuan membaca &amp; menelaah dokumentasi teknis serta paper ilmiah berbahasa Inggris.</li>
                            <li>Aktif memperkaya kosakata dan materi komputasi dari berbagai sumber internasional.</li>
                            <li>Mendukung kolaborasi riset skala global di bidang Big Data dan kecerdasan buatan.</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <!-- SECTION 3: KEAHLIAN (SKILLS) -->
        <section id="keahlian" class="section-block">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">03 // TECHNICAL STACK</span>
                    <h2 class="section-title">Keahlian &amp; Teknologi</h2>
                    <p class="section-subtitle">
                        Tumpukan teknologi utama yang saya gunakan dalam pemrograman sistem (Go), perancangan basis data relasional (SQL), platform pengembang, serta minat riset Big Data dan Machine Learning.
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

        <!-- SECTION 4: PORTOFOLIO -->
        <section id="portofolio" class="section-block section-alt">
            <div class="container">
                <div class="section-header-flex">
                    <div>
                        <span class="section-tag">04 // SHOWCASE</span>
                        <h2 class="section-title">Portofolio Proyek</h2>
                        <p class="section-subtitle">
                            Kumpulan proyek perangkat lunak yang dibangun menggunakan Java Spring Boot, Vue.js, Express, Next.js, dan Supabase.
                        </p>
                    </div>

                    <!-- Filter Interaktif via assets/js/main.js -->
                    <div class="portfolio-filters" role="group" aria-label="Filter kategori portofolio">
                        <button type="button" class="filter-btn active" data-filter="all">Semua (3)</button>
                        <button type="button" class="filter-btn" data-filter="go">Go &amp; Algoritma</button>
                        <button type="button" class="filter-btn" data-filter="sql">SQL &amp; Database</button>
                        <button type="button" class="filter-btn" data-filter="web">Web &amp; PHP</button>
                    </div>
                </div>

                <div class="portfolio-grid" id="portfolioGrid">
                    <?php foreach ($portfolios as $proj): ?>
                        <article class="tech-card portfolio-card" data-category="<?= htmlspecialchars($proj['category'], ENT_QUOTES, 'UTF-8') ?>">
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

        <!-- SECTION 5: GUESTBOOK KELOMPOK TERDISTRIBUSI (EMBEDDED) -->
        <section id="guestbook" class="section-block">
            <div class="container">
                <div class="section-header-flex">
                    <div>
                        <span class="section-tag">05 // SHARED APPLICATION</span>
                        <h2 class="section-title">Guestbook Kelompok Terdistribusi</h2>
                        <p class="section-subtitle">
                            Aplikasi buku tamu kelompok berbasis database relasional bersama (Node <?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?> &bull; <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>) yang terhubung langsung secara real-time.
                        </p>
                    </div>
                    <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                        <a href="app/index.php" target="_blank" class="btn btn-primary btn-sm">Buka Halaman Mandiri &nearr;</a>
                        <a href="app/export.php" target="_blank" class="btn btn-secondary btn-sm">Pusat Ekspor &nearr;</a>
                    </div>
                </div>

                <div class="tech-card embed-frame-wrapper" style="margin-top: 1.25rem;">
                    <iframe src="app/index.php?embed=1" class="guestbook-iframe" title="Guestbook Kelompok Terdistribusi" loading="lazy"></iframe>
                </div>
            </div>
        </section>

        <!-- SECTION 6: KONTAK & JEJARING PROFESIONAL -->
        <section id="kontak" class="section-block section-alt">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">06 // COMMUNICATION CHANNELS</span>
                    <h2 class="section-title">Kontak &amp; Jejaring Profesional</h2>
                    <p class="section-subtitle">
                        Terbuka untuk diskusi seputar kolaborasi proyek perangkat lunak, eksplorasi riset Big Data &amp; Machine Learning, maupun interaksi akademik. Silakan hubungi saya melalui kanal resmi berikut.
                    </p>
                </div>

                <div class="contact-grid">
                    <!-- Kanal 1: Email Resmi -->
                    <a href="mailto:<?= htmlspecialchars(MEMBER_EMAIL, ENT_QUOTES, 'UTF-8') ?>" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">CHANNEL // 01</span>
                            <span class="contact-arrow">&nearr;</span>
                        </div>
                        <h3 class="contact-title">Email Resmi</h3>
                        <p class="contact-handle"><?= htmlspecialchars(MEMBER_EMAIL, ENT_QUOTES, 'UTF-8') ?></p>
                        <span class="contact-hint">Kirim pesan elektronik untuk kolaborasi &amp; riset</span>
                    </a>

                    <!-- Kanal 2: WhatsApp / Telepon -->
                    <a href="https://wa.me/6281323285482" target="_blank" rel="noopener noreferrer" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">CHANNEL // 02</span>
                            <span class="contact-arrow">&nearr;</span>
                        </div>
                        <h3 class="contact-title">WhatsApp &amp; Telepon</h3>
                        <p class="contact-handle"><?= htmlspecialchars(MEMBER_PHONE, ENT_QUOTES, 'UTF-8') ?></p>
                        <span class="contact-hint">Komunikasi langsung, konsultasi &amp; koordinasi cepat</span>
                    </a>

                    <!-- Kanal 3: LinkedIn -->
                    <a href="<?= htmlspecialchars(MEMBER_LINKEDIN, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">CHANNEL // 03</span>
                            <span class="contact-arrow">&nearr;</span>
                        </div>
                        <h3 class="contact-title">LinkedIn Profile</h3>
                        <p class="contact-handle"><?= htmlspecialchars(str_replace(['https://', 'http://'], '', rtrim(MEMBER_LINKEDIN, '/')), ENT_QUOTES, 'UTF-8') ?></p>
                        <span class="contact-hint">Jejaring profesional &amp; rekam jejak karier</span>
                    </a>

                    <!-- Kanal 4: GitHub -->
                    <a href="<?= htmlspecialchars(MEMBER_GITHUB, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">CHANNEL // 04</span>
                            <span class="contact-arrow">&nearr;</span>
                        </div>
                        <h3 class="contact-title">GitHub Repository</h3>
                        <p class="contact-handle"><?= htmlspecialchars(str_replace(['https://', 'http://'], '', rtrim(MEMBER_GITHUB, '/')), ENT_QUOTES, 'UTF-8') ?></p>
                        <span class="contact-hint">Repositori kode, proyek Go, SQL &amp; web</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Semantic HTML5 -->
    <footer class="site-footer">
        <div class="container footer-inner">
            <div class="footer-brand">
                <span class="mono-small"><strong><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></strong> (<?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?>) &bull; <?= htmlspecialchars(MEMBER_NICKNAME, ENT_QUOTES, 'UTF-8') ?></span>
                <span class="mono-small">S1 Informatika Telkom University &bull; Kelas <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?> &bull; <?= htmlspecialchars(MEMBER_CITY, ENT_QUOTES, 'UTF-8') ?></span>
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


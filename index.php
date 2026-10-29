<?php
declare(strict_types=1);

/**
 * Halaman Utama Personal Page (Root `index.php`)
 * Mahasiswa : Dini Nadia Mawaddah - 103012430028
 * Tema      : Super Mario Bros Retro-Modern & Clean Readable UI
 */

require_once __DIR__ . '/identity.php';

$skills = [
    [
        'name'     => 'PHP & MySQL',
        'category' => 'Backend & Database',
        'level'    => 'POWER-UP ★★★',
        'desc'     => 'Backend web terstruktur, integrasi PDO anti-SQL Injection, dan perancangan skema relasional.',
        'code'     => 'PH-01',
        'icon'     => '🍄',
    ],
    [
        'name'     => 'Java OOP',
        'category' => 'Object-Oriented Architecture',
        'level'    => 'POWER-UP ★★★',
        'desc'     => 'Pemrograman berorientasi objek (Inheritance, Polymorphism, Encapsulation), MVC, dan struktur data.',
        'code'     => 'JV-02',
        'icon'     => '☕',
    ],
    [
        'name'     => 'HTML5 & CSS3',
        'category' => 'Responsive UI Design',
        'level'    => 'POWER-UP ★★★',
        'desc'     => 'Desain semantik modern, sistem Flexbox & Grid, responsif laptop & ponsel, serta tema dinamis.',
        'code'     => 'FE-03',
        'icon'     => '🎨',
    ],
    [
        'name'     => 'Vanilla JavaScript',
        'category' => 'Interactive Scripting',
        'level'    => 'POWER-UP ★★☆',
        'desc'     => 'Manipulasi DOM dinamis, modal dialog interaktif, filter portofolio, dan validasi form.',
        'code'     => 'JS-04',
        'icon'     => '⭐',
    ],
    [
        'name'     => 'Git & GitHub',
        'category' => 'Version Control',
        'level'    => 'POWER-UP ★★☆',
        'desc'     => 'Kolaborasi source code, workflow branching terstruktur, commit konsisten, dan sinkronisasi tim.',
        'code'     => 'GT-05',
        'icon'     => '🌿',
    ],
    [
        'name'     => 'INTELECTA Event',
        'category' => 'Organization & Teamwork',
        'level'    => 'SPECIAL BADGE 🏆',
        'desc'     => 'Kepanitiaan aktif INTELECTA dalam koordinasi acara, manajemen teknis kompetisi, dan alur peserta.',
        'code'     => 'ORG-06',
        'icon'     => '🚩',
    ],
];

$portfolios = [
    [
        'id'       => 'WORLD 1',
        'icon'     => '🏠',
        'title'    => 'SuperKost',
        'subtitle' => 'Platform Manajemen & Digitalisasi Hunian Indekos',
        'category' => 'web-app',
        'tags'     => ['PHP / Java', 'MySQL DB', 'Kost Management'],
        'year'     => '2025',
        'status'   => 'CLEARED 🏆',
        'summary'  => 'Aplikasi pengelolaan kamar kos dan hunian terpadu untuk monitoring ketersediaan unit, pencatatan sewa penghuni, tagihan berkala, dan rekap keuangan pemilik kos.',
        'highlights' => [
            'Manajemen ketersediaan unit kamar dan data penghuni real-time',
            'Pencatatan otomatis histori tagihan bulanan dan pembayaran sewa',
            'Dashboard ringkas untuk laporan keuangan dan rekap hunian',
        ],
    ],
    [
        'id'       => 'WORLD 2',
        'icon'     => '🎓',
        'title'    => 'Redesain iGracias',
        'subtitle' => 'UI/UX Redesign Portal Akademik Terintegrasi',
        'category' => 'ui-ux',
        'tags'     => ['UI/UX Design', 'Figma', 'Responsive Web'],
        'year'     => '2025',
        'status'   => 'FEATURED ⭐️',
        'summary'  => 'Pembaruan antarmuka portal akademik iGracias Telkom University yang lebih bersih, modern, dan intuitif untuk kemudahan registrasi mata kuliah (KRS), cek jadwal kuliah, dan pantau nilai.',
        'highlights' => [
            'Antarmuka modern yang segar, minim distraksi, dan mudah dipahami',
            'Tata letak jadwal perkuliahan serta grafik nilai yang lebih rapi',
            'Navigasi responsif yang nyaman diakses melalui perangkat smartphone',
        ],
    ],
    [
        'id'       => 'WORLD 3',
        'icon'     => '💰',
        'title'    => 'FinSmart',
        'subtitle' => 'Aplikasi Pelacak & Pengatur Keuangan Mandiri',
        'category' => 'fintech',
        'tags'     => ['Finance Tracker', 'JavaScript', 'Data Charts'],
        'year'     => '2025',
        'status'   => 'CLEARED 🏆',
        'summary'  => 'Platform pengatur keuangan cerdas untuk mencatat arus kas harian (pemasukan & pengeluaran), menetapkan alokasi anggaran belanja, dan menyajikan ringkasan visual.',
        'highlights' => [
            'Pencatatan transaksi harian cepat dengan kategorisasi pengeluaran',
            'Fitur penetapan target anggaran dan peringatan batas belanja',
            'Visualisasi grafik arus kas interaktif yang informatif',
        ],
    ],
    [
        'id'       => 'WORLD 4',
        'icon'     => '💬',
        'title'    => 'Distributed Guestbook Node',
        'subtitle' => 'Node Aplikasi Bersama Terdistribusi Pra-UTS',
        'category' => 'fullstack',
        'tags'     => ['PHP 8 PDO', 'MySQL Server', 'Live Embed'],
        'year'     => '2026',
        'status'   => 'ACTIVE NODE 🟢',
        'summary'  => 'Aplikasi buku tamu bersama terdistribusi yang terhubung ke database terpusat kelompok, filter route anggota (m0 - m5), dan live embed iframe.',
        'highlights' => [
            'Node pelayan lokal terverifikasi (Node m3)',
            'Mendukung mode standalone maupun embed di halaman utama',
            'Validasi sisi klien & server dengan proteksi anti-XSS',
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
    <title><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> // Mario Level // Personal Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Mario HUD Banner (`app/partials/served_by.php`) -->
    <?php require_once __DIR__ . '/app/partials/served_by.php'; ?>

    <!-- Header & Navigasi -->
    <header class="site-header" id="top">
        <div class="container header-inner">
            <a href="#profil" class="brand-logo" aria-label="Beranda <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>">
                <span>🍄</span>
                <span class="brand-bracket">[</span><?= htmlspecialchars(strtoupper(MEMBER_NICKNAME), ENT_QUOTES, 'UTF-8') ?><span class="brand-accent">//</span><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?><span class="brand-bracket">]</span>
            </a>

            <button class="mobile-nav-toggle" id="mobileNavToggle" aria-expanded="false" aria-controls="primaryNav" aria-label="Buka menu navigasi">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <nav class="site-nav" id="primaryNav" aria-label="Navigasi Level">
                <ul class="nav-list">
                    <li><a href="#profil" class="nav-link active">01. Profil</a></li>
                    <li><a href="#pendidikan" class="nav-link">02. Pengalaman</a></li>
                    <li><a href="#keahlian" class="nav-link">03. Power-Ups</a></li>
                    <li><a href="#portofolio" class="nav-link">04. Portofolio</a></li>
                    <li><a href="#aplikasi" class="nav-link">05. Guestbook</a></li>
                    <li><a href="#kontak" class="nav-link">06. Kontak</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <button type="button" id="themeToggleBtn" class="btn btn-icon" aria-label="Ubah tema Overworld / Underground" title="Toggle Mario World Theme">
                    <span class="theme-indicator-dot"></span>
                    <span class="mono-small" id="themeLabel" style="font-family: var(--font-pixel); font-size: 0.65rem;">UNDERGROUND</span>
                </button>
                <a href="app/index.php" class="btn btn-primary btn-sm">Buka Guestbook &nearr;</a>
            </div>
        </div>
    </header>

    <main>
        <!-- SECTION 1: PROFIL (LEVEL 1: PLAYER PROFILE) -->
        <section id="profil" class="hero-section section-block">
            <div class="container hero-grid">
                <div class="hero-content">
                    <div class="spec-pill-row">
                        <span class="spec-pill">⭐ PLAYER 1 READY</span>
                        <span class="spec-pill">NODE // <?= htmlspecialchars(strtoupper(MEMBER_ROUTE), ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="spec-pill">NIM // <?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>

                    <h1 class="hero-title">
                        <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>
                        <span class="hero-alias">★ DINI</span>
                    </h1>

                    <p class="hero-lead">
                        Mahasiswa Informatika yang punya prinsip disiplin, perfeksionis, dan zero tolerance buat hal yang buang-buang waktu. Suka mengeksplorasi sistem, teknologi, dan ide-ide baru dengan pendekatan yang santai tapi fokus. <em>Let’s build cool things and enjoy the ride!</em>
                    </p>

                    <div class="hero-cta-group">
                        <a href="#portofolio" class="btn btn-primary">
                            <span>▶ Lihat Portofolio</span>
                        </a>
                        <a href="#aplikasi" class="btn btn-outline">
                            <span>🟢 Buka Guestbook Bersama</span>
                        </a>
                    </div>

                    <!-- HUD Status Ringkas -->
                    <div class="telemetry-strip" aria-label="Status Player">
                        <div class="telemetry-item">
                            <span class="telemetry-val"><?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?></span>
                            <span class="telemetry-lbl">KELAS</span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-val">INTELECTA</span>
                            <span class="telemetry-lbl">PANITIA</span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-val">04 WORLDS</span>
                            <span class="telemetry-lbl">PROYEK</span>
                        </div>
                        <div class="telemetry-item">
                            <span class="telemetry-val">NODE <?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></span>
                            <span class="telemetry-lbl">SERVER</span>
                        </div>
                    </div>
                </div>

                <!-- Mario Player Card -->
                <aside class="hero-id-card tech-card" aria-label="Player Character Card">
                    <div class="card-top-bar">
                        <span class="mono-label">★ CHARACTER BADGE</span>
                        <span class="status-chip">LVL 99</span>
                    </div>

                    <div class="id-avatar-box">
                        <img src="assets/img/avatar.png" alt="Avatar Mario Dini Nadia Mawaddah" class="avatar-img" width="72" height="72" onerror="this.style.display='none'; document.getElementById('avatarFallback').style.display='flex';">
                        <div class="avatar-monogram" id="avatarFallback" style="display: none;" aria-hidden="true">DNM</div>
                        <div class="avatar-meta">
                            <span class="mono-small">DINI NADIA // M3</span>
                            <span class="mono-small">HP: ❤️❤️❤️❤️❤️</span>
                        </div>
                    </div>

                    <dl class="id-spec-list">
                        <div class="spec-row">
                            <dt>NAMA</dt>
                            <dd><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div class="spec-row">
                            <dt>NIM</dt>
                            <dd><?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div class="spec-row">
                            <dt>PRODI</dt>
                            <dd>S1 Informatika</dd>
                        </div>
                        <div class="spec-row">
                            <dt>KAMPUS</dt>
                            <dd>Telkom University</dd>
                        </div>
                    </dl>

                    <div class="id-barcode" aria-hidden="true">
                        <span>🍄 ⭐️ 🪙 1-UP 🍄</span>
                    </div>
                </aside>
            </div>
        </section>

        <!-- SECTION 2: PENDIDIKAN & KEPANITIAAN (LEVEL 2: QUEST LOG) -->
        <section id="pendidikan" class="section-block section-alt">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">★ LEVEL 02 // QUEST LOG</span>
                    <h2 class="section-title">Pendidikan &amp; Pengalaman</h2>
                    <p class="section-subtitle">
                        Perjalanan akademik di Telkom University dan kontribusi aktif di kepanitiaan kampus.
                    </p>
                </div>

                <div class="timeline-grid">
                    <!-- Card Pendidikan -->
                    <article class="tech-card timeline-card">
                        <div class="card-top-bar">
                            <span class="mono-label">🎓 UNDERGRADUATE</span>
                            <span class="badge-route">2024 &mdash; SEKARANG</span>
                        </div>
                        <h3 class="card-heading">S1 Informatika &mdash; Telkom University</h3>
                        <p class="card-sub">Kelas <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?> &bull; Bandung</p>
                        <p class="card-desc">
                            Mendalami fondasi ilmu komputer, pemrograman berorientasi objek (Java), basis data relasional MySQL, jaringan komputer, serta rekayasa web modern.
                        </p>
                        <ul class="spec-bullet-list">
                            <li>Anggota Node <code><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></code> pada Proyek Aplikasi Bersama Pra-UTS.</li>
                            <li>Fokus pada arsitektur perangkat lunak yang bersih, terstruktur, dan solutif.</li>
                        </ul>
                    </article>

                    <!-- Card Kepanitiaan INTELECTA -->
                    <article class="tech-card timeline-card highlight-border">
                        <div class="card-top-bar">
                            <span class="mono-label">🏆 COMMITTEE</span>
                            <span class="badge-route">ACTIVE</span>
                        </div>
                        <h3 class="card-heading">Kepanitiaan INTELECTA</h3>
                        <p class="card-sub">Informatics Intellectual Arena &bull; Fakultas Informatika</p>
                        <p class="card-desc">
                            Berperan aktif dalam kepanitiaan <strong>INTELECTA</strong>, festival dan kompetisi teknologi tahunan mahasiswa Informatika.
                        </p>
                        <ul class="spec-bullet-list">
                            <li>Koordinasi alur teknis perlombaan dan briefing delegasi peserta.</li>
                            <li>Kolaborasi lintas divisi untuk kelancaran logistik dan administrasi kompetisi.</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <!-- SECTION 3: KEAHLIAN (LEVEL 3: POWER-UPS) -->
        <section id="keahlian" class="section-block">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">★ LEVEL 03 // POWER-UPS</span>
                    <h2 class="section-title">Keahlian &amp; Teknologi</h2>
                    <p class="section-subtitle">
                        Tumpukan teknologi utama yang dikuasai untuk merancang sistem web dan aplikasi handal.
                    </p>
                </div>

                <div class="skills-grid">
                    <?php foreach ($skills as $skill): ?>
                        <article class="tech-card skill-card">
                            <div class="card-top-bar">
                                <span class="mono-label"><?= $skill['icon'] ?> <?= htmlspecialchars($skill['category'], ENT_QUOTES, 'UTF-8') ?></span>
                                <span class="skill-level"><?= htmlspecialchars($skill['level'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <h3 class="skill-title"><?= htmlspecialchars($skill['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="skill-desc"><?= htmlspecialchars($skill['desc'], ENT_QUOTES, 'UTF-8') ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- SECTION 4: PORTOFOLIO (LEVEL 4: CLEARED WORLDS) -->
        <section id="portofolio" class="section-block section-alt">
            <div class="container">
                <div class="section-header-flex">
                    <div>
                        <span class="section-tag">★ LEVEL 04 // CLEARED WORLDS</span>
                        <h2 class="section-title">Portofolio Proyek</h2>
                        <p class="section-subtitle">
                            Koleksi karya proyek perangkat lunak pilihan. Klik kartu untuk melihat rincian misi.
                        </p>
                    </div>

                    <!-- Filter Interaktif via assets/js/main.js -->
                    <div class="portfolio-filters" role="group" aria-label="Filter kategori portofolio">
                        <button type="button" class="filter-btn active" data-filter="all">Semua (4)</button>
                        <button type="button" class="filter-btn" data-filter="web-app">SuperKost</button>
                        <button type="button" class="filter-btn" data-filter="ui-ux">Redesain iGracias</button>
                        <button type="button" class="filter-btn" data-filter="fintech">FinSmart</button>
                        <button type="button" class="filter-btn" data-filter="fullstack">Guestbook Node</button>
                    </div>
                </div>

                <div class="portfolio-grid" id="portfolioGrid">
                    <?php foreach ($portfolios as $proj): ?>
                        <article class="tech-card portfolio-card" data-category="<?= htmlspecialchars($proj['category'], ENT_QUOTES, 'UTF-8') ?>" tabindex="0" role="button" aria-label="Lihat rincian misi <?= htmlspecialchars($proj['title'], ENT_QUOTES, 'UTF-8') ?>">
                            <div class="card-top-bar">
                                <span class="mono-label"><?= $proj['icon'] ?> <?= htmlspecialchars($proj['id'], ENT_QUOTES, 'UTF-8') ?></span>
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

        <!-- SECTION 5: APLIKASI BERSAMA (WARP PIPE GUESTBOOK) -->
        <section id="aplikasi" class="section-block">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">★ WARP PIPE // SHARED APPLICATION</span>
                    <h2 class="section-title">Aplikasi Bersama &mdash; Guestbook</h2>
                    <p class="section-subtitle">
                        Tinggalkan pesan di buku tamu terdistribusi kelompok, atau kunjungi langsung <a href="app/index.php" class="inline-link">halaman mandiri aplikasi (app/) &nearr;</a>.
                    </p>
                </div>

                <div class="app-embed-card">
                    <div class="app-embed-topbar">
                        <div>
                            <span class="mono-label">🟢 WARP PIPE // LIVE EMBED</span>
                        </div>
                        <div>
                            <a href="app/index.php" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">Buka Halaman Penuh &nearr;</a>
                        </div>
                    </div>
                    <div class="app-embed-wrapper">
                        <iframe src="app/index.php?embed=1" title="Aplikasi Bersama — Guestbook Kelompok Terdistribusi" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 6: KONTAK (SAVE POINT) -->
        <section id="kontak" class="section-block section-alt">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">★ SAVE POINT // CONTACT</span>
                    <h2 class="section-title">Kontak &amp; Jejaring</h2>
                    <p class="section-subtitle">
                        Mari berdiskusi tentang kolaborasi proyek maupun kegiatan kampus. (Nomor kontak tidak dipublikasikan untuk privasi).
                    </p>
                </div>

                <div class="contact-grid">
                    <a href="mailto:dininadia2005@gmail.com" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">💌 EMAIL</span>
                        </div>
                        <h3 class="contact-title">Kirim Surat</h3>
                        <p class="contact-handle">dininadia2005@gmail.com</p>
                        <span class="contact-hint">Kirim pesan langsung via email</span>
                    </a>

                    <a href="https://github.com/DiniNadia13" target="_blank" rel="noopener noreferrer" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">🐙 GITHUB</span>
                        </div>
                        <h3 class="contact-title">Kode &amp; Proyek</h3>
                        <p class="contact-handle">github.com/DiniNadia13</p>
                        <span class="contact-hint">Lihat repositori kode sumber</span>
                    </a>

                    <a href="https://www.linkedin.com/in/dini-nadia-mawaddah-098132405/" target="_blank" rel="noopener noreferrer" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">💼 LINKEDIN</span>
                        </div>
                        <h3 class="contact-title">Jejaring Karir</h3>
                        <p class="contact-handle">linkedin.com/in/dini-nadia-mawaddah</p>
                        <span class="contact-hint">Hubungkan di jejaring profesional</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Dialog Misi Portofolio -->
    <div class="modal-backdrop" id="projectModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-dialog">
            <button type="button" class="modal-close-btn" id="modalCloseBtn" aria-label="Tutup jendela">&times;</button>
            <div class="card-top-bar">
                <span class="mono-label">★ MISSION DETAIL</span>
                <span class="status-chip" id="modalStatus">STATUS</span>
            </div>
            <h3 class="portfolio-title" id="modalTitle" style="margin-top: 0.5rem;">Judul Proyek</h3>
            <p class="portfolio-subtitle" id="modalSubtitle" style="margin-bottom: 1rem;">Subjudul Proyek</p>
            <p class="portfolio-summary" id="modalSummary" style="margin-bottom: 1rem;"></p>
            
            <h4 style="font-size: 0.88rem; font-family: var(--font-pixel); margin-bottom: 0.5rem; color: var(--mario-yellow);">HIGHLIGHT FITUR:</h4>
            <ul class="spec-bullet-list" id="modalHighlights" style="margin-bottom: 1.25rem;"></ul>

            <h4 style="font-size: 0.88rem; font-family: var(--font-pixel); margin-bottom: 0.5rem; color: var(--mario-yellow);">TEKNOLOGI:</h4>
            <div class="tag-row" id="modalTags"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container footer-inner">
            <div class="footer-brand">
                <span>⭐ <strong><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></strong> (<?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?>)</span>
                <span>S1 Informatika Telkom University &bull; Kelas <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?> &bull; Panitia INTELECTA</span>
            </div>
            <div class="footer-links">
                <a href="#top">BACK TO TOP &uarr;</a>
                <a href="app/index.php">GUESTBOOK &nearr;</a>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>

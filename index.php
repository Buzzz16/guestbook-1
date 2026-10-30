<?php
declare(strict_types=1);

/**
 * Halaman Utama Personal Page (Root `index.php`)
 * Mahasiswa : Dini Nadia Mawaddah - 103012430028
 * Tema      : Super Mario Bros Retro-Modern (Custom Arcade World Layout)
 */

require_once __DIR__ . '/identity.php';

$skills = [
    [
        'name' => 'PHP & MySQL',
        'category' => 'Backend & Database',
        'level' => 'POWER-UP ★★★',
        'desc' => 'Backend web terstruktur, integrasi PDO anti-SQL Injection, dan perancangan skema relasional.',
        'code' => 'PH-01',
        'icon' => '🍄',
        'meter' => '100%',
    ],
    [
        'name' => 'Java OOP',
        'category' => 'Object-Oriented Architecture',
        'level' => 'POWER-UP ★★★',
        'desc' => 'Pemrograman berorientasi objek (Inheritance, Polymorphism, Encapsulation), MVC, dan struktur data.',
        'code' => 'JV-02',
        'icon' => '☕',
        'meter' => '95%',
    ],
    [
        'name' => 'HTML5 & CSS3',
        'category' => 'Responsive UI Design',
        'level' => 'POWER-UP ★★★',
        'desc' => 'Desain semantik modern, sistem Flexbox & Grid, responsif laptop & ponsel, serta tema dinamis.',
        'code' => 'FE-03',
        'icon' => '🎨',
        'meter' => '95%',
    ],
    [
        'name' => 'UI/UX & Figma',
        'category' => 'Interface & Prototyping',
        'level' => 'POWER-UP ★★★',
        'desc' => 'Desain antarmuka berpusat pada pengguna, wireframing, perancangan prototipe interaktif di Figma, dan user flow.',
        'code' => 'UX-06',
        'icon' => '🎯',
        'meter' => '95%',
    ],
    [
        'name' => 'Vanilla JavaScript',
        'category' => 'Interactive Scripting',
        'level' => 'POWER-UP ★★☆',
        'desc' => 'Manipulasi DOM dinamis, modal dialog interaktif, filter portofolio, dan validasi form.',
        'code' => 'JS-04',
        'icon' => '⭐',
        'meter' => '85%',
    ],
    [
        'name' => 'Git & GitHub',
        'category' => 'Version Control',
        'level' => 'POWER-UP ★★☆',
        'desc' => 'Kolaborasi source code, workflow branching terstruktur, commit konsisten, dan sinkronisasi tim.',
        'code' => 'GT-05',
        'icon' => '🌿',
        'meter' => '88%',
    ],
];

$portfolios = [
    [
        'id' => 'WORLD 1-1',
        'icon' => '🏠',
        'title' => 'SuperKost',
        'subtitle' => 'Platform Manajemen & Digitalisasi Hunian Indekos',
        'category' => 'web-app',
        'tags' => ['PHP / Java', 'MySQL DB', 'Kost Management'],
        'year' => '2025',
        'status' => 'CLEARED 🏆',
        'summary' => 'Aplikasi pengelolaan kamar kos dan hunian terpadu untuk monitoring ketersediaan unit, pencatatan sewa penghuni, tagihan berkala, dan rekap keuangan pemilik kos.',
        'highlights' => [
            'Manajemen ketersediaan unit kamar dan data penghuni real-time',
            'Pencatatan otomatis histori tagihan bulanan dan pembayaran sewa',
            'Dashboard ringkas untuk laporan keuangan dan rekap hunian',
        ],
    ],
    [
        'id' => 'WORLD 1-2',
        'icon' => '🎓',
        'title' => 'Redesain iGracias',
        'subtitle' => 'UI/UX Redesign Portal Akademik Terintegrasi',
        'category' => 'ui-ux',
        'tags' => ['UI/UX Design', 'Figma', 'Responsive Web'],
        'year' => '2025',
        'status' => 'FEATURED ⭐️',
        'summary' => 'Pembaruan antarmuka portal akademik iGracias Telkom University yang lebih bersih, modern, dan intuitif untuk kemudahan registrasi mata kuliah (KRS), cek jadwal kuliah, dan pantau nilai.',
        'highlights' => [
            'Antarmuka modern yang segar, minim distraksi, dan mudah dipahami',
            'Tata letak jadwal perkuliahan serta grafik nilai yang lebih rapi',
            'Navigasi responsif yang nyaman diakses melalui perangkat smartphone',
        ],
    ],
    [
        'id' => 'WORLD 1-3',
        'icon' => '💰',
        'title' => 'FinSmart',
        'subtitle' => 'Aplikasi Pelacak & Pengatur Keuangan Mandiri',
        'category' => 'fintech',
        'tags' => ['Finance Tracker', 'JavaScript', 'Data Charts'],
        'year' => '2025',
        'status' => 'CLEARED 🏆',
        'summary' => 'Platform pengatur keuangan cerdas untuk mencatat arus kas harian (pemasukan & pengeluaran), menetapkan alokasi anggaran belanja, dan menyajikan ringkasan visual.',
        'highlights' => [
            'Pencatatan transaksi harian cepat dengan kategorisasi pengeluaran',
            'Fitur penetapan target anggaran dan peringatan batas belanja',
            'Visualisasi grafik arus kas interaktif yang informatif',
        ],
    ],
    [
        'id' => 'WORLD 1-4',
        'icon' => '🌿',
        'title' => 'PoluSee',
        'subtitle' => 'Platform Web Pemantau & Cek Kualitas Udara',
        'category' => 'env-web',
        'tags' => ['Air Quality', 'Web App', 'Data Monitoring'],
        'year' => '2025',
        'status' => 'CLEARED 🏆',
        'summary' => 'Aplikasi web interaktif untuk memantau dan mengecek indeks kualitas udara (AQI) secara real-time, memberikan informasi tingkat polusi, serta rekomendasi kesehatan lingkungan.',
        'highlights' => [
            'Pengecekan indeks kualitas udara (AQI) dan status polusi secara akurat',
            'Indikator visual kategori udara bersih hingga berbahaya yang mudah dipahami',
            'Informasi edukasi dan rekomendasi aktivitas luar ruangan berdasarkan kondisi udara',
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Personal Page <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> - Mahasiswa S1 Informatika Telkom University (<?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?>).">
    <title><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> // Mario World // Personal Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cabinet+Grotesk:wght@700;800;900&family=Space+Grotesk:wght@600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=25">
</head>

<body>

    <!-- Dekorasi Langit & Elemen Mario Bros Melayang -->
    <div class="mario-sky-decor" aria-hidden="true">
        <span class="sky-cloud cloud-1">☁️</span>
        <span class="sky-cloud cloud-2">☁️</span>
        <span class="sky-cloud cloud-3">☁️</span>
        <span class="sky-star star-1">⭐</span>
        <span class="sky-star star-2">🪙</span>
        <span class="sky-star star-3">🍄</span>
        <span class="sky-star star-4">⭐</span>
    </div>

    <!-- Animasi Samping Kiri & Kanan (Panjat Tanaman Vine, Pipa Samping, Platform & Flagpole) -->
    <div class="mario-side-rails" aria-hidden="true">
        <!-- SISI KIRI: Tanaman Vine & Pemanjat + Pipa Samping + Lift Blok -->
        <div class="side-rail side-rail-left">
            <div class="vine-stalk"></div>

            <!-- Karakter Pixel Mario Memanjat Vine Naik-Turun -->
            <div class="vine-climber climber-1" id="leftVineClimber">
                <div class="pixel-mario-badge">
                    <span class="climber-hat">🧢</span>
                    <span class="climber-body">🍄</span>
                </div>
                <span class="climber-label">1-UP</span>
            </div>

            <!-- Koopa / Jamur Kedua yang Ikut Memanjat -->
            <div class="vine-climber climber-2">
                <span class="climber-sprite">🐢</span>
            </div>

            <!-- Pipa Hijau Menempel di Dinding Kiri + Tanaman Piranha Keluar-Masuk -->
            <div class="side-wall-pipe pipe-left-wall">
                <div class="wall-pipe-body"></div>
                <div class="wall-pipe-lip"></div>
                <span class="piranha-peek">🌺</span>
            </div>

            <!-- Platform Lift Naik-Turun di Samping Kiri -->
            <div class="side-elevator-platform">
                <div class="platform-bricks">
                    <span>🧱</span><span>?</span><span>🧱</span>
                </div>
            </div>
        </div>

        <!-- SISI KANAN: Tiang Bendera / Tangga Koin, Awan Lakitu & Pemanjat -->
        <div class="side-rail side-rail-right">
            <div class="flagpole-rod">
                <span class="flagpole-top-orb">🟡</span>
                <span class="flagpole-pennant">🚩</span>
            </div>

            <!-- Karakter Memanjat Tiang di Sisi Kanan -->
            <div class="pole-climber" id="rightPoleClimber">
                <span class="climber-star-badge">⭐</span>
                <span class="climber-label">SUPER</span>
            </div>

            <!-- Awan Lakitu Melayang Naik-Turun di Samping Kanan -->
            <div class="side-lakitu-cloud">
                <span class="lakitu-rider">🐢</span>
                <span class="lakitu-cloud-base">☁️</span>
                <span class="lakitu-drop-coin">🪙</span>
            </div>

            <!-- Pipa Hijau di Dinding Kanan + Bola Api Melompat -->
            <div class="side-wall-pipe pipe-right-wall">
                <span class="fireball-pop">🔥</span>
                <div class="wall-pipe-lip"></div>
                <div class="wall-pipe-body"></div>
            </div>

            <!-- Deretan Blok Melayang Vertikal di Sisi Kanan -->
            <div class="side-floating-qblocks">
                <span class="m-block m-qblock">?</span>
                <span class="side-coin-bounce">🪙</span>
                <span class="m-block m-brick">🧱</span>
            </div>
        </div>
    </div>

    <!-- Mario HUD Banner (`app/partials/served_by.php`) -->
    <?php require_once __DIR__ . '/app/partials/served_by.php'; ?>

    <!-- Header & Navigasi Kapsul Tengah -->
    <header class="site-header" id="top">
        <div class="container header-inner">
            <button class="mobile-nav-toggle" id="mobileNavToggle" aria-expanded="false" aria-controls="primaryNav"
                aria-label="Buka menu navigasi">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <nav class="site-nav nav-pill-dock" id="primaryNav" aria-label="Navigasi Level">
                <ul class="nav-list">
                    <li><a href="#profil" class="nav-link active">Profil</a></li>
                    <li><a href="#portofolio" class="nav-link">Portofolio</a></li>
                    <li><a href="#pendidikan" class="nav-link">Pengalaman</a></li>
                    <li><a href="#keahlian" class="nav-link">Keahlian</a></li>
                    <li><a href="#kontak" class="nav-link">Kontak</a></li>
                </ul>
            </nav>

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

    <main>
        <!-- SECTION 1: PROFIL (CHARACTER SPOTLIGHT DI KIRI, BENTO DIALOG DI KANAN) -->
        <section id="profil" class="hero-section section-block">
            <div class="container hero-showcase-layout">
                <!-- Kolom Kiri: Panggung Foto Karakter Utama -->
                <aside class="hero-id-card character-spotlight-card tech-card" aria-label="Player Character Spotlight">
                    <div class="spotlight-floating-badges">
                        <span class="mono-label">★ PLAYER 1</span>
                        <span class="status-chip">LVL 99</span>
                    </div>

                    <div class="spotlight-avatar-frame">
                        <img src="assets/img/avatar.png?v=2" alt="Foto Profil Dini Nadia Mawaddah"
                            class="spotlight-avatar-img" width="195" height="195"
                            onerror="this.style.display='none'; document.getElementById('avatarFallback').style.display='flex';">
                        <div class="avatar-monogram" id="avatarFallback" style="display: none;" aria-hidden="true">DNM
                        </div>
                        <span class="spotlight-hp-pill">❤️❤️❤️❤️❤️</span>
                    </div>

                    <p class="spotlight-role">S1 Informatika &bull; Telkom University</p>

                    <div class="spotlight-chips">
                        <span class="spotlight-chip">NIM <?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>

                    <div class="id-barcode" aria-hidden="true">
                        <span>🍄 ⭐️ 🪙 1-UP 🍄</span>
                    </div>
                </aside>

                <!-- Kolom Kanan: Judul, Kotak Dialog Mario & Tombol Aksi -->
                <div class="hero-content hero-bento-right">
                    <div class="spec-pill-row">
                        <div class="mario-interactive-blocks" aria-hidden="true" title="Hit the Question Block!">
                            <span class="m-block m-brick">🧱</span>
                            <span class="m-block m-qblock">?</span>
                            <span class="m-block m-brick">🧱</span>
                            <span class="m-block m-qblock">?</span>
                            <span class="m-coin-pop">🪙</span>
                            <span class="m-shroom-pop">🍄</span>
                        </div>
                    </div>

                    <h1 class="hero-title">
                        <?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?>
                    </h1>

                    <div class="mario-dialog-box">
                        <p class="hero-lead">
                            Mahasiswa Informatika yang punya prinsip disiplin, perfeksionis, dan zero tolerance buat hal
                            yang buang-buang waktu. Suka mengeksplorasi sistem, teknologi, dan ide-ide baru dengan
                            pendekatan yang santai tapi fokus. <em>Let’s build cool things and enjoy the ride!</em>
                        </p>
                    </div>

                    <div class="hero-cta-group">
                        <a href="#portofolio" class="btn btn-primary">
                            <span>▶ Jelajahi Proyek</span>
                        </a>
                        <a href="app/index.php" class="btn btn-primary">
                            <span>Buka Guestbook &nearr;</span>
                        </a>
                    </div>

                    <!-- Baris Lencana Statistik Horizontal -->
                    <div class="arcade-stat-pills" aria-label="Ringkasan Player">
                        <div class="telemetry-item stat-pill-box">
                            <span class="stat-pill-icon">🎮</span>
                            <div>
                                <span
                                    class="telemetry-val"><?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?></span>
                                <span class="telemetry-lbl">KELAS AKTIF</span>
                            </div>
                        </div>
                        <div class="telemetry-item stat-pill-box">
                            <span class="stat-pill-icon">🏆</span>
                            <div>
                                <span class="telemetry-val">04 WORLDS</span>
                                <span class="telemetry-lbl">PROYEK KARYA</span>
                            </div>
                        </div>
                        <div class="telemetry-item stat-pill-box">
                            <span class="stat-pill-icon">🛡️</span>
                            <div>
                                <span class="telemetry-val">GUARDIAN</span>
                                <span class="telemetry-lbl">INTELECTA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 2: PORTOFOLIO PROYEK (WORLD MAP SHOWCASE DENGAN BANNER SAMPING) -->
        <section id="portofolio" class="section-block section-alt">
            <div class="container">
                <div class="section-header section-header-centered">
                    <span class="section-tag">★ WORLD MAP // CLEARED STAGES</span>
                    <h2 class="section-title">Portofolio Proyek</h2>
                    <p class="section-subtitle">
                        Koleksi karya perangkat lunak dan desain antarmuka pilihan. Klik kartu level untuk membuka
                        rincian misi.
                    </p>

                    <!-- Filter Interaktif di Tengah (Opsional/Hidden) -->
                    <!-- Filter portofolio dihilangkan sesuai permintaan -->
                </div>

                <div class="portfolio-world-grid" id="portfolioGrid">
                    <?php foreach ($portfolios as $proj): ?>
                        <article class="tech-card portfolio-card world-stage-card"
                            data-category="<?= htmlspecialchars($proj['category'], ENT_QUOTES, 'UTF-8') ?>" tabindex="0"
                            role="button"
                            aria-label="Lihat rincian misi <?= htmlspecialchars($proj['title'], ENT_QUOTES, 'UTF-8') ?>">
                            <div class="world-stage-banner">
                                <div class="world-icon-badge"><?= $proj['icon'] ?></div>
                                <div class="world-stage-meta">
                                    <span
                                        class="mono-label"><?= htmlspecialchars($proj['id'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <span
                                        class="status-chip"><?= htmlspecialchars($proj['status'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            </div>

                            <div class="world-stage-body">
                                <h3 class="portfolio-title"><?= htmlspecialchars($proj['title'], ENT_QUOTES, 'UTF-8') ?>
                                </h3>
                                <p class="portfolio-subtitle">
                                    <?= htmlspecialchars($proj['subtitle'], ENT_QUOTES, 'UTF-8') ?></p>
                                <p class="portfolio-summary"><?= htmlspecialchars($proj['summary'], ENT_QUOTES, 'UTF-8') ?>
                                </p>

                                <ul class="spec-bullet-list portfolio-highlights">
                                    <?php foreach ($proj['highlights'] as $hl): ?>
                                        <li><?= htmlspecialchars($hl, ENT_QUOTES, 'UTF-8') ?></li>
                                    <?php endforeach; ?>
                                </ul>

                                <div class="world-stage-footer">
                                    <div class="tag-row">
                                        <?php foreach ($proj['tags'] as $tag): ?>
                                            <span class="tech-tag"><?= htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <span class="world-play-btn">DETAIL &rarr;</span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- SECTION 3: PENDIDIKAN & PENGALAMAN (JALUR TIMELINE VERTIKAL MARIO) -->
        <section id="pendidikan" class="section-block">
            <div class="container">
                <div class="section-header section-header-centered">
                    <span class="section-tag">★ QUEST LOG // JOURNEY PATH</span>
                    <h2 class="section-title">Pendidikan &amp; Pengalaman</h2>
                    <p class="section-subtitle">
                        Jejak perjalanan akademik di Telkom University dan kontribusi kepanitiaan kampus.
                    </p>
                </div>

                <div class="mario-timeline-track">
                    <!-- Stage 1: Pendidikan -->
                    <article class="tech-card timeline-card timeline-step-row">
                        <div class="timeline-step-badge">
                            <span class="step-icon">🎓</span>
                            <span class="mono-label">STAGE 01</span>
                            <span class="badge-route">2024 &mdash; SEKARANG</span>
                        </div>
                        <div class="timeline-step-content">
                            <h3 class="card-heading">S1 Informatika &mdash; Telkom University</h3>
                            <p class="card-sub">Kelas <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?> &bull;
                                Bandung</p>
                            <p class="card-desc">
                                Mendalami fondasi ilmu komputer, pemrograman berorientasi objek (Java), basis data
                                relasional MySQL, jaringan komputer, serta rekayasa web modern.
                            </p>
                            <ul class="spec-bullet-list">
                                <li>Anggota Node <code><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?></code>
                                    pada Proyek Aplikasi Guestbook Terdistribusi.</li>
                                <li>Fokus pada arsitektur perangkat lunak yang bersih, terstruktur, dan solutif.</li>
                            </ul>
                        </div>
                    </article>

                    <!-- Stage 2: Kepanitiaan INTELECTA -->
                    <article class="tech-card timeline-card timeline-step-row highlight-border">
                        <div class="timeline-step-badge">
                            <span class="step-icon">🛡️</span>
                            <span class="mono-label">STAGE 02</span>
                            <span class="badge-route">GUARDIAN FORCE</span>
                        </div>
                        <div class="timeline-step-content">
                            <h3 class="card-heading">Kepanitiaan INTELECTA</h3>
                            <p class="card-sub">Guardian Force &bull; Fakultas Informatika</p>
                            <p class="card-desc">
                                Berperan aktif sebagai Guardian Force dalam kepanitiaan INTELECTA untuk menjaga
                                kedisiplinan,
                                ketertiban, serta kelancaran jalannya rangkaian kegiatan.
                            </p>
                            <ul class="spec-bullet-list">
                                <li>Mengawal ketertiban, kedisiplinan peserta, dan kondusivitas selama acara
                                    berlangsung.</li>
                                <li>Berkoordinasi aktif dengan seluruh divisi kepanitiaan untuk pengamanan dan
                                    kelancaran kegiatan.</li>
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- SECTION 4: KEAHLIAN & TEKNOLOGI (POWER-UP INVENTORY SLOTS 2 KOLOM) -->
        <section id="keahlian" class="section-block section-alt">
            <div class="container">
                <div class="section-header section-header-centered">
                    <span class="section-tag">★ POWER-UP INVENTORY // TECH STACK</span>
                    <h2 class="section-title">Keahlian &amp; Teknologi</h2>
                    <p class="section-subtitle">
                        Perangkat teknologi andalan untuk membangun aplikasi web dan desain sistem yang rapi.
                    </p>
                </div>

                <div class="skills-inventory-grid">
                    <?php foreach ($skills as $skill): ?>
                        <article class="tech-card skill-card skill-slot-card">
                            <div class="skill-slot-icon" aria-hidden="true">
                                <?= $skill['icon'] ?>
                            </div>
                            <div class="skill-slot-body">
                                <div class="skill-slot-header">
                                    <div>
                                        <span
                                            class="mono-label"><?= htmlspecialchars($skill['category'], ENT_QUOTES, 'UTF-8') ?></span>
                                        <h3 class="skill-title"><?= htmlspecialchars($skill['name'], ENT_QUOTES, 'UTF-8') ?>
                                        </h3>
                                    </div>
                                    <span
                                        class="skill-level"><?= htmlspecialchars($skill['level'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                                <p class="skill-desc"><?= htmlspecialchars($skill['desc'], ENT_QUOTES, 'UTF-8') ?></p>
                                <div class="power-meter-track" aria-hidden="true">
                                    <div class="power-meter-fill"
                                        style="width: <?= htmlspecialchars($skill['meter'], ENT_QUOTES, 'UTF-8') ?>;"></div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- SECTION 5: KONTAK (HORIZONTAL SAVE POINT TILES) -->
        <section id="kontak" class="section-block">
            <div class="container">
                <div class="section-header section-header-centered">
                    <span class="section-tag">★ SAVE POINT // CONNECT</span>
                    <h2 class="section-title">Kontak &amp; Jejaring</h2>
                    <p class="section-subtitle">
                        Mari terhubung untuk kolaborasi proyek maupun kegiatan kampus. (Nomor kontak tidak
                        dipublikasikan untuk privasi).
                    </p>
                </div>

                <div class="contact-tiles-row">
                    <a href="mailto:dininadia2005@gmail.com" class="tech-card contact-card contact-tile-horizontal">
                        <div class="contact-tile-icon">💌</div>
                        <div class="contact-tile-info">
                            <span class="mono-label">EMAIL</span>
                            <h3 class="contact-title">Kirim Surat</h3>
                            <p class="contact-handle">dininadia2005@gmail.com</p>
                        </div>
                        <span class="contact-tile-arrow">&nearr;</span>
                    </a>

                    <a href="https://github.com/DiniNadia13" target="_blank" rel="noopener noreferrer"
                        class="tech-card contact-card contact-tile-horizontal">
                        <div class="contact-tile-icon">🐙</div>
                        <div class="contact-tile-info">
                            <span class="mono-label">GITHUB</span>
                            <h3 class="contact-title">Kode &amp; Proyek</h3>
                            <p class="contact-handle">github.com/DiniNadia13</p>
                        </div>
                        <span class="contact-tile-arrow">&nearr;</span>
                    </a>

                    <a href="https://www.linkedin.com/in/dini-nadia-mawaddah-098132405/" target="_blank"
                        rel="noopener noreferrer" class="tech-card contact-card contact-tile-horizontal">
                        <div class="contact-tile-icon">💼</div>
                        <div class="contact-tile-info">
                            <span class="mono-label">LINKEDIN</span>
                            <h3 class="contact-title">Jejaring Karir</h3>
                            <p class="contact-handle">linkedin.com/in/dini-nadia-mawaddah</p>
                        </div>
                        <span class="contact-tile-arrow">&nearr;</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Mini-Game Panggung Level Mario Bros Interaktif (Bisa Dimainkan!) -->
        <div class="mario-stage-scene" id="marioStageGame" aria-label="Mini-game panggung Super Mario">
            <!-- Panel Kontrol & Petunjuk Mini-Game -->
            <div class="container stage-game-hud">
                <div class="stage-game-info">
                    <span class="stage-game-badge">🎮 PLAYABLE STAGE</span>
                    <span class="stage-game-hint">Gunakan tombol <strong>◀ ▶</strong> / <strong>A D</strong> untuk jalan
                        &amp; <strong>SPASI / ▲</strong> untuk lompat!</span>
                </div>
                <div class="stage-game-controls">
                    <span class="stage-status-pill" id="stageGameStatus">READY!</span>
                    <button type="button" class="stage-ctrl-btn" id="btnMarioLeft" aria-label="Jalan ke kiri"
                        title="Jalan Kiri (A / ◀)">◀</button>
                    <button type="button" class="stage-ctrl-btn stage-ctrl-jump" id="btnMarioJump" aria-label="Lompat"
                        title="Lompat (Spasi / W / ▲)">LOMPAT ⏫</button>
                    <button type="button" class="stage-ctrl-btn" id="btnMarioRight" aria-label="Jalan ke kanan"
                        title="Jalan Kanan (D / ▶)">▶</button>
                    <button type="button" class="stage-ctrl-btn stage-ctrl-reset" id="btnMarioReset"
                        aria-label="Reset posisi Mario" title="Ulangi Posisi">🔄</button>
                </div>
            </div>

            <!-- Arena Permainan Mario -->
            <div class="container stage-objects" id="marioGameArena">
                <div class="stage-floating-platform" id="stagePlatform">
                    <span class="m-block m-brick" data-block="brick">🧱</span>
                    <span class="m-block m-qblock" data-block="qblock">?</span>
                    <span class="m-block m-brick" data-block="brick">🧱</span>
                    <span class="m-block m-qblock" data-block="qblock">?</span>
                    <span class="m-block m-brick" data-block="brick">🧱</span>
                </div>
                <div class="stage-ground-items">
                    <span class="stage-item stage-bush">🌳</span>
                    <span class="stage-item stage-shroom" data-collect="shroom" title="Ambil Super Mushroom!">🍄</span>
                    <div class="stage-pipe" data-obstacle="pipe">
                        <div class="pipe-top"></div>
                        <div class="pipe-body"></div>
                    </div>
                    <div class="stage-coins">
                        <span data-collect="coin">🪙</span>
                        <span data-collect="coin">🪙</span>
                        <span data-collect="coin">🪙</span>
                    </div>
                    <div class="stage-pipe pipe-short" data-obstacle="pipe">
                        <div class="pipe-top"></div>
                        <div class="pipe-body"></div>
                    </div>
                    <span class="stage-item stage-star" data-collect="star" title="Ambil Super Star!">⭐</span>
                    <span class="stage-item stage-castle" data-collect="castle" title="Masuk ke Kastil!">🏰</span>
                </div>

                <!-- Karakter Mario yang Bisa Dikendalikan Pemain -->
                <div class="playable-mario" id="playableMario" role="img" aria-label="Karakter Mario">
                    <span class="mario-power-tag" id="marioPowerTag">M3</span>
                    <div class="mario-sprite-body">
                        <span class="mario-cap-icon">🧢</span>
                        <span class="mario-char-icon">🏃‍♂️</span>
                    </div>
                    <span class="mario-run-dust">💨</span>
                </div>
            </div>
            <div class="mario-brick-ground"></div>
        </div>
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

            <h4
                style="font-size: 0.88rem; font-family: var(--font-pixel); margin-bottom: 0.5rem; color: var(--mario-yellow);">
                HIGHLIGHT FITUR:</h4>
            <ul class="spec-bullet-list" id="modalHighlights" style="margin-bottom: 1.25rem;"></ul>

            <h4
                style="font-size: 0.88rem; font-family: var(--font-pixel); margin-bottom: 0.5rem; color: var(--mario-yellow);">
                TEKNOLOGI:</h4>
            <div class="tag-row" id="modalTags"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container footer-inner">
            <div class="footer-brand">
                <span>⭐ <strong><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></strong>
                    (<?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?>)</span>
                <span>S1 Informatika Telkom University &bull; Kelas
                    <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="footer-links">
                <a href="#top">BACK TO TOP &uarr;</a>
                <a href="app/index.php">GUESTBOOK &nearr;</a>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js?v=25"></script>
</body>

</html>
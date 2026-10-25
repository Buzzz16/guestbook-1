<?php
declare(strict_types=1);

/**
 * Halaman Utama Personal Page (Root `personal/index.php`)
 * Mahasiswa : Zulfa Almajid Basyaasyah (Babas) - 103012400134
 * Kelas     : S1 Informatika Telkom University (IF-48-05)
 */

require_once __DIR__ . '/identity.php';

$skills = [
    [
        'name'     => 'Python',
        'category' => 'Backend & AI/Data',
        'level'    => 'Advanced',
        'desc'     => 'Scripting otomasi, pengolahan data, pemodelan AI/ML, dan pembuatan REST API cepat.',
        'code'     => 'PY-01',
    ],
    [
        'name'     => 'Java (Spring Boot)',
        'category' => 'Enterprise Backend',
        'level'    => 'Advanced',
        'desc'     => 'Arsitektur berlapis (Controller-Service-Repository), Spring Data JPA, keamanan, dan RESTful microservice.',
        'code'     => 'JV-02',
    ],
    [
        'name'     => 'Node.js',
        'category' => 'Runtime & API',
        'level'    => 'Intermediate',
        'desc'     => 'Backend asynchronous menggunakan Express.js untuk layanan real-time dan integrasi IoT/AI.',
        'code'     => 'ND-03',
    ],
    [
        'name'     => 'Vue.js',
        'category' => 'Frontend Reactive',
        'level'    => 'Intermediate',
        'desc'     => 'Single Page Application (SPA) reaktif, manajemen state komponen, dan visualisasi metrik interaktif.',
        'code'     => 'VU-04',
    ],
    [
        'name'     => 'Tailwind CSS',
        'category' => 'UI Engineering',
        'level'    => 'Advanced',
        'desc'     => 'Sistem desain utility-first yang responsif, dark-mode terstruktur, dan tipografi modern.',
        'code'     => 'TW-05',
    ],
    [
        'name'     => 'PostgreSQL',
        'category' => 'Relational DBMS',
        'level'    => 'Intermediate',
        'desc'     => 'Perancangan skema relasional, optimasi indexing, transaksi ACID, dan integrasi cloud (Supabase).',
        'code'     => 'PG-06',
    ],
];

$portfolios = [
    [
        'id'       => 'PRJ-01',
        'title'    => 'SuperKost',
        'subtitle' => 'Platform Manajemen Hunian Indekos Terpadu',
        'category' => 'backend',
        'tags'     => ['Java Spring Boot', 'MySQL', 'Thymeleaf / REST', 'MVC'],
        'year'     => '2025',
        'status'   => 'PRODUCTION READY',
        'summary'  => 'Web App berbasis Java Spring Boot & MySQL untuk mendigitalisasi pengelolaan kamar kos, pencatatan tagihan bulanan penghuni, manajemen ketersediaan unit real-time, serta pelaporan keuangan pemilik kos secara terstruktur.',
        'highlights' => [
            'Autentikasi berbasis role (Pemilik Kos & Penghuni)',
            'Manajemen transaksi sewa dan histori pembayaran otomatis',
            'Skema relasional MySQL dengan integritas referensial penuh',
        ],
    ],
    [
        'id'       => 'PRJ-02',
        'title'    => 'PoluSee',
        'subtitle' => 'AI-Powered Air Quality Monitoring Dashboard',
        'category' => 'ai-web',
        'tags'     => ['Vue.js', 'Express', 'Node.js', 'AI Forecasting'],
        'year'     => '2025',
        'status'   => 'PROTOTYPE DEPLOYED',
        'summary'  => 'Sistem pemantauan kualitas udara cerdas berbasis AI dengan antarmuka reaktif Vue.js dan backend Express. Menganalisis indeks polutan (PM2.5, PM10, CO, AQI) serta menyajikan prediksi kualitas udara dan rekomendasi kesehatan.',
        'highlights' => [
            'Visualisasi tren indeks kualitas udara (AQI) secara real-time',
            'Integrasi pipeline prediksi berbasis model Machine Learning',
            'REST API ringan dengan Express.js dan arsitektur modular',
        ],
    ],
    [
        'id'       => 'PRJ-03',
        'title'    => 'ChronosPlan',
        'subtitle' => 'Progressive Web App Countdown & Academic Schedule',
        'category' => 'fullstack',
        'tags'     => ['Next.js', 'Supabase', 'PostgreSQL', 'PWA'],
        'year'     => '2026',
        'status'   => 'ACTIVE RELEASE',
        'summary'  => 'Aplikasi Progressive Web App (PWA) pengatur jadwal dan hitung mundur (countdown) tenggat akademik menggunakan Next.js dan Supabase. Dapat diinstal di perangkat mobile maupun desktop dengan sinkronisasi cloud real-time.',
        'highlights' => [
            'Dukungan instalasi PWA & akses cepat jadwal perkuliahan/asistensi',
            'Database PostgreSQL real-time via Supabase dengan Row Level Security',
            'Antarmuka minimalis berfokus pada produktivitas mahasiswa',
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Personal Page Zulfa Almajid Basyaasyah (Babas) - Mahasiswa S1 Informatika Telkom University (IF-48-05) & Aplikasi Bersama Guestbook.">
    <title><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?> (Babas) // Personal Page &amp; Guestbook</title>
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
            <a href="#profil" class="brand-logo" aria-label="Beranda Zulfa Almajid Basyaasyah">
                <span class="brand-bracket">[</span>BABAS<span class="brand-accent">//</span><?= htmlspecialchars(MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') ?><span class="brand-bracket">]</span>
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
                    <li><a href="#kontak" class="nav-link">05. Kontak</a></li>
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
                                <p class="id-callsign">A.K.A. &ldquo;BABAS&rdquo; &bull; S1 Informatika Telkom University</p>
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
                                <div class="spec-row">
                                    <dt>PERAN AKADEMIK</dt>
                                    <dd class="mono-val highlight-val">Asisten Dosen (3 Kelas Informatika)</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <!-- SECTION 2: PENGALAMAN & PENDIDIKAN -->
        <section id="pendidikan" class="section-block section-alt">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">02 // </span>
                    <h2 class="section-title">Pendidikan &amp; Pengalaman Akademik</h2>
                    <p class="section-subtitle">
                        Rekam jejak akademik di Fakultas Informatika Telkom University serta kontribusi aktif dalam kegiatan pengajaran dan asistensi kelas.
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
                        <p class="card-sub">Kelas IF-48-05 &bull; Bandung, Jawa Barat</p>
                        <p class="card-desc">
                            Menempuh pendidikan sarjana pada Program Studi S1 Informatika dengan fokus pada algoritma, struktur data, rekayasa perangkat lunak berbasis objek, basis data relasional, serta pengembangan aplikasi web modern.
                        </p>
                        <ul class="spec-bullet-list">
                            <li>Ketua Kelompok (Node <code>m0</code>) pada Proyek Aplikasi Bersama Pra-UTS.</li>
                            <li>Aktif mengembangkan berbagai produk perangkat lunak mandiri (SuperKost, PoluSee, ChronosPlan).</li>
                        </ul>
                    </article>

                    <!-- Card Pengalaman Asisten Dosen -->
                    <article class="tech-card timeline-card highlight-border">
                        <div class="card-top-bar">
                            <span class="mono-label">EXP // TEACHING ASSISTANT</span>
                            <span class="badge-route">ACTIVE ROLE</span>
                        </div>
                        <h3 class="card-heading">Asisten Dosen (3 Kelas Informatika)</h3>
                        <p class="card-sub">Fakultas Informatika &bull; Telkom University</p>
                        <p class="card-desc">
                            Dipercaya sebagai Asisten Dosen yang mendampingi proses perkuliahan, sesi praktikum/responsi, evaluasi tugas pemrograman, serta pembimbingan teknis bagi mahasiswa di <strong>3 kelas Informatika</strong>.
                        </p>
                        <ul class="spec-bullet-list">
                            <li>Memfasilitasi diskusi pemecahan masalah algoritma dan debugging kode secara terstruktur.</li>
                            <li>Menyusun materi asistensi, melakukan code review tugas mahasiswa, dan menjaga standar kualitas akademik.</li>
                            <li>Berkoordinasi langsung dengan dosen pengampu untuk pemantauan progres belajar di 3 kelas paralel.</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <!-- SECTION 3: KEAHLIAN (SKILLS) -->
        <section id="keahlian" class="section-block">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">03 // </span>
                    <h2 class="section-title">Keahlian &amp; Teknologi</h2>
                    <p class="section-subtitle">
                        Tumpukan teknologi utama yang saya gunakan dalam merancang sistem backend, antarmuka frontend modern, serta manajemen basis data.
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
                        <span class="section-tag">04 // </span>
                        <h2 class="section-title">Portofolio Proyek</h2>
                        <p class="section-subtitle">
                            Kumpulan proyek perangkat lunak yang dibangun menggunakan Java Spring Boot, Vue.js, Express, Next.js, dan Supabase.
                        </p>
                    </div>

                    <!-- Filter Interaktif via assets/js/main.js -->
                    <div class="portfolio-filters" role="group" aria-label="Filter kategori portofolio">
                        <button type="button" class="filter-btn active" data-filter="all">Semua (3)</button>
                        <button type="button" class="filter-btn" data-filter="backend">Spring Boot &amp; SQL</button>
                        <button type="button" class="filter-btn" data-filter="ai-web">AI &amp; Vue/Express</button>
                        <button type="button" class="filter-btn" data-filter="fullstack">Next.js &amp; Supabase</button>
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

        <!-- SECTION 5: KONTAK (TANPA NOMOR TELEPON) -->
        <section id="kontak" class="section-block section-alt">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">05 // COMMUNICATION CHANNELS</span>
                    <h2 class="section-title">Kontak &amp; Jejaring Profesional</h2>
                    <p class="section-subtitle">
                        Terbuka untuk diskusi seputar kolaborasi proyek perangkat lunak, riset informatika, maupun kegiatan akademik. (Sesuai kebijakan privasi, nomor telepon tidak dicantumkan di laman publik).
                    </p>
                </div>

                <div class="contact-grid">
                    <a href="mailto:zulfaalmajid@student.telkomuniversity.ac.id" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">CHANNEL // 01</span>
                            <span class="contact-arrow">&nearr;</span>
                        </div>
                        <h3 class="contact-title">Email Akademik &amp; Pribadi</h3>
                        <p class="contact-handle">zulfaalmajid@student.telkomuniversity.ac.id</p>
                        <span class="contact-hint">Kirim pesan elektronik resmi</span>
                    </a>

                    <a href="https://github.com/Buzzz16" target="_blank" rel="noopener noreferrer" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">CHANNEL // 02</span>
                            <span class="contact-arrow">&nearr;</span>
                        </div>
                        <h3 class="contact-title">GitHub Repository</h3>
                        <p class="contact-handle">Buzzz16</p>
                        <span class="contact-hint">Lihat repositori kode &amp; proyek open-source</span>
                    </a>

                    <a href="https://linkedin.com/in/zulfaalmajid-babas" target="_blank" rel="noopener noreferrer" class="tech-card contact-card">
                        <div class="card-top-bar">
                            <span class="mono-label">CHANNEL // 03</span>
                            <span class="contact-arrow">&nearr;</span>
                        </div>
                        <h3 class="contact-title">LinkedIn Profile</h3>
                        <p class="contact-handle">linkedin.com/in/zulfa-almajid-basyaasyah</p>
                        <span class="contact-hint">Jejaring profesional &amp; rekam jejak karier</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Semantic HTML5 -->
    <footer class="site-footer">
        <div class="container footer-inner">
            <div class="footer-brand">
                <span class="mono-small"><strong><?= htmlspecialchars(MEMBER_NAMA, ENT_QUOTES, 'UTF-8') ?></strong> (<?= htmlspecialchars(MEMBER_NIM, ENT_QUOTES, 'UTF-8') ?>)</span>
                <span class="mono-small">S1 Informatika Telkom University &bull; Kelas <?= htmlspecialchars(MEMBER_KELAS, ENT_QUOTES, 'UTF-8') ?></span>
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

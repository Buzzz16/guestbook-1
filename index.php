<?php
// index.php - Personal Page Individu (Meyneza Ari Dwi Astuti - 103012400299)
require_once __DIR__ . '/identity.php';

$currentRoute = defined('MEMBER_ROUTE') ? MEMBER_ROUTE : 'm2';
$currentNama  = defined('MEMBER_NAMA')  ? MEMBER_NAMA  : 'Meyneza Ari Dwi Astuti';
$currentNim   = defined('MEMBER_NIM')   ? MEMBER_NIM   : '103012400299';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio — <?= htmlspecialchars($currentNama, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($currentNim, ENT_QUOTES, 'UTF-8') ?>)</title>
    <meta name="description" content="Personal Page & Portofolio Meyneza Ari Dwi Astuti (Nejaa) — Graphic Designer & UI/UX Designer S1 Informatika Telkom University.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=5">
</head>
<body>
    <!-- Banner Wajib dari app/partials/served_by.php (dengan fallback aman jika folder app/ belum di-clone) -->
    <?php
    $servedByPath = __DIR__ . '/app/partials/served_by.php';
    if (file_exists($servedByPath)) {
        include $servedByPath;
    } else {
        ?>
        <div class="served-by-banner" role="status" aria-live="polite">
            <div class="served-by-inner">
                <span class="served-by-dot" aria-hidden="true"></span>
                <span class="served-by-text">
                    Anda dilayani oleh laman <strong><?= htmlspecialchars($currentNama, ENT_QUOTES, 'UTF-8') ?></strong> (<strong><?= htmlspecialchars($currentNim, ENT_QUOTES, 'UTF-8') ?></strong>)
                </span>
                <span class="served-by-route">Route: <code><?= htmlspecialchars($currentRoute, ENT_QUOTES, 'UTF-8') ?></code></span>
            </div>
        </div>
        <?php
    }
    ?>

    <!-- Scalloped Stamp Border Atas (Khas Desain Canva Nejaa) -->
    <div class="scallop-border scallop-top" aria-hidden="true"></div>

    <!-- Header & Navigasi Semantik -->
    <header class="site-header">
        <nav class="navbar container" aria-label="Navigasi Utama">
            <a href="#hero" class="brand-logo">
                <span class="brand-badge">NEJAA</span>
                <span class="brand-sub">meynezaaaari</span>
            </a>

            <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" aria-expanded="false" aria-controls="mainNavLinks" aria-label="Buka menu navigasi">
                ☰
            </button>

            <ul class="nav-links" id="mainNavLinks">
                <li><a href="#about">About</a></li>
                <li><a href="#education">Education &amp; Exp</a></li>
                <li><a href="#skills">Skills</a></li>
                <li><a href="#portfolio">Projects</a></li>
                <li><a href="#social">Socials</a></li>
                <li><a href="app/index.php" class="nav-app-pill">🚀 Aplikasi Bersama</a></li>
            </ul>

            <div class="nav-actions">
                <button type="button" id="themeToggleBtn" class="btn-sticker btn-theme" aria-label="Ganti Mode Gelap atau Terang">
                    <span class="theme-icon">🌙</span> <span class="theme-label">Night Mode</span>
                </button>
            </div>
        </nav>
    </header>

    <main>
        <!-- =================================================================
             1. HERO SECTION — RETRO PAINT WINDOW + CLIPBOARD + TAMAGOTCHI
             ================================================================= -->
        <section id="hero" class="hero-section container section-pad">
            <div class="paint-window-frame reveal-on-scroll">
                <!-- Window Top Bar (Bersih seperti Slide 1 Canva) -->
                <div class="paint-window-topbar">
                    <div class="topbar-dots" aria-hidden="true"></div>
                    <div class="paint-win-buttons" aria-hidden="true">
                        <span class="p-btn">_</span>
                        <span class="p-btn">□</span>
                        <span class="p-btn">×</span>
                    </div>
                </div>

                <!-- Window Middle Workspace -->
                <div class="paint-window-workspace">
                    <!-- Left Yellow-Green Paint Toolbar (Persis Slide 1 Canva) -->
                    <aside class="paint-toolbar" aria-label="Dekorasi Alat Desain Interaktif">
                        <button type="button" class="tool-btn active" data-tool="Airbrush &amp; Illustration Mode aktif! ✨" title="Brush Tool">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <path d="M18.37 2.63 14 7l-1.59-1.59a2 2 0 0 0-2.82 0L8 7l9 9 1.59-1.59a2 2 0 0 0 0-2.82L17 10l4.37-4.37a2.12 2.12 0 1 0-3-3Z"/>
                                <path d="M9 8c-2 3-4 3.5-7 4l8 10c2-1 6-5 6-7"/>
                            </svg>
                        </button>
                        <button type="button" class="tool-btn" data-tool="Select &amp; Move Sticker aktif! ↖️" title="Cursor Select Tool">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M4 3l16 7.5-7.2 2.1L9.5 20 4 3z"/>
                            </svg>
                        </button>
                        <button type="button" class="tool-btn" data-tool="Color Palette Periwinkle &amp; Tangerine aktif! 🎨" title="Paint Bucket Tool">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <path d="m19 11-8-8-8.6 8.6a2 2 0 0 0 0 2.8l5.2 5.2c.8.8 2 .8 2.8 0L19 11Z"/>
                                <path d="m5 2 5 5"/><path d="M2 13h15"/><path d="M22 20a2 2 0 1 1-4 0c0-1.6 1.7-2.4 2-4 .3 1.6 2 2.4 2 4Z"/>
                            </svg>
                        </button>
                        <button type="button" class="tool-btn tool-letter" data-tool="Editorial &amp; Ransom Typography aktif! 🅰️" title="Typography Tool">
                            A
                        </button>
                        <div class="tool-swatches" title="Warna Tema Nejaa">
                            <span class="swatch-blue"></span>
                            <span class="swatch-orange"></span>
                        </div>
                    </aside>

                    <!-- Main Cream Canvas Area -->
                    <div class="paint-canvas-stage">
                        <!-- Floating Glossy Bubbles -->
                        <span class="gloss-bubble b1" aria-hidden="true"></span>
                        <span class="gloss-bubble b2" aria-hidden="true"></span>
                        <span class="gloss-bubble b3" aria-hidden="true"></span>
                        <span class="gloss-bubble b4" aria-hidden="true"></span>

                        <!-- Grid Notebook Paper Card with Metal Clip -->
                        <div class="notebook-sheet">
                            <!-- Metal Bulldog Clip (SVG) -->
                            <div class="bulldog-clip" aria-hidden="true">
                                <svg viewBox="0 0 120 110" width="105" height="96">
                                    <defs>
                                        <linearGradient id="metalGrad" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#E8EAEE"/>
                                            <stop offset="45%" stop-color="#9FA4AE"/>
                                            <stop offset="75%" stop-color="#5E636E"/>
                                            <stop offset="100%" stop-color="#C8CCD4"/>
                                        </linearGradient>
                                    </defs>
                                    <circle cx="60" cy="26" r="22" fill="url(#metalGrad)" stroke="#444852" stroke-width="3"/>
                                    <circle cx="60" cy="26" r="9" fill="#FFF7EC" stroke="#444852" stroke-width="2.5"/>
                                    <path d="M36 42 L84 42 L94 74 L26 74 Z" fill="url(#metalGrad)" stroke="#444852" stroke-width="3"/>
                                    <rect x="14" y="68" width="92" height="28" rx="7" fill="url(#metalGrad)" stroke="#383B44" stroke-width="3"/>
                                    <line x1="22" y1="82" x2="98" y2="82" stroke="#D9DCE2" stroke-width="3"/>
                                </svg>
                            </div>

                            <!-- Quote Sticker Marks -->
                            <div class="quote-marks-sticker" aria-hidden="true">””</div>

                            <!-- Ransom / Cutout Title MEYNEZA ARI -->
                            <h1 class="ransom-portfolio-title" aria-label="MEYNEZA ARI">
                                <span class="ransom-word">
                                    <span class="r-char c1">M</span>
                                    <span class="r-char c2">E</span>
                                    <span class="r-char c3">Y</span>
                                    <span class="r-char c4">N</span>
                                    <span class="r-char c5">E</span>
                                    <span class="r-char c6">Z</span>
                                    <span class="r-char c7">A</span>
                                </span>
                                <span class="ransom-word">
                                    <span class="r-char c8">A</span>
                                    <span class="r-char c9">R</span>
                                    <span class="r-char c10">i</span>
                                </span>
                            </h1>

                            <!-- Graphic Designer + UI/UX Designer Stickers -->
                            <div class="hero-stickers-cluster">
                                <div class="graphic-designer-sticker">
                                    <span class="gd-text">GRAPHIC<br>DESIGNER</span>
                                    <span class="gd-starburst" aria-hidden="true">✴</span>
                                </div>
                                <div class="orange-tape-sticker">
                                    <span class="dots-strip" aria-hidden="true">••••</span>
                                    <span class="sub-role-text">UI/UX DESIGNER</span>
                                </div>
                                <div class="exclamation-sticker" aria-hidden="true">!</div>
                            </div>

                            <!-- Gold Peel Sticker Bottom Left -->
                            <div class="gold-peel-sticker" aria-hidden="true">✦</div>
                        </div>

                        <!-- Hanging Tamagotchi Keychain (Persis Slide 1 Canva) -->
                        <div class="tamagotchi-wrapper" id="tamagotchiCharm" title="Klik aku untuk sapaan dari Nejaa!">
                            <div class="ball-chain" aria-hidden="true">
                                <span></span><span></span><span></span><span></span><span></span><span></span>
                            </div>
                            <div class="tama-body">
                                <span class="tama-star s1" aria-hidden="true">★</span>
                                <span class="tama-star s2" aria-hidden="true">★</span>
                                <span class="tama-star s3" aria-hidden="true">★</span>
                                <span class="tama-star s4" aria-hidden="true">★</span>
                                <div class="tama-screen">
                                    <img src="assets/img/profile-nejaa.png" alt="Foto Profil Meyneza Ari Dwi Astuti (Nejaa)">
                                </div>
                                <div class="tama-nameplate">NEJAA</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Window Bottom Orange Bar -->
                <div class="paint-window-bottombar">
                    <div class="bottombar-left">
                        <span class="hamburger-deco" aria-hidden="true">☰</span>
                        <div class="username-pill" id="toolbarStatusText">meynezaaaari — <?= htmlspecialchars($currentNama, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($currentNim, ENT_QUOTES, 'UTF-8') ?>)</div>
                    </div>
                    <div class="bottombar-right">
                        <a href="#portfolio" class="btn-mini-action">Lihat Portofolio ↓</a>
                        <a href="#shared-app" class="btn-mini-action btn-mini-lime">Aplikasi Bersama →</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- =================================================================
             2. ABOUT ME ("HELLOWWRR!") — PERSIS SLIDE 2 CANVA
             ================================================================= -->
        <section id="about" class="about-section container section-pad">
            <div class="scrapbook-card reveal-on-scroll">
                <div class="about-grid">
                    <!-- Left: Postage Stamp Portrait -->
                    <div class="about-photo-col">
                        <div class="stamp-photo-wrapper">
                            <img src="assets/img/profile-stamp.png" alt="Potret Meyneza Ari Dwi Astuti dalam bingkai prangko biru" class="stamp-img">
                        </div>
                    </div>

                    <!-- Right: HELLOWWRR! Bio & Social Speech Bubbles -->
                    <div class="about-content-col">
                        <div class="hello-header-row">
                            <div class="hello-title-wrap">
                                <span class="red-comic-burst" aria-hidden="true">💥</span>
                                <h2 class="hello-heading">HELLOWWRR!</h2>
                            </div>
                            <button type="button" id="bioLangToggle" class="btn-sticker" title="Ganti bahasa deskripsi singkat">
                                🌐 Bahasa: <span id="bioLangLabel">EN + ID</span>
                            </button>
                        </div>

                        <!-- Identity Badges Wajib (Nama, NIM, Route) -->
                        <div class="identity-chips">
                            <span class="id-chip chip-blue">👩‍💻 <?= htmlspecialchars($currentNama, ENT_QUOTES, 'UTF-8') ?> (Nejaa)</span>
                            <span class="id-chip chip-orange">🎓 NIM: <?= htmlspecialchars($currentNim, ENT_QUOTES, 'UTF-8') ?></span>
                            <span class="id-chip chip-lime">🖧 Server Route: <?= htmlspecialchars($currentRoute, ENT_QUOTES, 'UTF-8') ?></span>
                        </div>

                        <div class="bio-paragraphs" id="bioTextContainer">
                            <p class="bio-en">
                                Hii my name is <strong><?= htmlspecialchars($currentNama, ENT_QUOTES, 'UTF-8') ?></strong>, but you can call me <strong>Nejaa</strong>. I'm 19 years old and I am a <strong>Graphic Designer &amp; UI/UX Designer</strong> majoring in <strong>S1 Informatics at Telkom University</strong>.
                            </p>
                            <p class="bio-en">
                                I have 1+ year of experience in graphic design and UI/UX design, with creative and innovative abilities that make me used to being responsible in visual design and digital product creation. I am receptive to new insights and experiences, and I am also willing to take on new challenges, work under pressure, and adapt quickly.
                            </p>
                            <p class="bio-id">
                                <em>(Halo! Saya mahasiswi S1 Informatika Telkom University dengan fokus pada Graphic Design dan UI/UX Design. Terbiasa merancang identitas visual kreatif serta antarmuka produk digital yang modern.)</em>
                            </p>
                        </div>

                        <!-- Yellow Crosshatch Speech-Bubble Social Pills (Persis Slide 2 Canva) -->
                        <div class="social-bubbles-grid" aria-label="Tautan Media Sosial dan Email">
                            <a href="https://instagram.com/meynezaaaari" target="_blank" rel="noopener noreferrer" class="speech-pill">
                                <span class="pill-star" aria-hidden="true">★</span>
                                <span class="pill-icon ig-icon" aria-hidden="true">📸</span>
                                <span class="pill-text">meynezaaaari</span>
                            </a>

                            <a href="https://www.youtube.com/@meynezaari8718" target="_blank" rel="noopener noreferrer" class="speech-pill">
                                <span class="pill-star" aria-hidden="true">★</span>
                                <span class="pill-icon yt-icon" aria-hidden="true">▶️</span>
                                <span class="pill-text">Meyneza Ari</span>
                            </a>

                            <a href="https://www.tiktok.com/@nezcoffiee" target="_blank" rel="noopener noreferrer" class="speech-pill">
                                <span class="pill-star" aria-hidden="true">★</span>
                                <span class="pill-icon tt-icon" aria-hidden="true">🎵</span>
                                <span class="pill-text">nezcoffiee</span>
                            </a>

                            <a href="mailto:meinesaari@gmail.com" class="speech-pill">
                                <span class="pill-star" aria-hidden="true">★</span>
                                <span class="pill-icon gm-icon" aria-hidden="true">✉️</span>
                                <span class="pill-text">meinesaari@gmail.com</span>
                            </a>
                        </div>

                        <div class="linkedin-bar">
                            <span class="linkedin-badge">Linked<span>in</span></span>
                            <a href="https://www.linkedin.com/in/meyneza-ari" target="_blank" rel="noopener noreferrer" class="linkedin-url">
                                https://www.linkedin.com/in/meyneza-ari
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =================================================================
             3. EDUCATION & EXPERIENCE — SLIDE 3 CANVA + CV ORGANISASI
             ================================================================= -->
        <section id="education" class="edu-exp-section container section-pad">
            <div class="scrapbook-card reveal-on-scroll">
                <div class="edu-exp-grid">
                    <!-- Left Column: Education + Highlighted Organization Roles (From CV Image) -->
                    <div class="edu-col">
                        <div class="speech-header-banner">
                            <span class="banner-star" aria-hidden="true">★</span>
                            <h2>Education</h2>
                        </div>

                        <div class="retro-timeline">
                            <div class="timeline-item">
                                <span class="arrow-bullet" aria-hidden="true">↗</span>
                                <div class="timeline-body">
                                    <span class="timeline-year">2024 – Sekarang</span>
                                    <h3 class="timeline-title">Telkom University</h3>
                                    <p class="timeline-desc">S1 Informatika (Informatics) — NIM <?= htmlspecialchars($currentNim, ENT_QUOTES, 'UTF-8') ?></p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <span class="arrow-bullet" aria-hidden="true">↗</span>
                                <div class="timeline-body">
                                    <span class="timeline-year">2021 – 2024</span>
                                    <h3 class="timeline-title">SMAN 01 TUMIJAJAR</h3>
                                    <p class="timeline-desc">Jurusan IPA</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Organization Experience from CV Image -->
                        <div class="speech-header-banner mt-lg">
                            <span class="banner-star" aria-hidden="true">★</span>
                            <h2>Pengalaman Organisasi</h2>
                        </div>

                        <div class="org-cards-stack">
                            <article class="org-detail-card">
                                <div class="org-card-header">
                                    <div>
                                        <h3>Himpunan Mahasiswa S1 Informatika – Telkom University</h3>
                                        <p class="org-role-badge">Staf Ahli Divisi Akademik</p>
                                    </div>
                                    <span class="org-date-pill">Maret 2026 – Sekarang</span>
                                </div>
                                <ul class="org-bullet-list">
                                    <li>Berkontribusi dalam perencanaan dan pelaksanaan program kerja Divisi Akademik untuk mendukung pengembangan kompetensi akademik mahasiswa.</li>
                                    <li>Bertanggung jawab sebagai <strong>Person in Charge (PIC)</strong> program kerja <strong>Hackathon</strong>, mulai dari tahap perencanaan, koordinasi, hingga pelaksanaan kegiatan.</li>
                                    <li>Berkolaborasi dengan pengurus dan pihak terkait untuk memastikan setiap rangkaian kegiatan berjalan sesuai rencana.</li>
                                </ul>
                            </article>

                            <article class="org-detail-card">
                                <div class="org-card-header">
                                    <div>
                                        <h3>Kreatif – Hello World 2025</h3>
                                        <p class="org-role-badge">Divisi Kreatif</p>
                                    </div>
                                    <span class="org-date-pill">Mei 2025 – September 2025</span>
                                </div>
                                <ul class="org-bullet-list">
                                    <li>Berkontribusi dalam Divisi Kreatif dengan merancang dan menghasilkan berbagai materi visual untuk mendukung kebutuhan acara.</li>
                                    <li>Membuat konten kreatif dan media publikasi guna meningkatkan keterlibatan peserta serta memperkuat branding acara.</li>
                                    <li>Berkolaborasi dengan anggota divisi lain untuk memastikan seluruh kebutuhan desain dan publikasi selesai tepat waktu.</li>
                                </ul>
                            </article>
                        </div>
                    </div>

                    <!-- Right Column: Complete Experience & Achievements Timeline (Persis Slide 3 Canva) -->
                    <div class="exp-col">
                        <div class="speech-header-banner">
                            <span class="banner-star" aria-hidden="true">★</span>
                            <h2>Experience</h2>
                        </div>

                        <div class="retro-timeline">
                            <div class="timeline-item">
                                <span class="arrow-bullet" aria-hidden="true">↗</span>
                                <div class="timeline-body">
                                    <span class="timeline-year">2025 – Sekarang</span>
                                    <h3 class="timeline-title">Prada 1447H</h3>
                                    <p class="timeline-desc">Departemen Media Bidang Desain</p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <span class="arrow-bullet" aria-hidden="true">↗</span>
                                <div class="timeline-body">
                                    <span class="timeline-year">Juni 2025 – September 2025</span>
                                    <h3 class="timeline-title">Hello World 2025</h3>
                                    <p class="timeline-desc">Divisi Creative — Visual Branding &amp; Publikasi Acara</p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <span class="arrow-bullet" aria-hidden="true">↗</span>
                                <div class="timeline-body">
                                    <span class="timeline-year">November 2024 – Januari 2025</span>
                                    <h3 class="timeline-title">Finalis ADIKARA (Ajang Digital Kreatif dan Inovasi Informatika)</h3>
                                    <p class="timeline-desc">Divisi Lomba Inovasi</p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <span class="arrow-bullet" aria-hidden="true">↗</span>
                                <div class="timeline-body">
                                    <span class="timeline-year">2023</span>
                                    <h3 class="timeline-title">Karya Ilmiah Remaja (KIR)</h3>
                                    <p class="timeline-desc">Kepala Bidang Kimia</p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <span class="arrow-bullet" aria-hidden="true">↗</span>
                                <div class="timeline-body">
                                    <span class="timeline-year">2022</span>
                                    <h3 class="timeline-title">Juara 3 OSN-Kabupaten/Kota</h3>
                                    <p class="timeline-desc">Bidang Kimia</p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <span class="arrow-bullet" aria-hidden="true">↗</span>
                                <div class="timeline-body">
                                    <span class="timeline-year">2022</span>
                                    <h3 class="timeline-title">Rohis</h3>
                                    <p class="timeline-desc">Bidang Keterampilan dan Kewirausahaan</p>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Starburst from Slide 3 -->
                        <div class="starburst-deco-box" aria-hidden="true">
                            <span class="burst-big">✸</span>
                            <span class="burst-text">CREATIVE • ACADEMIC • INNOVATIVE</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =================================================================
             4. SKILLS (SOFTWARE, TECH STACK & PERSONAL SKILLS) — SLIDE 3 CANVA
             ================================================================= -->
        <section id="skills" class="skills-section container section-pad">
            <div class="scrapbook-card reveal-on-scroll">
                <div class="skills-layout-grid">
                    <!-- Technical: Creative Software + Development Stack -->
                    <div class="skills-panel">
                        <div class="speech-header-banner">
                            <span class="banner-star" aria-hidden="true">★</span>
                            <h2>Software &amp; Tech Skills</h2>
                        </div>
                        <p class="skills-caption">Keahlian Teknis (Desain Grafis, UI/UX, dan Pengembangan Aplikasi Web):</p>

                        <!-- 4 App Icons from Canva Slide 3 -->
                        <div class="software-icons-row">
                            <div class="app-icon-card">
                                <div class="app-badge app-canva">Canva</div>
                                <span>Canva</span>
                            </div>
                            <div class="app-icon-card">
                                <div class="app-badge app-figma">
                                    <span class="fg-dot d1"></span><span class="fg-dot d2"></span>
                                    <span class="fg-dot d3"></span><span class="fg-dot d4"></span>
                                    <span class="fg-dot d5"></span>
                                </div>
                                <span>Figma</span>
                            </div>
                            <div class="app-icon-card">
                                <div class="app-badge app-ibis">ibis</div>
                                <span>ibisPaint X</span>
                            </div>
                            <div class="app-icon-card">
                                <div class="app-badge app-capcut">✂</div>
                                <span>CapCut</span>
                            </div>
                        </div>

                        <!-- Programming & Engineering Stack -->
                        <h3 class="sub-skill-heading">💻 Web &amp; UI/UX</h3>
                        <div class="tech-tags-cloud">
                            <span class="tech-pill">UI/UX Wireframing &amp; Prototyping</span>
                            <span class="tech-pill">Next.js &amp; React</span>
                            <span class="tech-pill">TypeScript &amp; JavaScript</span>
                            <span class="tech-pill">Tailwind CSS &amp; HTML5/CSS3</span>
                            <span class="tech-pill">Java Spring Boot &amp; JWT</span>
                        </div>
                    </div>

                    <!-- Non-Technical: Personal Skills Stickers (Persis Slide 3 Canva) -->
                    <div class="skills-panel">
                        <div class="speech-header-banner">
                            <span class="banner-star" aria-hidden="true">★</span>
                            <h2>Personal Skills</h2>
                        </div>
                        <p class="skills-caption">Keahlian Non-Teknis (Soft Skills dalam Tim, Organisasi, dan Kepanitiaan):</p>

                        <div class="personal-stickers-stage">
                            <div class="p-sticker st-red tilt-left">
                                <span>team<br>work</span>
                            </div>
                            <div class="p-sticker st-purple-lime tilt-right">
                                <span>creativity</span>
                            </div>
                            <div class="p-sticker st-red tilt-left-sm">
                                <span>time<br>management</span>
                            </div>
                            <div class="p-sticker st-orange tilt-right-sm">
                                <span>adaptability &amp;<br>work under pressure</span>
                            </div>
                            <div class="p-sticker st-blue-yellow tilt-left">
                                <span>event &amp; project<br>coordination (PIC)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =================================================================
             5. PORTFOLIO PROJECTS (3 TECH/UI PROJECTS + GRAPHIC DESIGN)
             ================================================================= -->
        <section id="portfolio" class="portfolio-section container section-pad">
            <div class="scrapbook-card reveal-on-scroll">
                <div class="portfolio-top-header">
                    <div>
                        <span class="sticker-pill-yellow">PORTOFOLIO PROYEK &amp; KARYA</span>
                        <h2 class="section-heading">Projects &amp; Design Works</h2>
                        <p class="section-subtitle">
                            Klik filter kategori di bawah ini atau klik tombol <strong>Lihat Detail Lengkap</strong> untuk membuka galeri modal interaktif.
                        </p>
                    </div>

                    <!-- Interactive JS Filter Buttons -->
                    <div class="portfolio-filters" role="tablist" aria-label="Filter Kategori Portofolio">
                        <button type="button" class="filter-btn active" data-filter="all">Semua (4)</button>
                        <button type="button" class="filter-btn" data-filter="uiux">UI/UX Design</button>
                        <button type="button" class="filter-btn" data-filter="fullstack">Web Application</button>
                        <button type="button" class="filter-btn" data-filter="graphic">Graphic Design</button>
                    </div>
                </div>

                <!-- Grid 4 Item Portofolio -->
                <div class="portfolio-grid" id="portfolioGrid">
                    <!-- Project 1: RemindMe (Gambar Asli dari User) -->
                    <article class="project-card" data-category="fullstack">
                        <div class="project-img-wrap">
                            <img src="assets/img/project-remindme.jpg?v=4" alt="Tampilan Aplikasi Manajemen Tugas RemindMe" loading="lazy">
                            <span class="project-cat-badge badge-blue">Web App Development</span>
                        </div>
                        <div class="project-card-body">
                            <h3 class="project-title">RemindMe – Aplikasi Manajemen Tugas</h3>
                            <p class="project-summary">
                                Aplikasi manajemen tugas berbasis web menggunakan <strong>Next.js</strong> sebagai frontend dan <strong>Java Spring Boot</strong> sebagai backend, dilengkapi autentikasi JWT &amp; Spring Security.
                            </p>
                            <div class="project-stack-mini">
                                <span>Next.js</span>
                                <span>Spring Boot</span>
                                <span>JWT</span>
                                <span>React &amp; TS</span>
                                <span>Tailwind CSS</span>
                                <span>MySQL</span>
                            </div>
                            <button
                                type="button"
                                class="btn-retro-blue btn-open-modal"
                                data-title="RemindMe – Aplikasi Manajemen Tugas"
                                data-role="Web Developer"
                                data-img="assets/img/project-remindme.jpg?v=4"
                                data-stack="Next.js, React, TypeScript, Tailwind CSS, Java Spring Boot, Spring Security, JWT, MySQL, Spring Data JPA"
                                data-points="Mengembangkan aplikasi manajemen tugas berbasis web menggunakan Next.js sebagai frontend dan Java Spring Boot sebagai backend.|Mengimplementasikan autentikasi dan otorisasi pengguna menggunakan JWT dan Spring Security.|Membangun antarmuka pengguna yang responsif dan interaktif menggunakan React, TypeScript, dan Tailwind CSS.|Merancang dan mengelola basis data relasional menggunakan MySQL dan Spring Data JPA.|Berkolaborasi dalam proses perancangan, pengembangan, pengujian, dan integrasi aplikasi."
                            >
                                🔍 Lihat Detail Lengkap
                            </button>
                        </div>
                    </article>

                    <!-- Project 2: ReuseId (Gambar Asli dari User) -->
                    <article class="project-card" data-category="fullstack">
                        <div class="project-img-wrap">
                            <img src="assets/img/project-reuseid.png?v=4" alt="Tampilan Aplikasi ReuseId Platform Pengelolaan dan Daur Ulang Sampah" loading="lazy">
                            <span class="project-cat-badge badge-lime">Front-End Developer</span>
                        </div>
                        <div class="project-card-body">
                            <h3 class="project-title">ReuseId – Platform Pengelolaan dan Daur Ulang Sampah</h3>
                            <p class="project-summary">
                                Platform berbasis web yang bertujuan mendukung pengelolaan serta daur ulang sampah secara berkelanjutan dengan tampilan frontend yang responsif di berbagai perangkat.
                            </p>
                            <div class="project-stack-mini">
                                <span>Front-End Web</span>
                                <span>Responsive Design</span>
                            </div>
                            <button
                                type="button"
                                class="btn-retro-blue btn-open-modal"
                                data-title="ReuseId – Platform Pengelolaan dan Daur Ulang Sampah"
                                data-role="Front-End Developer"
                                data-img="assets/img/project-reuseid.png?v=4"
                                data-stack="Front-End Web Development, Responsive Layout"
                                data-points="Merancang dan mengembangkan platform berbasis web yang bertujuan mendukung pengelolaan serta daur ulang sampah secara berkelanjutan.|Mengembangkan tampilan frontend yang responsif agar dapat diakses dengan baik di berbagai perangkat.|Berkolaborasi dengan anggota tim dalam mengimplementasikan desain menjadi aplikasi yang fungsional."
                            >
                                🔍 Lihat Detail Lengkap
                            </button>
                        </div>
                    </article>

                    <!-- Project 3: iGracias Redesign (Gambar Asli dari User) -->
                    <article class="project-card" data-category="uiux">
                        <div class="project-img-wrap">
                            <img src="assets/img/project-igracias.png?v=4" alt="Tampilan Redesign Portal Akademik iGracias Telkom University" loading="lazy">
                            <span class="project-cat-badge badge-orange">UI/UX Designer</span>
                        </div>
                        <div class="project-card-body">
                            <h3 class="project-title">iGracias – Redesign Portal Akademik Telkom University</h3>
                            <p class="project-summary">
                                Redesign antarmuka Portal Akademik iGracias Telkom University menggunakan <strong>Figma</strong> untuk menghasilkan navigasi, konsistensi visual, dan pengalaman akademik yang lebih modern.
                            </p>
                            <div class="project-stack-mini">
                                <span>Figma</span>
                                <span>UX Research</span>
                                <span>User Flow</span>
                                <span>Wireframe</span>
                                <span>Interactive Prototype</span>
                            </div>
                            <button
                                type="button"
                                class="btn-retro-blue btn-open-modal"
                                data-title="iGracias – Redesign Portal Akademik Telkom University"
                                data-role="UI/UX Designer"
                                data-img="assets/img/project-igracias.png?v=4"
                                data-stack="Figma, UI/UX Design, User Research, User Flow, Wireframing, High-Fidelity Mockup, Interactive Prototyping"
                                data-points="Melakukan redesign antarmuka Portal Akademik iGracias untuk meningkatkan kemudahan penggunaan, navigasi, dan konsistensi visual.|Menganalisis permasalahan pada antarmuka yang ada dan menyusun solusi desain berdasarkan kebutuhan pengguna.|Membuat user flow, wireframe, mockup, dan prototipe interaktif menggunakan Figma.|Menerapkan prinsip UI/UX Design untuk menciptakan pengalaman pengguna yang lebih intuitif dan efisien.|Menghasilkan rancangan antarmuka yang lebih modern, mudah dipahami, dan mendukung aktivitas akademik mahasiswa."
                            >
                                🔍 Lihat Detail Lengkap
                            </button>
                        </div>
                    </article>

                    <!-- Project 4: Graphic Design & Visual Branding (From Canva Slide 4 & 5) -->
                    <article class="project-card" data-category="graphic">
                        <div class="project-img-wrap">
                            <img src="assets/img/graphic-design-banner.png" alt="Karya Graphic Design dan Visual Branding Nejaa" loading="lazy">
                            <span class="project-cat-badge badge-yellow">Graphic Designer</span>
                        </div>
                        <div class="project-card-body">
                            <h3 class="project-title">Visual Branding &amp; Digital Content Creation</h3>
                            <p class="project-summary">
                                Perancangan identitas visual, poster kreatif, dan konten produk digital untuk kegiatan kampus (<strong>Hello World 2025</strong>, <strong>Prada 1447H</strong>) serta kanal YouTube, Instagram, dan Pinterest.
                            </p>
                            <div class="project-stack-mini">
                                <span>Canva</span>
                                <span>ibisPaint X</span>
                                <span>CapCut</span>
                                <span>Visual Branding</span>
                                <span>Social Media Kit</span>
                            </div>
                            <button
                                type="button"
                                class="btn-retro-blue btn-open-modal"
                                data-title="Visual Branding &amp; Digital Content Creation"
                                data-role="Graphic Designer &amp; Content Creator"
                                data-img="assets/img/social-showcase.png"
                                data-stack="Canva, ibisPaint X, CapCut, Figma, Social Media Branding, Poster &amp; Digital Product Design"
                                data-points="Merancang dan menghasilkan berbagai materi visual untuk mendukung kebutuhan acara Hello World 2025 dan Prada 1447H.|Membuat konten kreatif dan media publikasi guna meningkatkan keterlibatan peserta serta memperkuat branding acara.|Membahas dan membagikan karya seputar desain grafis serta produk digital di 3 platform utama: YouTube (Meyneza Ari), Instagram (@meynezaaaari), dan Pinterest.|Menggabungkan estetika Y2K, Scrapbook, dan tipografi berani untuk identitas visual yang berkarakter."
                            >
                                🔍 Lihat Detail Lengkap
                            </button>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- =================================================================
             6. MY PERSONAL ACCOUNT SHOWCASE — PERSIS SLIDE 4 CANVA
             ================================================================= -->
        <section id="social" class="social-showcase-section container section-pad">
            <div class="personal-account-board reveal-on-scroll">
                <div class="pa-header">
                    <h2 class="pa-title">MY PERSONAL ACCOUNT</h2>
                    <span class="pa-Sub">YOUTUBE • INSTAGRAM • PINTEREST</span>
                </div>

                <div class="pa-grid">
                    <div class="pa-image-frame">
                        <img src="assets/img/social-showcase.png" alt="Showcase akun YouTube Meyneza Ari, Instagram @meynezaaaari, dan Pinterest" loading="lazy">
                    </div>

                    <div class="pa-text-box">
                        <div class="pa-quote-card">
                            <p class="pa-quote-text">
                                “The content that I bring on 3 social media platforms such as <strong>YouTube</strong>, <strong>Pinterest</strong>, and <strong>Instagram</strong>, I like to discuss <strong>design and digital product</strong>.”
                            </p>
                        </div>

                        <div class="pa-links-list">
                            <a href="https://www.youtube.com/@meynezaari8718" target="_blank" rel="noopener noreferrer" class="pa-platform-btn pa-yt">
                                ▶️ YouTube: <strong>Meyneza Ari</strong>
                            </a>
                            <a href="https://instagram.com/meynezaaaari" target="_blank" rel="noopener noreferrer" class="pa-platform-btn pa-ig">
                                📸 Instagram: <strong>@meynezaaaari</strong>
                            </a>
                            <a href="https://www.tiktok.com/@nezcoffiee" target="_blank" rel="noopener noreferrer" class="pa-platform-btn pa-tt">
                                🎵 TikTok: <strong>@nezcoffiee</strong>
                            </a>
                            <a href="https://www.linkedin.com/in/meyneza-ari" target="_blank" rel="noopener noreferrer" class="pa-platform-btn pa-li">
                                💼 LinkedIn: <strong>meyneza-ari</strong>
                            </a>
                            <a href="mailto:meinesaari@gmail.com" class="pa-platform-btn pa-em">
                                ✉️ Email: <strong>meinesaari@gmail.com</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =================================================================
             7. MENU & TEMPAT INTEGRASI APLIKASI BERSAMA (app/)
             ================================================================= -->
        <section id="shared-app" class="guestbook-embed-section container section-pad">
            <div class="retro-window reveal-on-scroll">
                <div class="window-titlebar">
                    <div class="window-title-left">
                        <span class="window-icon">🚀</span>
                        <span class="window-title-text">SHARED_APP_SLOT // ROUTE: <?= htmlspecialchars(strtoupper($currentRoute), ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="window-controls" aria-hidden="true">
                        <span class="win-btn win-min">_</span>
                        <span class="win-btn win-max">□</span>
                        <span class="win-btn win-close">×</span>
                    </div>
                </div>

                <div class="window-body grid-paper-bg">
                    <div class="section-header-row">
                        <div>
                            <span class="sticker-pill-yellow">APLIKASI BERSAMA KELOMPOK</span>
                            <h2 class="section-heading">Guestbook Kelompok Terdistribusi (<code>app/</code>)</h2>
                            <p class="section-subtitle">
                                Aplikasi bersama tersemat langsung dari <code>app/index.php?embed=1</code> dan mencatat entri pada node <code><?= htmlspecialchars($currentRoute, ENT_QUOTES, 'UTF-8') ?></code>.
                            </p>
                        </div>
                        <a href="app/index.php" class="btn-retro-orange">Buka Halaman Penuh (app/index.php) →</a>
                    </div>

                    <iframe
                        src="app/index.php?embed=1"
                        class="guestbook-iframe"
                        title="Aplikasi Bersama Guestbook Kelompok"
                        loading="lazy"
                    ></iframe>
                </div>
            </div>
        </section>
    </main>

    <!-- =================================================================
         MODAL DETAIL PROYEK (INTERAKSI JAVASCRIPT)
         ================================================================= -->
    <div class="project-modal-backdrop" id="projectModal" role="dialog" aria-modal="true" aria-labelledby="modalProjectTitle" hidden>
        <div class="project-modal-window">
            <div class="window-titlebar">
                <div class="window-title-left">
                    <span class="window-icon">✨</span>
                    <span class="window-title-text" id="modalWindowHeader">PROJECT_DETAILS.EXE</span>
                </div>
                <button type="button" class="modal-close-btn" id="closeModalBtn" aria-label="Tutup detail proyek">×</button>
            </div>
            <div class="project-modal-body">
                <div class="modal-img-container">
                    <img src="" alt="" id="modalProjectImg">
                </div>
                <div class="modal-info-container">
                    <span class="sticker-pill-yellow" id="modalProjectRole">Role</span>
                    <h3 id="modalProjectTitle" class="modal-title">Judul Proyek</h3>
                    <div class="modal-stack-wrap" id="modalProjectStack"></div>
                    <h4 class="modal-sub">Rincian Pengerjaan &amp; Kontribusi:</h4>
                    <ul class="modal-points-list" id="modalProjectPoints"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Scalloped Stamp Border Bawah -->
    <div class="scallop-border scallop-bottom" aria-hidden="true"></div>

    <!-- Footer Semantik -->
    <footer class="site-footer">
        <div class="container footer-inner">
            <div>
                <p class="footer-brand">
                    <strong><?= htmlspecialchars($currentNama, ENT_QUOTES, 'UTF-8') ?></strong> • NIM <strong><?= htmlspecialchars($currentNim, ENT_QUOTES, 'UTF-8') ?></strong> • Server Route <code><?= htmlspecialchars($currentRoute, ENT_QUOTES, 'UTF-8') ?></code>
                </p>
                <p class="footer-copy">
                    Personal Page Individu — S1 Informatika Telkom University.
                </p>
            </div>
            <div class="footer-links">
                <a href="#hero">↑ Kembali ke Atas</a>
                <a href="app/index.php">🚀 Aplikasi Bersama</a>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js?v=5"></script>
</body>
</html>

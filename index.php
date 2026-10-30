<?php
declare(strict_types=1);

require_once __DIR__ . '/identity.php';

$nama  = defined('MEMBER_NAMA')  ? MEMBER_NAMA  : 'Student Name';
$nim   = defined('MEMBER_NIM')   ? MEMBER_NIM   : '-';
$route = defined('MEMBER_ROUTE') ? MEMBER_ROUTE : '-';

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$servedByFile = __DIR__ . '/app/partials/served_by.php';
$appReady     = is_file(__DIR__ . '/app/index.php');

/* ------------------------------------------------------------------
 * DATA PROFIL — ubah isi di bawah ini bila perlu.
 * Baris bertanda "GANTI" masih berisi contoh.
 * ------------------------------------------------------------------ */
$profil = [
    'depan'      => 'Ravananda',
    'belakang'   => 'Atthalah',
    'kampus'     => 'Telkom University Bandung',
    'prodi'      => 'Bachelor of Informatics',
    'kata_besar' => 'INFORMATICS',
    'hero_kiri'  => 'Taking systems apart to understand them, then making them safer and smarter.',
    'hero_kanan' => 'Informatics student interested in cybersecurity, AI, and data analysis.',
    'tentang'    => [
        "I'm an undergraduate Informatics student at **Telkom University Bandung** with a growing interest in "
        . '**cybersecurity**, **artificial intelligence**, and **data analysis**. I like understanding a system '
        . 'down to its details before looking for ways to make it safer and smarter.',
        "So far I've designed the interface for **Kostopia** and built **Poultry Derby** and a "
        . '**fuzzy logic recommender** with my teammates.',
    ],
    'foto'       => 'assets/img/foto-potret.jpg',
    'email'      => 'ravananda91@gmail.com',
];

$sosial = [                                         // GANTI tautannya dengan akunmu
    ['label' => 'GitHub',    'url' => 'https://github.com/',
     'ikon'  => '<path d="M12 2.5a9.5 9.5 0 0 0-3 18.5c.5.1.7-.2.7-.5v-1.7c-2.7.6-3.3-1.2-3.3-1.2-.4-1.1-1.1-1.4-1.1-1.4-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.5 2.3 1.1 2.9.8.1-.6.3-1.1.6-1.3-2.1-.2-4.4-1.1-4.4-4.8 0-1 .4-1.9 1-2.6-.1-.3-.4-1.2.1-2.6 0 0 .8-.3 2.6 1a9 9 0 0 1 4.8 0c1.8-1.3 2.6-1 2.6-1 .5 1.4.2 2.3.1 2.6.6.7 1 1.6 1 2.6 0 3.7-2.3 4.6-4.4 4.8.3.3.6.9.6 1.8v2.6c0 .3.2.6.7.5A9.5 9.5 0 0 0 12 2.5Z"/>'],
    ['label' => 'LinkedIn',  'url' => 'https://www.linkedin.com/',
     'ikon'  => '<path d="M6.5 9.5v8M6.5 6.5v.01M10.5 17.5v-5a2.5 2.5 0 0 1 5 0v5M10.5 9.5v8"/><rect x="2.5" y="2.5" width="19" height="19" rx="4"/>'],
    ['label' => 'Instagram', 'url' => 'https://www.instagram.com/',
     'ikon'  => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.3 6.7v.01"/>'],
];

$keahlian = [
    'Languages'   => ['Indonesian (Native)', 'English (Proficient)'],
    'Hard skills' => ['Python', 'Go', 'C++', 'Java', 'HTML/CSS', 'MySQL', 'Ms. Office'],
    'Soft skills' => ['Project Management', 'Problem Solving', 'Teamwork', 'Adaptability'],
];

$proyek = [
    [
        'judul' => 'Poultry Derby', 'kategori' => 'Browser game',
        'desk'  => 'A browser-based web game set in the world of competitive poultry farming. Players take the role '
                 . 'of a poultry trainer who builds a team, trains the birds they choose, and leads them to glory in '
                 . 'the competition arena. Built with a teammate using OOP and an MVC architecture.',
        'tag'   => ['Java', 'Servlets', 'JSP', 'MVC', 'MySQL'],
    ],
    [
        'judul' => 'Fuzzy logic K-drama recommender', 'kategori' => 'Artificial intelligence',
        'desk'  => 'A fuzzy logic system that scores 5,000 dramas from a MyDramaList dataset using episodes, viewers, '
                 . 'reviews, sentiment, and popularity across 46 rules. We compared Mamdani and Sugeno inference: '
                 . 'Mamdani had the lower error, and the two methods agreed with a 0.9975 correlation.',
        'tag'   => ['Fuzzy logic', 'Mamdani', 'Sugeno', 'Data analysis'],
    ],
    [
        'judul' => 'Kostopia', 'kategori' => 'UI design',
        'desk'  => 'A boarding-house management app for owners and tenants that keeps payments, tenant records, '
                 . 'and room status in one place. I designed its logo and web interface.',
        'tag'   => ['Figma', 'UI/UX', 'Logo'],
    ],
];

/* ubah **teks** menjadi <strong>teks</strong> setelah di-escape */
function tebal(string $s): string
{
    return preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', e($s));
}

/* barcode dekoratif dari digit NIM */
function barcode(string $kode): string
{
    $x = 0;
    $rects = '';
    foreach (str_split(preg_replace('/\D/', '', $kode) . '7301') as $i => $d) {
        $d = (int) $d;
        foreach ([1 + $d % 3, 1 + ($d + $i) % 2] as $j => $w) {
            $rects .= '<rect x="' . $x . '" y="0" width="' . $w . '" height="40"/>';
            $x += $w + 1 + ($j + $d) % 2;
        }
    }
    return '<svg class="barcode" viewBox="0 0 ' . $x . ' 40" preserveAspectRatio="none" aria-hidden="true">' . $rects . '</svg>';
}

function badge(array $profil, string $nim, string $extra = ''): string
{
    return '<div class="badge ' . $extra . '">'
         . '<span class="badge-hole" aria-hidden="true"></span>'
         . '<p class="badge-name"><span>' . e(strtoupper($profil['depan'])) . '</span>'
         . '<span class="ghost">' . e(strtoupper($profil['belakang'])) . '</span></p>'
         . '<img class="badge-photo" src="' . e($profil['foto']) . '" alt="" draggable="false">'
         . '<div class="badge-foot"><div><span class="badge-id">ID: ' . e($nim) . '</span>' . barcode($nim) . '</div>'
         . '<span class="badge-dept">INFORMATICS<br>DEPT.</span></div>'
         . '</div>';
}

$clip = '<svg class="clip" viewBox="0 0 40 70" aria-hidden="true">'
      . '<rect x="6" y="2" width="28" height="14" rx="7" fill="none" stroke="currentColor" stroke-width="4"/>'
      . '<rect x="16" y="14" width="8" height="10" rx="2" fill="currentColor"/>'
      . '<path d="M20 24v26c0 8 9 10 12 3" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>'
      . '<path d="M14 26v20" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>';

$strapText = str_repeat(e(strtoupper($profil['depan'] . ' ' . $profil['belakang'])) . ' &nbsp; ', 4);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($nama) ?> — Personal Page</title>
    <meta name="description" content="<?= e($profil['hero_kanan']) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@500;600;700;800;900&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<a class="skip" href="#main">Skip to content</a>

<!-- banner wajib dari tugas: tetap berbahasa Indonesia sesuai ketentuan -->
<div class="served-by-slot">
<?php if (is_file($servedByFile)): ?>
    <?php include $servedByFile; ?>
<?php else: ?>
    <p class="served-by">Anda dilayani oleh laman <strong><?= e($nama) ?></strong> (<?= e($nim) ?>)</p>
<?php endif; ?>
</div>

<header class="site-header">
    <a class="brand" href="#top"><?= e($profil['depan']) ?>.</a>
    <button class="menu-btn" type="button" id="menu-btn" aria-expanded="false" aria-controls="menu">
        <span></span><span></span>
        <span class="sr-only">Open menu</span>
    </button>
</header>

<!-- FULL-SCREEN MENU ------------------------------------------------ -->
<nav class="menu" id="menu" aria-label="Main menu" hidden>
    <div class="menu-inner">
        <div>
            <p class="label">Menu</p>
            <ul class="menu-links">
                <li><a href="#about">About</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#group-app">Group app</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
        <div class="menu-side">
            <ul class="socials">
                <?php foreach ($sosial as $s): ?>
                <li><a href="<?= e($s['url']) ?>" target="_blank" rel="noopener" aria-label="<?= e($s['label']) ?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><?= $s['ikon'] ?></svg></a></li>
                <?php endforeach; ?>
            </ul>
            <p class="label">Get in touch</p>
            <a class="menu-mail" href="mailto:<?= e($profil['email']) ?>"><?= e($profil['email']) ?></a>
        </div>
    </div>
</nav>

<main id="main">

    <!-- HERO: ID card on a lanyard --------------------------------- -->
    <section class="hero" id="top">
        <h1 class="sr-only"><?= e($nama) ?>, Informatics student at <?= e($profil['kampus']) ?></h1>

        <div class="stage" id="stage">
            <div class="strap" id="strap" aria-hidden="true"><span><?= $strapText ?></span></div>
            <div class="hanger" id="hanger" role="img" aria-label="ID card of <?= e($nama) ?>, draggable">
                <?= $clip ?>
                <?= badge($profil, $nim) ?>
            </div>
        </div>

        <p class="big-word" aria-hidden="true"><?= e($profil['kata_besar']) ?></p>

        <div class="hero-lines">
            <p><?= e($profil['hero_kiri']) ?></p>
            <p><?= e($profil['hero_kanan']) ?></p>
        </div>
        <p class="drag-hint" aria-hidden="true">Drag the card</p>
    </section>

    <!-- ABOUT + SKILLS ---------------------------------------------- -->
    <section class="section" id="about" aria-labelledby="h-about">
        <div class="wrap about">
            <div class="about-main">
                <h2 class="title title-line" id="h-about">About me</h2>
                <?php foreach ($profil['tentang'] as $par): ?>
                <p class="about-text"><?= tebal($par) ?></p>
                <?php endforeach; ?>
            </div>
            <div class="about-skills" id="skills">
                <h3 class="sr-only">Skills</h3>
                <?php foreach ($keahlian as $grup => $daftar): ?>
                <div class="skill-group">
                    <h4 class="skill-label"><?= e($grup) ?></h4>
                    <ul class="skill-list">
                        <?php foreach ($daftar as $k): ?><li><?= e($k) ?></li><?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- FEATURED PROJECTS ------------------------------------------- -->
    <section class="section" id="projects" aria-labelledby="h-projects">
        <div class="wrap">
            <h2 class="title" id="h-projects">Featured projects</h2>
            <ul class="rows projects">
                <?php foreach ($proyek as $p): ?>
                <li class="row">
                    <div class="row-meta">
                        <span class="row-title"><?= e($p['judul']) ?></span>
                        <span class="row-sub"><?= e($p['kategori']) ?></span>
                    </div>
                    <div class="row-body">
                        <p class="row-big"><?= e($p['desk']) ?></p>
                        <ul class="tags tags-sm">
                            <?php foreach ($p['tag'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- GROUP APP --------------------------------------------------- -->
    <section class="section" id="group-app" aria-labelledby="h-group-app">
        <div class="wrap app">
            <div>
                <h2 class="title" id="h-group-app">Group app</h2>
                <p class="lead">The shared app that also runs on the other four members' pages. Anything submitted here is tagged with route <strong><?= e($route) ?></strong>.</p>
                <a class="btn" href="app/index.php"><span>Open full page</span><span class="btn-icon" aria-hidden="true"><svg viewBox="0 0 20 20"><path d="M6 14 14 6M7 6h7v7"/></svg></span></a>
            </div>
            <div class="browser">
                <div class="browser-bar" aria-hidden="true"><span></span><span></span><span></span><span class="browser-url">localhost/personal/app/</span></div>
                <?php if ($appReady): ?>
                    <iframe src="app/index.php" title="Shared group app" loading="lazy"></iframe>
                <?php else: ?>
                    <div class="browser-empty">
                        <p><strong>The group app isn't installed yet.</strong></p>
                        <p>Clone the group repository into the <code>app/</code> folder, then reload this page.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CONTACT ----------------------------------------------------- -->
    <section class="contact-wrap" id="contact" aria-labelledby="h-contact">
        <div class="contact-card">
            <div class="contact-text">
                <p class="label">Contact</p>
                <h2 class="contact-title" id="h-contact">Let's work together.</h2>
                <p class="lead">Have a project, a collaboration, or just a question? Send me a message and I'll reply by email.</p>
                <div class="mail-line">
                    <p class="label">Or email me directly</p>
                    <div class="mail-row">
                        <a class="mail" href="mailto:<?= e($profil['email']) ?>"><?= e($profil['email']) ?></a>
                        <button type="button" class="copy" id="copy-mail" data-copy="<?= e($profil['email']) ?>">Copy</button>
                    </div>
                </div>
            </div>

            <form class="form" id="contact-form" novalidate data-email="<?= e($profil['email']) ?>">
                <div class="field">
                    <label for="f-nama">Name</label>
                    <input id="f-nama" name="nama" type="text" maxlength="100" autocomplete="name" required>
                    <p class="error" id="e-nama" aria-live="polite"></p>
                </div>
                <div class="field">
                    <label for="f-email">Email</label>
                    <input id="f-email" name="email" type="email" maxlength="120" autocomplete="email" required>
                    <p class="error" id="e-email" aria-live="polite"></p>
                </div>
                <div class="field field-full">
                    <label for="f-pesan">Message</label>
                    <textarea id="f-pesan" name="pesan" rows="6" maxlength="1000" required></textarea>
                    <p class="hint"><span id="count">0</span>/1000</p>
                    <p class="error" id="e-pesan" aria-live="polite"></p>
                </div>
                <button class="btn" type="submit"><span>Send message</span><span class="btn-icon" aria-hidden="true"><svg viewBox="0 0 20 20"><path d="M6 14 14 6M7 6h7v7"/></svg></span></button>
                <p class="form-status" id="form-status" role="status"></p>
            </form>
        </div>
    </section>
</main>

<!-- FOOTER: "Let's talk." with the card between the words ----------- -->
<footer class="site-footer">
    <div class="footer-talk">
        <span>Let's</span>
        <div class="mini-hang" aria-hidden="true">
            <div class="mini-strap"></div>
            <?= $clip ?>
            <?= badge($profil, $nim, 'badge-mini') ?>
        </div>
        <span>talk.</span>
    </div>
    <div class="footer-grid">
        <div>
            <p class="label">Get in touch</p>
            <a class="footer-mail" href="mailto:<?= e($profil['email']) ?>"><?= e($profil['email']) ?></a>
        </div>
        <ul class="socials">
            <?php foreach ($sosial as $s): ?>
            <li><a href="<?= e($s['url']) ?>" target="_blank" rel="noopener" aria-label="<?= e($s['label']) ?>">
                <svg viewBox="0 0 24 24" aria-hidden="true"><?= $s['ikon'] ?></svg></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <p class="copyright">© <?= date('Y') ?> <?= e($nama) ?> (<?= e($nim) ?>)</p>
</footer>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script src="assets/js/main.js"></script>
</body>
</html>

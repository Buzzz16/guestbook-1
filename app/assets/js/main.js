/**
 * MAIN.JS — INTERAKSI VANILLA JAVASCRIPT
 * Proyek    : Personal Page dan Aplikasi Bersama (Pra-UTS)
 * Mahasiswa : Zulfa Almajid Basyaasyah (Babas) - 103012400134
 *
 * Mencakup 5 fitur interaktif:
 * 1. Smooth Scroll & Active Section Spy pada Navigasi
 * 2. Filter Portofolio Dinamis (Semua / Spring Boot / AI Vue / Next.js)
 * 3. Dark / Harbor Light Theme Toggle dengan penyimpanan localStorage
 * 4. Validasi Sisi Klien (Client-Side) & Live Character Counter pada Form Guestbook
 * 5. Toggle Menu Navigasi Mobile Responsif
 */

document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();
    initMobileNav();
    initSmoothScrollAndSpy();
    initPortfolioFilter();
    initGuestbookValidation();
});

/**
 * 1. Theme Toggle (Stealth Dark <-> Harbor Light)
 */
function initThemeToggle() {
    const root = document.documentElement;
    const toggleBtn = document.getElementById('themeToggleBtn');
    const themeLabel = document.getElementById('themeLabel');

    const savedTheme = localStorage.getItem('babas_theme') || 'dark';
    root.setAttribute('data-theme', savedTheme);
    updateThemeLabel(savedTheme, themeLabel);

    if (!toggleBtn) return;

    toggleBtn.addEventListener('click', () => {
        const currentTheme = root.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
        const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', nextTheme);
        localStorage.setItem('babas_theme', nextTheme);
        updateThemeLabel(nextTheme, themeLabel);
    });
}

function updateThemeLabel(theme, labelEl) {
    if (!labelEl) return;
    labelEl.textContent = theme === 'light' ? 'HARBOR LIGHT' : 'STEALTH DARK';
}

/**
 * 2. Navigasi Mobile Responsif
 */
function initMobileNav() {
    const toggleBtn = document.getElementById('mobileNavToggle');
    const primaryNav = document.getElementById('primaryNav');

    if (!toggleBtn || !primaryNav) return;

    toggleBtn.addEventListener('click', () => {
        const isOpen = primaryNav.classList.toggle('is-open');
        toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
}

/**
 * 3. Smooth Scroll Antar Section & Highlight Navigasi Aktif
 */
function initSmoothScrollAndSpy() {
    const navLinks = document.querySelectorAll('.site-nav .nav-link[href^="#"]');
    const primaryNav = document.getElementById('primaryNav');

    navLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            const targetId = link.getAttribute('href');
            if (!targetId || targetId === '#') return;

            const targetEl = document.querySelector(targetId);
            if (targetEl) {
                event.preventDefault();
                const headerOffset = 78;
                const elementPosition = targetEl.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.scrollY - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth',
                });

                if (primaryNav && primaryNav.classList.contains('is-open')) {
                    primaryNav.classList.remove('is-open');
                }
            }
        });
    });

    const sections = document.querySelectorAll('main section[id]');
    if (sections.length === 0 || navLinks.length === 0) return;

    window.addEventListener('scroll', () => {
        const scrollPos = window.scrollY + 140;
        sections.forEach((sec) => {
            const top = sec.offsetTop;
            const height = sec.offsetHeight;
            const id = sec.getAttribute('id');

            if (scrollPos >= top && scrollPos < top + height) {
                navLinks.forEach((link) => {
                    link.classList.toggle('active', link.getAttribute('href') === `#${id}`);
                });
            }
        });
    });
}

/**
 * 4. Filter Portofolio Interaktif
 */
function initPortfolioFilter() {
    const filterButtons = document.querySelectorAll('.portfolio-filters .filter-btn');
    const portfolioCards = document.querySelectorAll('#portfolioGrid .portfolio-card');

    if (filterButtons.length === 0 || portfolioCards.length === 0) return;

    filterButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const selectedFilter = btn.getAttribute('data-filter') || 'all';

            filterButtons.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');

            portfolioCards.forEach((card) => {
                const category = card.getAttribute('data-category');
                const shouldShow = selectedFilter === 'all' || category === selectedFilter;
                card.classList.toggle('is-hidden', !shouldShow);
            });
        });
    });
}

/**
 * 5. Validasi Sisi Klien (Client-Side) & Penghitung Karakter pada Form Guestbook
 */
function initGuestbookValidation() {
    const form = document.getElementById('guestbookForm');
    const namaInput = document.getElementById('nama');
    const pesanInput = document.getElementById('pesan');
    const namaFeedback = document.getElementById('namaFeedback');
    const pesanFeedback = document.getElementById('pesanFeedback');
    const charCounter = document.getElementById('charCounter');

    if (!form || !namaInput || !pesanInput) return;

    const updateCounter = () => {
        if (!charCounter) return;
        const len = pesanInput.value.length;
        charCounter.textContent = `${len} / 1000`;
    };

    updateCounter();
    pesanInput.addEventListener('input', updateCounter);

    form.addEventListener('submit', (event) => {
        let isValid = true;
        const namaVal = namaInput.value.trim();
        const pesanVal = pesanInput.value.trim();

        // Reset state
        namaInput.classList.remove('is-invalid');
        pesanInput.classList.remove('is-invalid');
        if (namaFeedback) namaFeedback.textContent = '';
        if (pesanFeedback) pesanFeedback.textContent = '';

        if (namaVal.length < 2) {
            isValid = false;
            namaInput.classList.add('is-invalid');
            if (namaFeedback) {
                namaFeedback.textContent = 'Nama pengirim wajib diisi (minimal 2 karakter).';
            }
        } else if (namaVal.length > 100) {
            isValid = false;
            namaInput.classList.add('is-invalid');
            if (namaFeedback) {
                namaFeedback.textContent = 'Nama pengirim maksimal 100 karakter.';
            }
        }

        if (pesanVal.length < 5) {
            isValid = false;
            pesanInput.classList.add('is-invalid');
            if (pesanFeedback) {
                pesanFeedback.textContent = 'Pesan wajib diisi (minimal 5 karakter).';
            }
        } else if (pesanVal.length > 1000) {
            isValid = false;
            pesanInput.classList.add('is-invalid');
            if (pesanFeedback) {
                pesanFeedback.textContent = 'Pesan maksimal 1000 karakter.';
            }
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
}

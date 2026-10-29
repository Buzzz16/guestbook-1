/**
 * MAIN.JS — INTERAKSI VANILLA JAVASCRIPT
 * Proyek    : Personal Page dan Aplikasi Bersama (Pra-UTS)
 * Mahasiswa : Dini Nadia Mawaddah - 103012430028
 *
 * Fitur interaktif:
 * 1. Dark / Harbor Light Theme Toggle dengan penyimpanan localStorage
 * 2. Navigasi Mobile Responsif (Hamburger Drawer)
 * 3. Smooth Scroll & Active Section Spy pada Navigasi
 * 4. Filter Portofolio Dinamis Berdasarkan Kategori
 * 5. Modal Dialog Interaktif untuk Detail Portofolio
 * 6. Validasi Sisi Klien & Live Character Counter pada Form Guestbook
 */

document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();
    initMobileNav();
    initSmoothScrollAndSpy();
    initPortfolioFilter();
    initPortfolioModal();
    initGuestbookValidation();
});

/**
 * 1. Theme Toggle (Stealth Dark <-> Harbor Light)
 */
function initThemeToggle() {
    const root = document.documentElement;
    const toggleBtn = document.getElementById('themeToggleBtn');
    const themeLabel = document.getElementById('themeLabel');

    const savedTheme = localStorage.getItem('dini_theme') || localStorage.getItem('babas_theme') || 'dark';
    root.setAttribute('data-theme', savedTheme);
    updateThemeLabel(savedTheme, themeLabel);

    if (!toggleBtn) return;

    toggleBtn.addEventListener('click', () => {
        const currentTheme = root.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
        const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', nextTheme);
        localStorage.setItem('dini_theme', nextTheme);
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
 * 5. Modal Interaktif Detail Portofolio
 */
function initPortfolioModal() {
    const modalBackdrop = document.getElementById('projectModal');
    const modalCloseBtn = document.getElementById('modalCloseBtn');
    const modalTitle = document.getElementById('modalTitle');
    const modalSubtitle = document.getElementById('modalSubtitle');
    const modalStatus = document.getElementById('modalStatus');
    const modalSummary = document.getElementById('modalSummary');
    const modalHighlights = document.getElementById('modalHighlights');
    const modalTags = document.getElementById('modalTags');

    if (!modalBackdrop) return;

    const cards = document.querySelectorAll('#portfolioGrid .portfolio-card');
    cards.forEach((card) => {
        card.addEventListener('click', () => {
            const title = card.querySelector('.portfolio-title')?.textContent || '';
            const subtitle = card.querySelector('.portfolio-subtitle')?.textContent || '';
            const status = card.querySelector('.status-chip')?.textContent || '';
            const summary = card.querySelector('.portfolio-summary')?.textContent || '';
            const highlightsList = card.querySelectorAll('.portfolio-highlights li');
            const tags = card.querySelectorAll('.tech-tag');

            if (modalTitle) modalTitle.textContent = title;
            if (modalSubtitle) modalSubtitle.textContent = subtitle;
            if (modalStatus) modalStatus.textContent = status;
            if (modalSummary) modalSummary.textContent = summary;

            if (modalHighlights) {
                modalHighlights.innerHTML = '';
                highlightsList.forEach((li) => {
                    const newLi = document.createElement('li');
                    newLi.textContent = li.textContent;
                    modalHighlights.appendChild(newLi);
                });
            }

            if (modalTags) {
                modalTags.innerHTML = '';
                tags.forEach((tag) => {
                    const span = document.createElement('span');
                    span.className = 'tech-tag';
                    span.textContent = tag.textContent;
                    modalTags.appendChild(span);
                });
            }

            modalBackdrop.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        });
    });

    const closeModal = () => {
        modalBackdrop.classList.remove('is-active');
        document.body.style.overflow = '';
    };

    if (modalCloseBtn) {
        modalCloseBtn.addEventListener('click', closeModal);
    }

    modalBackdrop.addEventListener('click', (e) => {
        if (e.target === modalBackdrop) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modalBackdrop.classList.contains('is-active')) {
            closeModal();
        }
    });
}

/**
 * 6. Validasi Sisi Klien (Client-Side) & Penghitung Karakter pada Form Guestbook
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

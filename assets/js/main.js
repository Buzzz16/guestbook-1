/**
 * assets/js/main.js
 * Interaksi Sisi Klien (JavaScript) untuk Personal Page & Aplikasi Bersama
 * Meyneza Ari Dwi Astuti (103012400299)
 */

document.addEventListener('DOMContentLoaded', () => {
    // =========================================================================
    // 1. MODE GELAP / TERANG (NIGHT MODE TOGGLE)
    // =========================================================================
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const savedTheme = localStorage.getItem('nejaa_theme');

    const updateThemeButton = (isDark) => {
        if (!themeToggleBtn) return;
        const iconEl = themeToggleBtn.querySelector('.theme-icon');
        const labelEl = themeToggleBtn.querySelector('.theme-label');
        if (iconEl) iconEl.textContent = isDark ? '☀️' : '🌙';
        if (labelEl) labelEl.textContent = isDark ? 'Day Mode' : 'Night Mode';
    };

    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        updateThemeButton(true);
    }

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            const isDark = document.body.classList.toggle('dark-mode');
            localStorage.setItem('nejaa_theme', isDark ? 'dark' : 'light');
            updateThemeButton(isDark);
        });
    }

    // =========================================================================
    // 2. MENU NAVIGASI RESPONSIF (MOBILE)
    // =========================================================================
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mainNavLinks = document.getElementById('mainNavLinks');

    if (mobileMenuBtn && mainNavLinks) {
        mobileMenuBtn.addEventListener('click', () => {
            const isOpen = mainNavLinks.classList.toggle('nav-open');
            mobileMenuBtn.setAttribute('aria-expanded', String(isOpen));
        });

        mainNavLinks.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                mainNavLinks.classList.remove('nav-open');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
            });
        });
    }

    // =========================================================================
    // 3. INTERAKSI HERO PAINT TOOLBAR & TAMAGOTCHI KEYCHAIN
    // =========================================================================
    const toolButtons = document.querySelectorAll('.tool-btn[data-tool]');
    const toolbarStatusText = document.getElementById('toolbarStatusText');
    const tamagotchiCharm = document.getElementById('tamagotchiCharm');

    toolButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            toolButtons.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
            const msg = btn.getAttribute('data-tool');
            if (toolbarStatusText && msg) {
                toolbarStatusText.textContent = `meynezaaaari — ${msg}`;
            }
        });
    });

    if (tamagotchiCharm) {
        const greetings = [
            'Hellowwrr! Aku Nejaa (103012400299) ✨',
            'Graphic Designer + UI/UX Designer 🎨✨',
            'Jangan lupa mampir isi Guestbook di bawah yaa! 📖',
            'Server Route aktif: m2 — Telkom University 🚀'
        ];
        let greetIdx = 0;

        tamagotchiCharm.addEventListener('click', () => {
            tamagotchiCharm.classList.remove('tama-bounce');
            void tamagotchiCharm.offsetWidth; // trigger reflow
            tamagotchiCharm.classList.add('tama-bounce');

            if (toolbarStatusText) {
                toolbarStatusText.textContent = greetings[greetIdx % greetings.length];
                greetIdx++;
            }
        });
    }

    // =========================================================================
    // 4. TOGGLE BAHASA BIO (EN+ID / EN / ID)
    // =========================================================================
    const bioLangToggle = document.getElementById('bioLangToggle');
    const bioLangLabel = document.getElementById('bioLangLabel');
    const bioTextContainer = document.getElementById('bioTextContainer');

    if (bioLangToggle && bioTextContainer) {
        const modes = ['both', 'en', 'id'];
        let modeIdx = 0;

        bioLangToggle.addEventListener('click', () => {
            modeIdx = (modeIdx + 1) % modes.length;
            const currentMode = modes[modeIdx];
            const enEls = bioTextContainer.querySelectorAll('.bio-en');
            const idEl = bioTextContainer.querySelector('.bio-id');

            if (currentMode === 'both') {
                enEls.forEach((el) => (el.style.display = ''));
                if (idEl) idEl.style.display = '';
                if (bioLangLabel) bioLangLabel.textContent = 'EN + ID';
            } else if (currentMode === 'en') {
                enEls.forEach((el) => (el.style.display = ''));
                if (idEl) idEl.style.display = 'none';
                if (bioLangLabel) bioLangLabel.textContent = 'EN Only';
            } else {
                enEls.forEach((el) => (el.style.display = 'none'));
                if (idEl) idEl.style.display = '';
                if (bioLangLabel) bioLangLabel.textContent = 'ID Only';
            }
        });
    }

    // =========================================================================
    // 5. FILTER KATEGORI PORTOFOLIO
    // =========================================================================
    const filterButtons = document.querySelectorAll('.filter-btn[data-filter]');
    const projectCards = document.querySelectorAll('.project-card[data-category]');

    filterButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            filterButtons.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');

            const selectedFilter = btn.getAttribute('data-filter') || 'all';

            projectCards.forEach((card) => {
                const cats = (card.getAttribute('data-category') || '').split(/\s+/);
                if (selectedFilter === 'all' || cats.includes(selectedFilter)) {
                    card.classList.remove('is-hidden');
                } else {
                    card.classList.add('is-hidden');
                }
            });
        });
    });

    // =========================================================================
    // 6. GALERI MODAL DETAIL PROYEK
    // =========================================================================
    const projectModal = document.getElementById('projectModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modalProjectImg = document.getElementById('modalProjectImg');
    const modalProjectRole = document.getElementById('modalProjectRole');
    const modalProjectTitle = document.getElementById('modalProjectTitle');
    const modalProjectStack = document.getElementById('modalProjectStack');
    const modalProjectPoints = document.getElementById('modalProjectPoints');

    const closeModal = () => {
        if (!projectModal) return;
        projectModal.hidden = true;
        document.body.style.overflow = '';
    };

    document.querySelectorAll('.btn-open-modal').forEach((btn) => {
        btn.addEventListener('click', () => {
            if (!projectModal) return;
            const title = btn.getAttribute('data-title') || '';
            const role = btn.getAttribute('data-role') || '';
            const img = btn.getAttribute('data-img') || '';
            const stack = (btn.getAttribute('data-stack') || '').split(',').map((s) => s.trim()).filter(Boolean);
            const points = (btn.getAttribute('data-points') || '').split('|').map((p) => p.trim()).filter(Boolean);

            if (modalProjectTitle) modalProjectTitle.textContent = title;
            if (modalProjectRole) modalProjectRole.textContent = role;
            if (modalProjectImg) {
                modalProjectImg.src = img;
                modalProjectImg.alt = `Preview ${title}`;
            }

            if (modalProjectStack) {
                modalProjectStack.innerHTML = '';
                stack.forEach((tech) => {
                    const pill = document.createElement('span');
                    pill.className = 'tech-pill';
                    pill.textContent = tech;
                    modalProjectStack.appendChild(pill);
                });
            }

            if (modalProjectPoints) {
                modalProjectPoints.innerHTML = '';
                points.forEach((pt) => {
                    const li = document.createElement('li');
                    li.textContent = pt;
                    modalProjectPoints.appendChild(li);
                });
            }

            projectModal.hidden = false;
            document.body.style.overflow = 'hidden';
        });
    });

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    if (projectModal) {
        projectModal.addEventListener('click', (e) => {
            if (e.target === projectModal) closeModal();
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && projectModal && !projectModal.hidden) {
            closeModal();
        }
    });

    // =========================================================================
    // 7. ANIMASI SAAT SCROLL (INTERSECTION OBSERVER)
    // =========================================================================
    const revealEls = document.querySelectorAll('.reveal-on-scroll');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        obs.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.08 }
        );
        revealEls.forEach((el) => observer.observe(el));
    } else {
        revealEls.forEach((el) => el.classList.add('is-visible'));
    }

    // =========================================================================
    // 8. VALIDASI FORM SISI KLIEN (GUESTBOOK DI APP/INDEX.PHP & INDEX.PHP)
    // =========================================================================
    const attachGuestbookValidation = (formId, namaId, pesanId, errNamaId, errPesanId, counterId = null) => {
        const form = document.getElementById(formId);
        const namaInput = document.getElementById(namaId);
        const pesanInput = document.getElementById(pesanId);
        const errNama = document.getElementById(errNamaId);
        const errPesan = document.getElementById(errPesanId);
        const charCounter = counterId ? document.getElementById(counterId) : null;

        if (!form || !namaInput || !pesanInput) return;

        if (charCounter) {
            const updateCount = () => {
                charCounter.textContent = `${pesanInput.value.length} / 1000`;
            };
            pesanInput.addEventListener('input', updateCount);
            updateCount();
        }

        form.addEventListener('submit', (e) => {
            let valid = true;
            const namaVal = namaInput.value.trim();
            const pesanVal = pesanInput.value.trim();

            if (errNama) errNama.textContent = '';
            if (errPesan) errPesan.textContent = '';

            if (namaVal.length < 2) {
                if (errNama) errNama.textContent = 'Nama minimal 2 karakter.';
                valid = false;
            } else if (namaVal.length > 100) {
                if (errNama) errNama.textContent = 'Nama maksimal 100 karakter.';
                valid = false;
            }

            if (pesanVal.length < 3) {
                if (errPesan) errPesan.textContent = 'Pesan minimal 3 karakter.';
                valid = false;
            } else if (pesanVal.length > 1000) {
                if (errPesan) errPesan.textContent = 'Pesan maksimal 1000 karakter.';
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    };

    attachGuestbookValidation('guestbookForm', 'gbNama', 'gbPesan', 'errNama', 'errPesan', 'charCount');
    attachGuestbookValidation('homeGuestbookForm', 'homeGbNama', 'homeGbPesan', 'homeErrNama', 'homeErrPesan');

    // Kompatibilitas dengan form Guestbook bersama di repo kelompok (app/index.php)
    const sharedForm = document.getElementById('guestbookForm');
    const sharedNama = document.getElementById('nama');
    const sharedPesan = document.getElementById('pesan');
    const namaFeedback = document.getElementById('namaFeedback');
    const pesanFeedback = document.getElementById('pesanFeedback');
    const charCounter = document.getElementById('charCounter');

    if (sharedForm && sharedNama && sharedPesan) {
        if (charCounter) {
            const syncCounter = () => {
                charCounter.textContent = `${sharedPesan.value.length} / 1000`;
            };
            sharedPesan.addEventListener('input', syncCounter);
            syncCounter();
        }

        sharedForm.addEventListener('submit', (e) => {
            let ok = true;
            const nVal = sharedNama.value.trim();
            const pVal = sharedPesan.value.trim();

            if (namaFeedback) namaFeedback.textContent = '';
            if (pesanFeedback) pesanFeedback.textContent = '';
            sharedNama.classList.remove('is-invalid');
            sharedPesan.classList.remove('is-invalid');

            if (nVal.length < 2) {
                if (namaFeedback) namaFeedback.textContent = 'Nama pengirim minimal terdiri dari 2 karakter.';
                sharedNama.classList.add('is-invalid');
                ok = false;
            } else if (nVal.length > 100) {
                if (namaFeedback) namaFeedback.textContent = 'Nama pengirim maksimal 100 karakter.';
                sharedNama.classList.add('is-invalid');
                ok = false;
            }

            if (pVal.length < 5) {
                if (pesanFeedback) pesanFeedback.textContent = 'Isi pesan minimal terdiri dari 5 karakter.';
                sharedPesan.classList.add('is-invalid');
                ok = false;
            } else if (pVal.length > 1000) {
                if (pesanFeedback) pesanFeedback.textContent = 'Isi pesan maksimal 1000 karakter.';
                sharedPesan.classList.add('is-invalid');
                ok = false;
            }

            if (!ok) {
                e.preventDefault();
            }
        });
    }
});


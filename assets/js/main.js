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
    initMarioScrollAnimations();
    initInteractiveMarioControls();
    initRelativeTimeFormatter();
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
    labelEl.textContent = theme === 'light' ? 'OVERWORLD' : 'UNDERGROUND';
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


/**
 * 7. Animasi Super Mario Bros Lengkap (Scroll Reveal, Partikel Koin/Skor, Jejak Kursor, Tilt 3D & Langit Aktif)
 */
function initMarioScrollAnimations() {
    // A. Buat Mario Scroll Progress Bar dengan ikon Bintang berjalan di bawah Header
    const header = document.querySelector('.site-header');
    let progressBar = null;
    if (header) {
        const progressTrack = document.createElement('div');
        progressTrack.className = 'mario-scroll-track';
        progressBar = document.createElement('div');
        progressBar.className = 'mario-scroll-bar';
        progressTrack.appendChild(progressBar);
        header.appendChild(progressTrack);
    }

    // B. Tambahkan lebih banyak elemen melayang di langit Mario secara dinamis
    const skyDecor = document.querySelector('.mario-sky-decor');
    if (skyDecor) {
        const extraIcons = ['🪙', '⭐', '🍄', '🪙', '⭐', '🔥', '🪙', '🍄', '⭐', '☁️'];
        extraIcons.forEach((icon, i) => {
            const span = document.createElement('span');
            span.className = 'sky-floating-item';
            span.textContent = icon;
            span.style.left = `${(i * 9.5 + 4) % 94}%`;
            span.style.top = `${(i * 13 + 8) % 88}%`;
            span.style.animationDelay = `${(i * 0.45).toFixed(2)}s`;
            span.style.animationDuration = `${3 + (i % 4) * 0.8}s`;
            skyDecor.appendChild(span);
        });
    }

    // C. Tandai elemen-elemen yang akan beranimasi setiap kali digulir
    const revealGroups = [
        { selector: '.hero-id-card', anim: 'reveal-pop', stagger: 0 },
        { selector: '.hero-content', anim: 'reveal-left', stagger: 100 },
        { selector: '.telemetry-item', anim: 'reveal-up', stagger: 90 },
        { selector: '.section-header, .section-header-flex', anim: 'reveal-up', stagger: 0 },
        { selector: '.portfolio-filters .filter-btn', anim: 'reveal-pop', stagger: 60 },
        { selector: '.portfolio-card', anim: 'reveal-pop', stagger: 110 },
        { selector: '.timeline-card', anim: 'reveal-left', stagger: 140 },
        { selector: '.skill-card', anim: 'reveal-pop', stagger: 90 },
        { selector: '.contact-card', anim: 'reveal-up', stagger: 110 },
        { selector: '.guestbook-form-card, .guestbook-feed-card', anim: 'reveal-up', stagger: 120 },
        { selector: '.mario-stage-scene .stage-floating-platform, .mario-stage-scene .stage-ground-items', anim: 'reveal-pop', stagger: 140 },
    ];

    const allRevealEls = [];
    revealGroups.forEach(({ selector, anim, stagger }) => {
        const nodes = document.querySelectorAll(selector);
        nodes.forEach((el, idx) => {
            el.classList.add('mario-reveal', anim);
            const delayMs = Math.min(idx * stagger, 450);
            el.style.transitionDelay = `${delayMs}ms`;
            allRevealEls.push(el);
        });
    });

    // D. IntersectionObserver: beranimasi setiap masuk layar
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    } else {
                        entry.target.classList.remove('is-visible');
                    }
                });
            },
            {
                threshold: 0.1,
                rootMargin: '0px 0px -30px 0px',
            }
        );

        allRevealEls.forEach((el) => observer.observe(el));
    } else {
        allRevealEls.forEach((el) => el.classList.add('is-visible'));
    }

    // E. Efek 3D Tilt halus saat kursor diarahkan ke kartu (.tech-card)
    const techCards = document.querySelectorAll('.tech-card');
    techCards.forEach((card) => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const relX = (e.clientX - rect.left) / rect.width - 0.5;
            const relY = (e.clientY - rect.top) / rect.height - 0.5;
            card.style.transform = `perspective(700px) translateY(-7px) rotateX(${(-relY * 6).toFixed(2)}deg) rotateY(${(relX * 6).toFixed(2)}deg)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });

    // F. Parallax Langit & Update Scroll Progress Bar saat halaman digulir
    const clouds = document.querySelectorAll('.sky-cloud');
    const stars = document.querySelectorAll('.sky-star');

    window.addEventListener(
        'scroll',
        () => {
            const scrollY = window.scrollY;
            const docHeight = Math.max(1, document.documentElement.scrollHeight - window.innerHeight);
            const progress = Math.min(100, Math.max(0, (scrollY / docHeight) * 100));

            if (progressBar) {
                progressBar.style.width = `${progress}%`;
            }

            clouds.forEach((cloud, i) => {
                const speed = (i + 1) * 0.14;
                cloud.style.transform = `translate3d(${scrollY * speed * 0.45}px, ${-scrollY * speed * 0.6}px, 0)`;
            });

            stars.forEach((star, i) => {
                const speed = (i + 1) * 0.2;
                const rot = scrollY * 0.35 * (i % 2 === 0 ? 1 : -1);
                star.style.transform = `translate3d(0, ${-scrollY * speed * 0.7}px, 0) rotate(${rot}deg)`;
            });
        },
        { passive: true }
    );
}


/**
 * 8. Fitur Interaktif Tambahan:
 *    - Synthesizer Efek Suara 8-Bit Mario (Koin & Lompat via Web Audio API)
 *    - Penghitung Koin Interaktif (#marioCoinHud) saat klik Question Block (?) / Ikon
 *    - Karakter Mario Lompat saat panggung bawah diklik
 *    - Reaksi Cepat & Live Preview Real-Time pada Form Guestbook
 */
function initInteractiveMarioControls() {
    // A. Web Audio API 8-Bit Sound Synthesizer (tanpa file mp3 eksternal)
    let audioCtx = null;
    const playMarioSound = (type = 'coin') => {
        try {
            const AudioContextClass = window.AudioContext || window.webkitAudioContext;
            if (!AudioContextClass) return;
            if (!audioCtx) audioCtx = new AudioContextClass();
            if (audioCtx.state === 'suspended') audioCtx.resume();

            const now = audioCtx.currentTime;
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);

            if (type === 'coin') {
                osc.type = 'square';
                osc.frequency.setValueAtTime(987.77, now); // B5
                osc.frequency.setValueAtTime(1318.51, now + 0.075); // E6
                gain.gain.setValueAtTime(0.08, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.32);
                osc.start(now);
                osc.stop(now + 0.33);
            } else if (type === 'jump') {
                osc.type = 'square';
                osc.frequency.setValueAtTime(180, now);
                osc.frequency.exponentialRampToValueAtTime(620, now + 0.18);
                gain.gain.setValueAtTime(0.08, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.2);
                osc.start(now);
                osc.stop(now + 0.21);
            } else if (type === 'powerup') {
                osc.type = 'square';
                const notes = [330, 392, 659, 523, 587, 784];
                notes.forEach((freq, idx) => {
                    osc.frequency.setValueAtTime(freq, now + idx * 0.055);
                });
                gain.gain.setValueAtTime(0.08, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.38);
                osc.start(now);
                osc.stop(now + 0.39);
            } else if (type === 'clear') {
                osc.type = 'square';
                const notes = [523.25, 659.25, 783.99, 1046.5];
                notes.forEach((freq, idx) => {
                    osc.frequency.setValueAtTime(freq, now + idx * 0.08);
                });
                gain.gain.setValueAtTime(0.09, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.45);
                osc.start(now);
                osc.stop(now + 0.46);
            }
        } catch (err) {
            // Abaikan bila browser memblokir audio otomatis
        }
    };

    // B. Penghitung Koin Interaktif di Header (#marioCoinHud)
    const coinHudBtn = document.getElementById('marioCoinHud');
    const coinCountEl = document.getElementById('coinCountVal');
    let coins = parseInt(localStorage.getItem('dini_mario_coins') || '0', 10);
    if (isNaN(coins) || coins < 0) coins = 0;

    const renderCoins = () => {
        if (coinCountEl) {
            coinCountEl.textContent = String(coins).padStart(2, '0');
        }
    };
    renderCoins();

    const addCoin = (sourceEl) => {
        coins += 1;
        localStorage.setItem('dini_mario_coins', String(coins));
        renderCoins();
        playMarioSound('coin');

        if (coinHudBtn) {
            coinHudBtn.classList.remove('coin-bump');
            void coinHudBtn.offsetWidth;
            coinHudBtn.classList.add('coin-bump');
        }

        if (sourceEl) {
            sourceEl.classList.remove('block-hit-anim');
            void sourceEl.offsetWidth;
            sourceEl.classList.add('block-hit-anim');
        }
    };

    if (coinHudBtn) {
        coinHudBtn.addEventListener('click', () => addCoin(coinHudBtn));
    }

    // Semua Question Block (?), Brick, dan Ikon Kartu bisa diklik untuk mengumpulkan Koin!
    const clickableItems = document.querySelectorAll(
        '.m-qblock, .m-brick, .m-coin-pop, .m-shroom-pop, .skill-slot-icon, .stat-pill-icon, .spotlight-avatar-frame, .stage-coins span'
    );
    clickableItems.forEach((el) => {
        el.style.cursor = 'pointer';
        el.addEventListener('click', (e) => {
            e.stopPropagation();
            addCoin(el);
        });
    });

    // C. Mini-Game Panggung Super Mario yang Bisa Dimainkan (#playableMario)
    const arena = document.getElementById('marioGameArena');
    const marioEl = document.getElementById('playableMario');
    const powerTagEl = document.getElementById('marioPowerTag');
    const statusPillEl = document.getElementById('stageGameStatus');
    const btnLeft = document.getElementById('btnMarioLeft');
    const btnRight = document.getElementById('btnMarioRight');
    const btnJump = document.getElementById('btnMarioJump');
    const btnReset = document.getElementById('btnMarioReset');

    if (arena && marioEl) {
        const state = {
            x: 40,
            y: 0, // jarak dari lantai dasar arena (bottom px)
            vx: 0,
            vy: 0,
            width: 40,
            height: 48,
            speed: 4.5,
            jumpForce: 12.6,
            gravity: 0.56,
            grounded: true,
            leftPressed: false,
            rightPressed: false,
            facingLeft: false,
            targetX: null,
            autoPatrol: true,
            patrolDir: 1,
            idleTimer: null,
        };

        const setStatusText = (msg) => {
            if (statusPillEl) statusPillEl.textContent = msg;
        };

        const markManualControl = () => {
            state.autoPatrol = false;
            state.targetX = null;
            if (state.idleTimer) clearTimeout(state.idleTimer);
            state.idleTimer = setTimeout(() => {
                if (!state.leftPressed && !state.rightPressed) {
                    state.autoPatrol = true;
                }
            }, 6000);
        };

        const triggerJump = (playSound = true) => {
            if (state.grounded) {
                state.vy = state.jumpForce;
                state.grounded = false;
                if (playSound) playMarioSound('jump');
                setStatusText('JUMP! ⏫');
            }
        };

        const resetMarioGame = () => {
            state.x = 40;
            state.y = 0;
            state.vx = 0;
            state.vy = 0;
            state.grounded = true;
            state.facingLeft = false;
            state.targetX = null;
            state.autoPatrol = true;
            state.patrolDir = 1;
            marioEl.classList.remove('is-super', 'is-star', 'face-left', 'is-running', 'is-jumping');
            if (powerTagEl) powerTagEl.textContent = 'M3';
            setStatusText('READY!');

            // Munculkan kembali semua item yang sudah diambil
            arena.querySelectorAll('.item-collected').forEach((item) => {
                item.classList.remove('item-collected');
                item.removeAttribute('data-taken');
            });
        };

        // Klik di mana saja pada arena panggung: Mario berlari ke titik klik & melompat!
        arena.addEventListener('click', (e) => {
            if (e.target.closest('.stage-ctrl-btn')) return;
            const rect = arena.getBoundingClientRect();
            const clickX = e.clientX - rect.left - state.width / 2;
            state.autoPatrol = false;
            state.targetX = Math.max(8, Math.min((arena.clientWidth || 800) - state.width - 12, clickX));
            triggerJump(true);
            if (state.idleTimer) clearTimeout(state.idleTimer);
            state.idleTimer = setTimeout(() => {
                state.autoPatrol = true;
            }, 6000);
        });

        // Klik langsung karakter Mario untuk lompat
        marioEl.addEventListener('click', (e) => {
            e.stopPropagation();
            markManualControl();
            triggerJump(true);
        });

        // Kontrol Tombol Layar (Mouse, Click & Touch)
        const bindHoldBtn = (btn, dir) => {
            if (!btn) return;
            const startHold = (e) => {
                e.preventDefault();
                e.stopPropagation();
                markManualControl();
                if (dir === 'left') state.leftPressed = true;
                if (dir === 'right') state.rightPressed = true;
                btn.classList.add('is-pressed');
            };
            const endHold = () => {
                if (dir === 'left') state.leftPressed = false;
                if (dir === 'right') state.rightPressed = false;
                btn.classList.remove('is-pressed');
            };
            btn.addEventListener('pointerdown', startHold);
            btn.addEventListener('pointerup', endHold);
            btn.addEventListener('pointerleave', endHold);
            btn.addEventListener('pointercancel', endHold);
        };

        bindHoldBtn(btnLeft, 'left');
        bindHoldBtn(btnRight, 'right');

        if (btnJump) {
            btnJump.addEventListener('pointerdown', (e) => {
                e.preventDefault();
                e.stopPropagation();
                markManualControl();
                triggerJump(true);
            });
        }

        if (btnReset) {
            btnReset.addEventListener('click', (e) => {
                e.stopPropagation();
                playMarioSound('coin');
                resetMarioGame();
            });
        }

        // Kontrol Keyboard (Panah Kiri/Kanan atau A/D, Spasi/W/Panah Atas untuk lompat)
        window.addEventListener('keydown', (e) => {
            const activeTag = document.activeElement ? document.activeElement.tagName : '';
            if (activeTag === 'INPUT' || activeTag === 'TEXTAREA' || activeTag === 'SELECT') return;

            if (e.code === 'ArrowLeft' || e.code === 'KeyA') {
                markManualControl();
                state.leftPressed = true;
                if (btnLeft) btnLeft.classList.add('is-pressed');
            } else if (e.code === 'ArrowRight' || e.code === 'KeyD') {
                markManualControl();
                state.rightPressed = true;
                if (btnRight) btnRight.classList.add('is-pressed');
            } else if (e.code === 'ArrowUp' || e.code === 'KeyW' || e.code === 'Space') {
                const rect = arena.getBoundingClientRect();
                const inViewport = rect.top < window.innerHeight && rect.bottom > 0;
                if (inViewport) {
                    e.preventDefault();
                    markManualControl();
                    triggerJump(true);
                }
            }
        });

        window.addEventListener('keyup', (e) => {
            if (e.code === 'ArrowLeft' || e.code === 'KeyA') {
                state.leftPressed = false;
                if (btnLeft) btnLeft.classList.remove('is-pressed');
            } else if (e.code === 'ArrowRight' || e.code === 'KeyD') {
                state.rightPressed = false;
                if (btnRight) btnRight.classList.remove('is-pressed');
            }
        });

        // Helper konversi posisi elemen di dalam arena ke koordinat (x, bottomY, width, height)
        const getArenaBox = (el) => {
            const arenaRect = arena.getBoundingClientRect();
            const r = el.getBoundingClientRect();
            return {
                x: r.left - arenaRect.left,
                y: Math.max(0, arenaRect.bottom - r.bottom),
                w: r.width,
                h: r.height,
            };
        };

        // Loop Fisika & Deteksi Tabrakan (60 FPS)
        const updateGameLoop = () => {
            const arenaWidth = arena.clientWidth || 800;
            const maxX = Math.max(40, arenaWidth - state.width - 12);

            // 1. Kecepatan Horizontal (Manual / Klik Target / Auto-Patrol)
            if (state.leftPressed && !state.rightPressed) {
                state.vx = -state.speed;
                state.facingLeft = true;
            } else if (state.rightPressed && !state.leftPressed) {
                state.vx = state.speed;
                state.facingLeft = false;
            } else if (state.targetX !== null) {
                const diff = state.targetX - state.x;
                if (Math.abs(diff) > 6) {
                    state.vx = Math.sign(diff) * state.speed;
                    state.facingLeft = diff < 0;
                } else {
                    state.targetX = null;
                    state.vx = 0;
                }
            } else if (state.autoPatrol) {
                state.vx = state.patrolDir * 2.4;
                state.facingLeft = state.patrolDir < 0;
                if (state.x >= maxX - 4) state.patrolDir = -1;
                if (state.x <= 12) state.patrolDir = 1;
            } else {
                state.vx *= 0.72;
                if (Math.abs(state.vx) < 0.15) state.vx = 0;
            }

            const prevX = state.x;
            const prevY = state.y;

            state.x += state.vx;

            // Batas kiri & kanan arena
            if (state.x < 8) state.x = 8;
            if (state.x > maxX) state.x = maxX;

            // 2. Fisika Gravitasi & Vertikal
            state.vy -= state.gravity;
            state.y += state.vy;

            let landedOnSurface = false;

            // Lantai dasar bata
            if (state.y <= 0) {
                state.y = 0;
                state.vy = 0;
                landedOnSurface = true;
            }

            // 3. Tabrakan dengan Pipa Hijau (Bisa dilompati & diinjak di atasnya)
            const pipes = arena.querySelectorAll('[data-obstacle="pipe"]');
            pipes.forEach((pipe) => {
                if (pipe.offsetParent === null) return;
                const box = getArenaBox(pipe);
                const pipeTop = box.y + box.h;
                const overlapX = state.x + state.width - 6 > box.x && state.x + 6 < box.x + box.w;

                // Bila mode auto-patrol / klik target mendekati pipa, otomatis lompat!
                if ((state.autoPatrol || state.targetX !== null) && state.grounded) {
                    const distToPipe = state.vx > 0 ? box.x - (state.x + state.width) : state.x - (box.x + box.w);
                    if (distToPipe > 0 && distToPipe < 34) {
                        triggerJump(false);
                    }
                }

                if (overlapX) {
                    // Mendarat di atas pipa
                    if (prevY >= pipeTop - 10 && state.y <= pipeTop && state.vy <= 0) {
                        state.y = pipeTop;
                        state.vy = 0;
                        landedOnSurface = true;
                    } else if (state.y < pipeTop - 6) {
                        // Menabrak sisi kiri/kanan pipa
                        if (prevX + state.width <= box.x + 12) {
                            state.x = box.x - state.width + 6;
                            if (state.autoPatrol) triggerJump(false);
                        } else if (prevX >= box.x + box.w - 12) {
                            state.x = box.x + box.w - 6;
                            if (state.autoPatrol) triggerJump(false);
                        }
                    }
                }
            });

            // 4. Interaksi dengan Platform Blok Melayang ([🧱][?][🧱][?][🧱])
            const platformEl = document.getElementById('stagePlatform');
            if (platformEl) {
                const pBox = getArenaBox(platformEl);
                const pTop = pBox.y + pBox.h;
                const pBottom = pBox.y;
                const overlapX = state.x + state.width - 6 > pBox.x && state.x + 6 < pBox.x + pBox.w;

                if (overlapX) {
                    // Mendarat di atas deretan blok
                    if (prevY >= pTop - 10 && state.y <= pTop && state.vy <= 0) {
                        state.y = pTop;
                        state.vy = 0;
                        landedOnSurface = true;
                    }
                    // Menyundul blok dari bawah saat melompat ke atas!
                    else if (prevY + state.height <= pBottom + 10 && state.y + state.height >= pBottom && state.vy > 0) {
                        state.y = pBottom - state.height;
                        state.vy = -2.2;

                        // Cari blok tepat di atas kepala Mario & keluarkan koin!
                        const marioCenterX = state.x + state.width / 2;
                        const blocks = platformEl.querySelectorAll('.m-block');
                        blocks.forEach((blk) => {
                            const bBox = getArenaBox(blk);
                            if (marioCenterX >= bBox.x - 4 && marioCenterX <= bBox.x + bBox.w + 4) {
                                addCoin(blk);
                                setStatusText('COIN +1! 🪙');
                            }
                        });
                    }
                }
            }

            state.grounded = landedOnSurface;

            // 5. Koleksi Item: Koin (🪙), Super Mushroom (🍄), Super Star (⭐), dan Kastil (🏰)
            const collectibles = arena.querySelectorAll('[data-collect]');
            collectibles.forEach((item) => {
                if (item.getAttribute('data-taken') === '1' || item.offsetParent === null) return;
                const iBox = getArenaBox(item);
                const hit =
                    state.x + state.width > iBox.x + 4 &&
                    state.x < iBox.x + iBox.w - 4 &&
                    state.y + state.height > iBox.y + 4 &&
                    state.y < iBox.y + iBox.h - 4;

                if (hit) {
                    const kind = item.getAttribute('data-collect');
                    if (kind === 'coin') {
                        item.setAttribute('data-taken', '1');
                        item.classList.add('item-collected');
                        addCoin(null);
                        setStatusText('COIN +1! 🪙');
                        setTimeout(() => {
                            item.classList.remove('item-collected');
                            item.removeAttribute('data-taken');
                        }, 4000);
                    } else if (kind === 'shroom') {
                        item.setAttribute('data-taken', '1');
                        item.classList.add('item-collected');
                        playMarioSound('powerup');
                        addCoin(null);
                        marioEl.classList.add('is-super');
                        if (powerTagEl) powerTagEl.textContent = 'SUPER!';
                        setStatusText('SUPER MARIO! 🍄');
                        setTimeout(() => {
                            item.classList.remove('item-collected');
                            item.removeAttribute('data-taken');
                        }, 6000);
                    } else if (kind === 'star') {
                        item.setAttribute('data-taken', '1');
                        item.classList.add('item-collected');
                        playMarioSound('powerup');
                        addCoin(null);
                        marioEl.classList.add('is-star');
                        if (powerTagEl) powerTagEl.textContent = 'STAR ★';
                        setStatusText('INVINCIBLE! ⭐');
                        setTimeout(() => {
                            marioEl.classList.remove('is-star');
                            if (powerTagEl) {
                                powerTagEl.textContent = marioEl.classList.contains('is-super') ? 'SUPER!' : 'M3';
                            }
                        }, 5000);
                        setTimeout(() => {
                            item.classList.remove('item-collected');
                            item.removeAttribute('data-taken');
                        }, 7000);
                    } else if (kind === 'castle') {
                        item.setAttribute('data-taken', '1');
                        playMarioSound('clear');
                        addCoin(item);
                        if (powerTagEl) powerTagEl.textContent = 'CLEAR! 🏆';
                        setStatusText('STAGE CLEAR! 🏰');
                        setTimeout(() => {
                            item.removeAttribute('data-taken');
                        }, 2500);
                    }
                }
            });

            // 6. Render posisi & class animasi Mario
            marioEl.style.left = `${state.x.toFixed(1)}px`;
            marioEl.style.bottom = `${state.y.toFixed(1)}px`;
            marioEl.classList.toggle('face-left', state.facingLeft);
            marioEl.classList.toggle('is-running', Math.abs(state.vx) > 0.35 && state.grounded);
            marioEl.classList.toggle('is-jumping', !state.grounded);

            requestAnimationFrame(updateGameLoop);
        };

        requestAnimationFrame(updateGameLoop);
    }

    // D. Interaksi Form Guestbook: Chip Reaksi Cepat & Live Preview Saat Mengetik
    const namaInput = document.getElementById('nama');
    const pesanInput = document.getElementById('pesan');
    const charCounter = document.getElementById('charCounter');
    const previewBox = document.getElementById('guestbookLivePreview');
    const previewAvatar = document.getElementById('previewAvatar');
    const previewAuthor = document.getElementById('previewAuthor');
    const previewBody = document.getElementById('previewBody');

    const updateLivePreview = () => {
        if (!namaInput || !pesanInput || !previewBox) return;
        const nVal = namaInput.value.trim();
        const pVal = pesanInput.value.trim();

        if (nVal === '' && pVal === '') {
            previewBox.style.display = 'none';
            return;
        }

        previewBox.style.display = 'block';
        if (previewAuthor) previewAuthor.textContent = nVal !== '' ? nVal : 'Nama Anda';
        if (previewAvatar) previewAvatar.textContent = nVal !== '' ? nVal.charAt(0).toUpperCase() : '?';
        if (previewBody) previewBody.textContent = pVal !== '' ? pVal : 'Menulis pesan...';
    };

    if (namaInput && pesanInput) {
        namaInput.addEventListener('input', updateLivePreview);
        pesanInput.addEventListener('input', updateLivePreview);
        updateLivePreview();
    }

    const reactionChips = document.querySelectorAll('.reaction-chip');
    reactionChips.forEach((chip) => {
        chip.addEventListener('click', () => {
            if (!pesanInput) return;
            const textToInsert = chip.getAttribute('data-text') || '';
            const current = pesanInput.value;
            pesanInput.value = current ? `${current.trim()} ${textToInsert}` : textToInsert;
            pesanInput.focus();
            if (charCounter) {
                charCounter.textContent = `${pesanInput.value.length} / 1000`;
            }
            updateLivePreview();
            addCoin(chip);
        });
    });

    // E. Tombol Like Koin pada Daftar Pesan Guestbook
    const entryCoinBtns = document.querySelectorAll('.entry-coin-btn');
    entryCoinBtns.forEach((btn) => {
        const entryId = btn.getAttribute('data-entry-id') || '0';
        const numSpan = btn.querySelector('.coin-like-num');
        const storageKey = `dini_gb_like_${entryId}`;
        let likes = parseInt(localStorage.getItem(storageKey) || '1', 10);
        if (numSpan) numSpan.textContent = String(likes);

        btn.addEventListener('click', () => {
            likes += 1;
            localStorage.setItem(storageKey, String(likes));
            if (numSpan) numSpan.textContent = String(likes);
            addCoin(btn);
        });
    });
}

/**
 * 9. Format Waktu Relatif / "Berapa Waktu yang Lalu" (Relative Time Toggle)
 *    - Mengubah string datetime ISO/MySQL menjadi format ramah (contoh: "Baru saja", "5 menit lalu", dsb.)
 *    - Menyediakan tombol toggle global dan fitur klik pada tiap waktu pesan.
 */
function initRelativeTimeFormatter() {
    const timeElements = document.querySelectorAll('.entry-time');
    const toggleBtn = document.getElementById('timeFormatToggleBtn');
    if (timeElements.length === 0) return;

    let useRelative = localStorage.getItem('dini_relative_time') !== '0'; // default aktif

    const getRelativeTimeString = (dateStr) => {
        if (!dateStr) return '';
        // Ganti spasi dengan 'T' untuk kompatibilitas parsing di seluruh browser
        const normalized = dateStr.replace(' ', 'T');
        const parsed = new Date(normalized);
        if (isNaN(parsed.getTime())) return dateStr;

        const now = new Date();
        const diffSec = Math.floor((now.getTime() - parsed.getTime()) / 1000);

        if (diffSec < 45) return 'Baru saja ⚡';
        if (diffSec < 90) return '1 menit lalu';
        if (diffSec < 3600) return `${Math.floor(diffSec / 60)} menit lalu`;
        if (diffSec < 7200) return '1 jam lalu';
        if (diffSec < 86400) return `${Math.floor(diffSec / 3600)} jam lalu`;
        if (diffSec < 172800) return 'Kemarin';
        if (diffSec < 604800) return `${Math.floor(diffSec / 86400)} hari lalu`;
        if (diffSec < 2592000) return `${Math.floor(diffSec / 604800)} minggu lalu`;

        return dateStr; // Jika sudah lewat sebulan, tampilkan tanggal aslinya
    };

    const updateDisplay = () => {
        timeElements.forEach((el) => {
            const originalTime = el.getAttribute('datetime') || el.textContent.trim();
            if (!el.getAttribute('data-raw-time')) {
                el.setAttribute('data-raw-time', originalTime);
            }
            const rawTime = el.getAttribute('data-raw-time');

            if (useRelative) {
                el.textContent = getRelativeTimeString(rawTime);
                el.setAttribute('title', `Tanggal Asli: ${rawTime} (Klik untuk beralih)`);
            } else {
                el.textContent = rawTime;
                el.setAttribute('title', `Waktu Relatif: ${getRelativeTimeString(rawTime)} (Klik untuk beralih)`);
            }
        });

        if (toggleBtn) {
            const labelEl = toggleBtn.querySelector('.time-toggle-label');
            const iconEl = toggleBtn.querySelector('.time-toggle-icon');
            if (labelEl) {
                labelEl.textContent = useRelative ? 'Waktu Relatif' : 'Waktu Asli';
            }
            if (iconEl) {
                iconEl.textContent = useRelative ? '⏱️' : '📅';
            }
        }
    };

    updateDisplay();

    // Toggle via tombol di header daftar pesan
    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            useRelative = !useRelative;
            localStorage.setItem('dini_relative_time', useRelative ? '1' : '0');
            updateDisplay();
        });
    }

    // Tiap item waktu dapat diklik langsung oleh pengunjung
    timeElements.forEach((el) => {
        el.addEventListener('click', () => {
            useRelative = !useRelative;
            localStorage.setItem('dini_relative_time', useRelative ? '1' : '0');
            updateDisplay();
        });
    });

    // Update otomatis tiap 60 detik agar "x menit lalu" selalu akurat
    setInterval(() => {
        if (useRelative) {
            updateDisplay();
        }
    }, 60000);
}

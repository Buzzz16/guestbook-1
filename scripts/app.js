// ============================================================================
// PORTFOLIO GLOBAL APP CONTROLLER (Vanilla JS - Zero Dependencies)
// ============================================================================

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    const siteConfig = window.siteConfig || {};
    const corner = document.querySelector('.corner');
    const dock = document.querySelector('.c-dock');
    const dockExplore = document.querySelector('.c-dock-explore');
        const qaTab = document.querySelector('.c-qa-tab');
    const qaAside = document.querySelector('.c-qa');
    const qaToggle = document.querySelector('.c-qa-toggle');
    const qaScrim = document.querySelector('.c-qa-scrim');

    // ==========================================================================
    // 1. THEME SWITCHER (Dark Mode / Light Mode)
    // ==========================================================================
    const themeButtons = document.querySelectorAll('#qaThemeToggle, .c-theme');

    function getPreferredTheme() {
      const saved = localStorage.getItem('corner-theme');
      if (saved === 'light' || saved === 'dark') return saved;
      return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    function renderThemeIcons(theme) {
      themeButtons.forEach(btn => {
        btn.setAttribute('data-tip', theme === 'dark' ? 'Light mode' : 'Dark mode');
        btn.setAttribute('aria-label', theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
        const iconSvg = theme === 'dark'
          ? `<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" viewBox="0 0 256 256">
              <path d="M120,40V16a8,8,0,0,1,16,0V40a8,8,0,0,1-16,0Zm72,88a64,64,0,1,1-64-64A64.07,64.07,0,0,1,192,128Zm-16,0a48,48,0,1,0-48,48A48.05,48.05,0,0,0,176,128ZM58.34,69.66a8,8,0,0,0,11.32-11.32l-16-16a8,8,0,0,0-11.32,11.32Zm0,116.68-16,16a8,8,0,0,0,11.32,11.32l16-16a8,8,0,0,0-11.32-11.32ZM197.66,58.34a8,8,0,0,0-11.32,11.32l16,16a8,8,0,0,0,11.32-11.32ZM120,216v24a8,8,0,0,0,16,0V216a8,8,0,0,0-16,0ZM40,120H16a8,8,0,0,0,0,16H40a8,8,0,0,0,0-16Zm200,0H216a8,8,0,0,0,0,16h24a8,8,0,0,0,0-16Zm-53.66,66.34a8,8,0,0,0-11.32,11.32l16,16a8,8,0,0,0,11.32-11.32Z"/>
            </svg>`
          : `<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" viewBox="0 0 256 256">
              <path d="M227.89,147.89A96,96,0,1,1,108.11,28.11,96.09,96.09,0,0,0,227.89,147.89Z" opacity="0.2"/>
              <path d="M233.54,142.23a8,8,0,0,0-8-2,88.08,88.08,0,0,1-109.8-109.8,8,8,0,0,0-10-10,104.84,104.84,0,0,0-52.91,37A104,104,0,0,0,136,224a103.09,103.09,0,0,0,62.52-20.88,104.84,104.84,0,0,0,37-52.91A8,8,0,0,0,233.54,142.23ZM188.9,190.34A88,88,0,0,1,65.66,67.11a89,89,0,0,1,31.4-26A106,106,0,0,0,96,56,104.11,104.11,0,0,0,200,160a106,106,0,0,0,14.92-1.06A89,89,0,0,1,188.9,190.34Z"/>
            </svg>`;
        const iconContainer = btn.querySelector('.theme-icon');
        if (iconContainer) {
          iconContainer.innerHTML = iconSvg;
        } else {
          btn.innerHTML = iconSvg;
        }
        const label = btn.querySelector('.c-theme-label');
        if (label) {
          label.textContent = theme === 'dark' ? 'Light mode' : 'Dark mode';
        }
      });
    }

    function applyTheme(theme) {
      document.documentElement.setAttribute('data-theme', theme);
      document.documentElement.style.colorScheme = theme;
      if (corner) corner.setAttribute('data-theme', theme);

      const isDark = theme === 'dark';
      const bg = isDark ? '#0e0e0e' : '#fafafa';
      const fg = isDark ? '#f4f4f5' : '#111111';

      // Only override if body doesn't have custom room theme background (like creative blue or engineer black)
      const currentRoom = corner ? corner.getAttribute('data-room') : '';
      if (currentRoom === 'me' || !currentRoom) {
        document.body.style.background = bg;
        document.body.style.color = fg;
      }

      

      renderThemeIcons(theme);

      if (window.silhouetteInstance && typeof window.silhouetteInstance.requestRender === 'function') {
        window.silhouetteInstance.requestRender();
      }
    }

    let currentTheme = getPreferredTheme();
    applyTheme(currentTheme);

    themeButtons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('corner-theme', currentTheme);
        applyTheme(currentTheme);
      });
    });

    // ==========================================================================
    // 2. QUICK ACCESS DRAWER & SCRIM
    // ==========================================================================
    function setQaOpen(isOpen) {
      if (!qaAside) return;
      qaAside.setAttribute('data-open', isOpen ? 'true' : 'false');
      if (qaScrim) qaScrim.style.display = isOpen ? 'block' : 'none';
      if (qaToggle) qaToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      if (qaTab) qaTab.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    // Default to closed
    setQaOpen(false);

    if (qaAside) {
      // Smooth hover expansion & auto-collapse when cursor leaves
      qaAside.addEventListener('mouseenter', () => setQaOpen(true));
      qaAside.addEventListener('mouseleave', () => setQaOpen(false));
      qaAside.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => setQaOpen(false));
      });
    }

    if (qaTab) qaTab.addEventListener('click', (e) => { e.preventDefault(); e.stopPropagation(); setQaOpen(true); });
    if (qaToggle) {
      qaToggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const isOpen = qaAside.getAttribute('data-open') === 'true';
        setQaOpen(!isOpen);
      });
    }
    if (qaScrim) qaScrim.addEventListener('click', () => setQaOpen(false));

    // Auto-close on click outside so it never covers page content
    document.addEventListener('click', (e) => {
      if (qaAside && !qaAside.contains(e.target) && (!qaTab || !qaTab.contains(e.target))) {
        setQaOpen(false);
      }
    });

    // Auto-close on scroll immediately
    window.addEventListener('scroll', () => {
      setQaOpen(false);
    }, { passive: true });

    function closeAllModals() {
      document.querySelectorAll('.c-peek-root').forEach(m => m.style.display = 'none');
      document.body.style.overflow = '';
    }

    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        setQaOpen(false);
        closeAllModals();
      }
    });

    // ==========================================================================
    // 3. AMBIENT AUDIO SYNTHESIZER (Web Audio API)
    // ==========================================================================
    const musicButtons = document.querySelectorAll('.c-music, #qaMusicToggle, [data-tip*="music" i]');
    let audioCtx = null;
    let isPlayingAudio = false;
    let activeOscillators = [];
    let audioGainNode = null;

    function startAmbientSound(mode = 'chill') {
      try {
        if (!audioCtx) {
          audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        }
        if (audioCtx.state === 'suspended') {
          audioCtx.resume();
        }

        const now = audioCtx.currentTime;
        audioGainNode = audioCtx.createGain();
        audioGainNode.gain.setValueAtTime(0.001, now);
        audioGainNode.gain.exponentialRampToValueAtTime(0.12, now + 1.8);

        const filter = audioCtx.createBiquadFilter();
        filter.type = 'lowpass';
        filter.frequency.setValueAtTime(320, now);
        filter.frequency.exponentialRampToValueAtTime(1400, now + 3);

        const frequencies = mode === 'house'
          ? [130.81, 164.81, 196.00, 246.94, 293.66] // C maj 9 groove
          : [146.83, 220.00, 293.66, 369.99, 440.00]; // Warm D maj 9 ambient

        activeOscillators = frequencies.map((freq, i) => {
          const osc = audioCtx.createOscillator();
          osc.type = i % 2 === 0 ? 'sine' : 'triangle';
          osc.frequency.setValueAtTime(freq, now);
          osc.connect(filter);
          osc.start(now);
          return osc;
        });

        filter.connect(audioGainNode);
        audioGainNode.connect(audioCtx.destination);
        isPlayingAudio = true;
        updateMusicButtonsUI(true);
      } catch (err) {
        console.warn('AudioContext not allowed yet:', err);
      }
    }

    function stopAmbientSound() {
      if (!audioCtx || !isPlayingAudio) return;
      const now = audioCtx.currentTime;
      if (audioGainNode) {
        audioGainNode.gain.setValueAtTime(audioGainNode.gain.value, now);
        audioGainNode.gain.exponentialRampToValueAtTime(0.0001, now + 0.8);
      }
      setTimeout(() => {
        activeOscillators.forEach(osc => { try { osc.stop(); osc.disconnect(); } catch (_) {} });
        activeOscillators = [];
        isPlayingAudio = false;
        updateMusicButtonsUI(false);
      }, 850);
    }

    function updateMusicButtonsUI(playing) {
      musicButtons.forEach(btn => {
        btn.setAttribute('data-status', playing ? 'playing' : 'idle');
        btn.setAttribute('data-tip', playing ? 'Sound playing (click to mute)' : 'Play ambient sound');
        btn.setAttribute('aria-label', playing ? 'Pause ambient sound' : 'Play ambient sound');
        if (playing) {
          btn.style.color = '#22c55e';
          btn.classList.add('is-playing');
        } else {
          btn.style.color = '';
          btn.classList.remove('is-playing');
        }
        const label = btn.querySelector('.c-music-label');
        if (label) {
          label.textContent = playing ? 'Mute sound' : 'Play music';
        }
      });
    }

    musicButtons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        if (isPlayingAudio) {
          stopAmbientSound();
        } else {
          startAmbientSound('chill');
        }
      });
    });

    window.playAmbientSound = startAmbientSound;
    window.stopAmbientSound = stopAmbientSound;

    // ==========================================================================
    // 4. FLOATING DOCK PHYSICS & SCROLL REVEAL
    // ==========================================================================
    let lastScrollY = window.scrollY;
    let dockTimeout = null;

    function onScroll() {
      if (!dock) return;
      const currentScrollY = window.scrollY;
      const scrollHeight = document.documentElement.scrollHeight;
      const isAtBottom = window.innerHeight + currentScrollY >= scrollHeight - 60 && currentScrollY > 150;

      dock.setAttribute('data-big', isAtBottom ? 'true' : 'false');
      if (dockExplore) dockExplore.setAttribute('data-show', isAtBottom ? 'true' : 'false');

      const isScrollingDown = currentScrollY > lastScrollY && currentScrollY > 140;
      dock.setAttribute('data-hidden', (!isAtBottom && isScrollingDown) ? 'true' : 'false');

      clearTimeout(dockTimeout);
      dockTimeout = setTimeout(() => {
        dock.setAttribute('data-hidden', 'false');
      }, 300);

      lastScrollY = currentScrollY;
    }

    window.addEventListener('scroll', onScroll, { passive: true });

    // ==========================================================================
    // 5. DOORS HOVER ACCORDION (Home Page)
    // ==========================================================================
    const doors = document.querySelectorAll('.c-door2');
    const doorsParent = document.querySelector('.c-doors');
    if (doorsParent && doors.length) {
      doorsParent.addEventListener('mouseleave', () => {
        doors.forEach(d => {
          d.setAttribute('data-active', 'false');
          d.setAttribute('data-dim', 'false');
        });
      });

      doors.forEach(door => {
        door.addEventListener('mouseenter', () => {
          doors.forEach(sibling => {
            if (sibling === door) {
              sibling.setAttribute('data-active', 'true');
              sibling.setAttribute('data-dim', 'false');
            } else {
              sibling.setAttribute('data-active', 'false');
              sibling.setAttribute('data-dim', 'true');
            }
          });
        });
      });
    }

    // ==========================================================================
    // 6. ROLE PEEK MODAL DIALOG
    // ==========================================================================
    const peekRoot = document.querySelector('.c-peek-root') || document.getElementById('roleModal');
    const peekBg = document.querySelector('.c-peek-bg') || document.getElementById('peekBg');
    const peekClose = document.querySelector('.c-peek-close') || document.getElementById('peekCloseBtn');
    const peekTitle = document.querySelector('.c-wordpeek-title') || document.getElementById('peekModalTitle');
    const peekGrid = document.querySelector('.c-wordpeek-grid') || document.getElementById('peekModalGrid');
    const peekEmpty = document.querySelector('.c-wordpeek-empty');

    function openModal(title, desc = '', tags = []) {
      if (!peekRoot) return;
      if (peekTitle) peekTitle.textContent = title;

      if (peekGrid) {
        peekGrid.innerHTML = '';
        const catalog = siteConfig.catalogWorks || [];
        const q = title.toLowerCase();
        const matches = catalog.filter(item =>
          item.title.toLowerCase().includes(q) ||
          item.role.toLowerCase().includes(q) ||
          (item.tags && item.tags.some(t => q.includes(t) || t.includes(q)))
        );

        if (matches.length > 0) {
          if (peekEmpty) peekEmpty.style.display = 'none';
          matches.slice(0, 4).forEach(item => {
            const card = document.createElement('div');
            card.className = 'c-wordpeek-card';
            card.style.cssText = 'background: rgba(0,0,0,0.04); border-radius: 12px; padding: 16px; margin-bottom: 12px;';
            card.innerHTML = `
              <div style="font-family: var(--font-druk); font-size: 14px; text-transform: uppercase;">${item.title}</div>
              <div class="c-eyebrow" style="color: var(--muted); font-size: 11px; margin: 4px 0;">${item.role} · ${item.year}</div>
              <p style="font-size: 13.5px; line-height: 1.5; color: var(--fg); opacity: 0.85;">${item.summary}</p>
            `;
            peekGrid.appendChild(card);
          });
        } else {
          if (peekEmpty) peekEmpty.style.display = 'block';
          peekGrid.innerHTML = `
            <div style="padding: 24px; text-align: center; color: var(--muted);">
              <p style="font-size: 15px; margin-bottom: 12px;">Work and milestones related to <b>${title}</b> across Ghana, Ashesi, and international ventures.</p>
              <a href="${siteConfig.rooms?.developer?.href || 'work/'}" class="c-btn c-btn-primary" style="display: inline-block; padding: 8px 18px; border-radius: 999px;">Explore The Full Catalogue →</a>
            </div>
          `;
        }
      }

      peekRoot.style.display = 'grid';
      document.body.style.overflow = 'hidden';
      requestAnimationFrame(() => {
        peekRoot.setAttribute('data-open', 'true');
      });
    }

    function closeModal() {
      if (!peekRoot) return;
      peekRoot.setAttribute('data-open', 'false');
      document.body.style.overflow = '';
      setTimeout(() => {
        peekRoot.style.display = 'none';
      }, 220);
    }

    if (peekBg) peekBg.addEventListener('click', closeModal);
    if (peekClose) peekClose.addEventListener('click', closeModal);

    // Marquee badge click handlers on Home Page
    document.querySelectorAll('.c-iam').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        openModal(btn.textContent.trim());
      });
    });

    window.openPortfolioModal = openModal;
    window.closePortfolioModal = closeModal;

    // ==========================================================================
    // 6.5 SCROLL REVEAL INTERSECTION OBSERVER
    // ==========================================================================
    const revealEls = document.querySelectorAll('.c-reveal, .c-rise, .c-eng-late');
    if ('IntersectionObserver' in window) {
      const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.setAttribute('data-in', 'true');
            revealObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.05, rootMargin: '0px 0px 60px 0px' });

      revealEls.forEach(el => revealObserver.observe(el));
    } else {
      revealEls.forEach(el => el.setAttribute('data-in', 'true'));
    }

    // ==========================================================================
    // 7. INITIALIZE WORDS SILHOUETTE (Home Page Only)
    // ==========================================================================
    if (typeof window.initSilhouette === 'function' && document.querySelector('.c-hero-stage')) {
      const allWords = siteConfig.marqueeGroups
        ? siteConfig.marqueeGroups.flatMap(g => g.words.map(w => w.w))
        : ["Glen", "David", "Hadiono", "Bandung", "Build", "Code", "Ship", "Engineer", "Informatics"];

      window.silhouetteInstance = window.initSilhouette({
        src: siteConfig.hero?.src || 'images/portrait/glen-cutout.webp',
        cutout: siteConfig.hero?.cutout !== false,
        focus: siteConfig.hero?.focus || { x: 0.50, y: 0.47 },
        backdrop: siteConfig.hero?.backdrop,
        words: allWords,
        brandWords: siteConfig.hero?.brandWords || ["Glen", "David", "Hadiono", "Bandung"],
        afterId: 'after-hero'
      });
    }

    // ==========================================================================
    // 8. HOME SPOTLIGHT INTERACTIVE PROJECT SWITCHER
    // ==========================================================================
    const tabLunch = document.getElementById('tabLunch');
    const tabValas = document.getElementById('tabValas');
    if (tabLunch) {
      tabLunch.addEventListener('click', () => window.switchSpotlight('lunch'));
    }
    if (tabValas) {
      tabValas.addEventListener('click', () => window.switchSpotlight('valas'));
    }
  });

  // Global spotlight switcher available immediately
  window.switchSpotlight = function(project) {
    const img = document.getElementById('spotlightImg');
    const badgeText = document.getElementById('spotlightBadgeText');
    const tabLunch = document.getElementById('tabLunch');
    const tabValas = document.getElementById('tabValas');
    if (!img) return;

    if (project === 'valas') {
      img.style.opacity = '0';
      setTimeout(() => {
        img.src = './images/opt/projects/valas-cms.webp';
        img.alt = 'Valas Company Profile CMS - PT Armada Valasindo';
        img.style.opacity = '1';
      }, 150);
      if (badgeText) badgeText.textContent = 'Armada Valasindo · Company Profile CMS';
      if (tabLunch) tabLunch.setAttribute('aria-pressed', 'false');
      if (tabValas) tabValas.setAttribute('aria-pressed', 'true');
    } else {
      img.style.opacity = '0';
      setTimeout(() => {
        img.src = './images/opt/projects/lunch-attendance.webp';
        img.alt = 'Internal Lunch Attendance & Billing System - PT Mekar Armada Jaya';
        img.style.opacity = '1';
      }, 150);
      if (badgeText) badgeText.textContent = 'New Armada Group · Lunch Attendance System';
      if (tabLunch) tabLunch.setAttribute('aria-pressed', 'true');
      if (tabValas) tabValas.setAttribute('aria-pressed', 'false');
    }
  };
})();

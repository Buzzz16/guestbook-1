// ============================================================================
// ENGINEER ROOM CONTROLLER: Digital Rain, Headline Typer & Flagships Carousel
// ============================================================================

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    // ------------------------------------------------------------------------
    // 1. MATRIX DIGITAL RAIN (Inside .c-eng-rain)
    // ------------------------------------------------------------------------
    const rainContainer = document.querySelector('.c-eng-rain');
    if (rainContainer) {
      let canvas = rainContainer.querySelector('canvas');
      if (!canvas) {
        canvas = document.createElement('canvas');
        canvas.className = 'c-eng-rain-canvas';
        canvas.setAttribute('aria-hidden', 'true');
        rainContainer.appendChild(canvas);
      }

      const ctx = canvas.getContext('2d');
      let width, height;
      let columns = [];
      const fontSize = 16;
      const glyphs = 'NANAAMOAKO01{}<>/=アカサタナハマヤラワガザダバパイキシチニヒミリヰギジヂビピウクスツヌフムユルグズヅブプエケセテネヘメレヱゲゼデベペオコソトノホモヨロヲゴゾドボポ';

      function resize() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
        const colCount = Math.floor(width / fontSize);
        columns = Array.from({ length: colCount }, () => Math.random() * -50);
      }
      resize();
      window.addEventListener('resize', resize, { passive: true });

      function drawRain() {
        const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
        ctx.fillStyle = isDark ? 'rgba(5, 10, 6, 0.14)' : 'rgba(242, 250, 244, 0.18)';
        ctx.fillRect(0, 0, width, height);

        ctx.fillStyle = isDark ? '#00ff66' : '#0a9c45';
        ctx.font = `${fontSize - 2}px "JetBrains Mono", monospace`;

        for (let i = 0; i < columns.length; i++) {
          const char = glyphs[Math.floor(Math.random() * glyphs.length)];
          const x = i * fontSize;
          const y = columns[i] * fontSize;

          ctx.fillText(char, x, y);

          if (y > height && Math.random() > 0.975) {
            columns[i] = 0;
          }
          columns[i] += 0.85;
        }
        requestAnimationFrame(drawRain);
      }
      requestAnimationFrame(drawRain);
    }

    // ------------------------------------------------------------------------
    // 1.5 INTRO PHASE TRANSITIONS (.c-eng-ident, .c-eng-black, .c-eng-late)
    // ------------------------------------------------------------------------
    const ident = document.querySelector('.c-eng-ident');
    const black = document.querySelector('.c-eng-black');
    const rain = document.querySelector('.c-eng-rain');
    const lateEls = document.querySelectorAll('.c-eng-late');
    let introFinished = false;

    function finishIntro() {
      if (introFinished) return;
      introFinished = true;
      if (ident) ident.setAttribute('data-phase', 'done');
      if (black) black.setAttribute('data-phase', 'done');
      if (rain) rain.setAttribute('data-phase', 'done');
      lateEls.forEach(el => el.setAttribute('data-in', 'true'));
    }

    setTimeout(() => {
      if (ident) ident.setAttribute('data-phase', 'rain');
      if (black) black.setAttribute('data-phase', 'rain');
    }, 1200);

    setTimeout(() => {
      finishIntro();
    }, 2400);

    // Skip intro on click
    document.addEventListener('click', () => {
      finishIntro();
    }, { once: true });

    // ------------------------------------------------------------------------
    // 2. TYPEWRITER EFFECT FOR ENGINEER TITLE
    // ------------------------------------------------------------------------
    const titleEl = document.querySelector('.c-eng-title');
    if (titleEl) {
      const line1 = 'I build things';
      const line2 = 'that compile.';
      const spans = titleEl.querySelectorAll('span');
      if (spans.length >= 2) {
        spans[0].textContent = '';
        spans[1].textContent = '';

        const caret = document.createElement('span');
        caret.style.cssText = 'display:inline-block;width:3px;height:1em;background:#00ff66;margin-left:4px;vertical-align:text-bottom;animation:cBlink 0.9s infinite;';
        
        let c1 = 0;
        let c2 = 0;

        function type1() {
          if (c1 < line1.length) {
            spans[0].textContent = line1.slice(0, c1 + 1);
            spans[0].appendChild(caret);
            c1++;
            setTimeout(type1, 55);
          } else {
            setTimeout(type2, 220);
          }
        }

        function type2() {
          if (c2 < line2.length) {
            spans[1].textContent = line2.slice(0, c2 + 1);
            spans[1].appendChild(caret);
            c2++;
            setTimeout(type2, 55);
          }
        }

        setTimeout(type1, 400);
      }
    }

    // ------------------------------------------------------------------------
    // 3. FLAGSHIP HORIZONTAL CAROUSEL (.c-hl-track)
    // ------------------------------------------------------------------------
    const track = document.querySelector('.c-hl-track');
    const dotsContainer = document.querySelector('.c-hl-dots');
    const playBtn = document.querySelector('.c-hl-play');
    const skipBtn = document.querySelector('.c-eng-skip');

    if (skipBtn) {
      skipBtn.addEventListener('click', () => {
        const flagships = document.getElementById('flagships');
        if (flagships) flagships.scrollIntoView({ behavior: 'smooth' });
      });
    }

    if (track) {
      const cards = track.querySelectorAll('.c-hl-card');
      const dots = dotsContainer ? dotsContainer.querySelectorAll('button') : [];
      let currentIndex = 0;
      let isPlaying = true;
      let autoTimer = null;

      function updateActiveDot(idx) {
        currentIndex = idx;
        dots.forEach((dot, i) => {
          dot.setAttribute('aria-selected', i === idx ? 'true' : 'false');
        });
      }

      function scrollToCard(idx) {
        if (!cards[idx]) return;
        const card = cards[idx];
        const cardLeft = card.offsetLeft - track.offsetLeft;
        track.scrollTo({ left: cardLeft - 20, behavior: 'smooth' });
        updateActiveDot(idx);
      }

      dots.forEach((dot, idx) => {
        dot.addEventListener('click', () => {
          scrollToCard(idx);
          resetAutoPlay();
        });
      });

      // Track scroll observer
      track.addEventListener('scroll', () => {
        const scrollLeft = track.scrollLeft;
        let closestIdx = 0;
        let minDiff = Infinity;
        cards.forEach((card, idx) => {
          const diff = Math.abs(card.offsetLeft - track.offsetLeft - 20 - scrollLeft);
          if (diff < minDiff) {
            minDiff = diff;
            closestIdx = idx;
          }
        });
        if (closestIdx !== currentIndex) {
          updateActiveDot(closestIdx);
        }
      }, { passive: true });

      function nextSlide() {
        const nextIdx = (currentIndex + 1) % cards.length;
        scrollToCard(nextIdx);
      }

      function startAutoPlay() {
        if (autoTimer) clearInterval(autoTimer);
        autoTimer = setInterval(nextSlide, 5000);
        isPlaying = true;
        if (playBtn) playBtn.setAttribute('aria-label', 'Pause');
      }

      function stopAutoPlay() {
        if (autoTimer) clearInterval(autoTimer);
        isPlaying = false;
        if (playBtn) playBtn.setAttribute('aria-label', 'Play');
      }

      function resetAutoPlay() {
        if (isPlaying) {
          startAutoPlay();
        }
      }

      if (playBtn) {
        playBtn.addEventListener('click', () => {
          if (isPlaying) {
            stopAutoPlay();
          } else {
            startAutoPlay();
          }
        });
      }

      startAutoPlay();

      track.addEventListener('mouseenter', stopAutoPlay);
      track.addEventListener('mouseleave', () => { if (isPlaying) startAutoPlay(); });
    }
  });
})();

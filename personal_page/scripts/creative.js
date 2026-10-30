// ============================================================================
// CREATIVE ROOM CONTROLLER: DaVinci Resolve Slider & Turntable Deck
// ============================================================================

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {

    // ========================================================================
    // 1. DAVINCI RESOLVE BEFORE/AFTER COLOR GRADING SLIDER
    // ========================================================================
    const baContainers = document.querySelectorAll('.c-ba');

    baContainers.forEach(ba => {
      const beforeDiv = ba.querySelector('.c-ba-before');
      const handle = ba.querySelector('.c-ba-handle');
      const rangeInput = ba.querySelector('input[type="range"]');

      // Prevent native ghost image drag
      ba.querySelectorAll('img').forEach(img => {
        img.style.pointerEvents = 'none';
        img.style.userSelect = 'none';
        img.setAttribute('draggable', 'false');
      });
      ba.style.touchAction = 'none';
      ba.style.cursor = 'ew-resize';

      ba.addEventListener('dragstart', e => e.preventDefault());

      function setSliderPosition(percentage) {
        const p = Math.max(0, Math.min(100, percentage));
        if (beforeDiv) {
          beforeDiv.style.clipPath = `inset(0 ${100 - p}% 0 0)`;
        }
        if (handle) {
          handle.style.left = `${p}%`;
        }
        if (rangeInput) {
          rangeInput.value = p;
        }
      }

      // Initialize at 50%
      setSliderPosition(50);

      if (rangeInput) {
        rangeInput.addEventListener('input', e => setSliderPosition(+e.target.value));
      }

      let isDragging = false;

      function updateFromPointer(e) {
        const rect = ba.getBoundingClientRect();
        const clientX = e.clientX ?? (e.touches && e.touches[0] ? e.touches[0].clientX : 0);
        const percent = ((clientX - rect.left) / rect.width) * 100;
        setSliderPosition(percent);
      }

      ba.addEventListener('pointerdown', (e) => {
        isDragging = true;
        try { ba.setPointerCapture(e.pointerId); } catch (_) {}
        updateFromPointer(e);
      });

      ba.addEventListener('pointermove', (e) => {
        if (!isDragging) return;
        updateFromPointer(e);
      });

      function stopDrag(e) {
        if (!isDragging) return;
        isDragging = false;
        try { ba.releasePointerCapture(e.pointerId); } catch (_) {}
      }

      ba.addEventListener('pointerup', stopDrag);
      ba.addEventListener('pointercancel', stopDrag);

      // Keyboard arrow keys accessibility
      ba.tabIndex = 0;
      ba.setAttribute('role', 'slider');
      ba.setAttribute('aria-label', 'Before and after color grade comparison');
      ba.addEventListener('keydown', (e) => {
        let current = rangeInput ? +rangeInput.value : 50;
        if (e.key === 'ArrowLeft') {
          setSliderPosition(current - 5);
          e.preventDefault();
        } else if (e.key === 'ArrowRight') {
          setSliderPosition(current + 5);
          e.preventDefault();
        }
      });
    });

    // ========================================================================
    // 2. VINYL TURNTABLE DECK
    // ========================================================================
    const deck = document.querySelector('.m-deck');
    if (deck) {
      const vinylSpin = deck.querySelector('.m-vinyl-spin');
      const statusLabel = deck.querySelector('p');
      let isSpinning = false;

      deck.style.cursor = 'pointer';
      deck.setAttribute('role', 'button');
      deck.setAttribute('aria-label', 'Toggle DJ turntable vinyl');

      deck.addEventListener('click', (e) => {
        e.preventDefault();
        isSpinning = !isSpinning;
        deck.setAttribute('data-playing', isSpinning ? 'true' : 'false');

        if (vinylSpin) {
          if (isSpinning) {
            vinylSpin.classList.add('is-spinning');
            vinylSpin.style.animation = 'vinylSpin 3.5s linear infinite';
          } else {
            vinylSpin.classList.remove('is-spinning');
            vinylSpin.style.animation = 'none';
          }
        }

        if (statusLabel) {
          statusLabel.textContent = isSpinning
            ? 'Now spinning: Accra House & Afrobeats ♫ (Click to pause)'
            : 'Click turntable to spin ↺';
          statusLabel.style.color = isSpinning ? '#60a5fa' : '#9ca3af';
          statusLabel.style.fontWeight = isSpinning ? '600' : '400';
        }

        if (isSpinning && window.playAmbientSound) {
          window.playAmbientSound('house');
        } else if (!isSpinning && window.stopAmbientSound) {
          window.stopAmbientSound();
        }
      });
    }

  });
})();

// ============================================================================
// WORK CATALOGUE CONTROLLER: Filtering, Search, Grid/List Views & Project Modal
// ============================================================================

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    const cards = Array.from(document.querySelectorAll('.c-card.c-work-card'));
    const searchInput = document.querySelector('.c-search input');
    const countEl = document.querySelector('.c-muted b');
    
    // Find room chips (first .c-chips container)
    const chipContainers = document.querySelectorAll('.c-chips');
    const roomChips = chipContainers[0] ? Array.from(chipContainers[0].querySelectorAll('button')) : [];
    const filterChips = chipContainers[1] ? Array.from(chipContainers[1].querySelectorAll('button')) : [];

    // View toggle buttons (inside .c-seg)
    const segButtons = document.querySelectorAll('.c-seg button');
    const galleryViewBtn = segButtons[0];
    const listViewBtn = segButtons[1];
    const gridContainers = document.querySelectorAll('.c-grid-4');

    // Surprise Me button
    const surpriseBtn = document.querySelector('button.c-btn:has(svg.lucide-shuffle)');

    let activeRoom = 'Everything';
    let activeTag = null;
    let searchQuery = '';

    // Index all cards with their metadata for fast filtering
    const cardData = cards.map(card => {
      const title = (card.querySelector('h3') ? card.querySelector('h3').textContent : '').trim();
      const desc = (card.querySelector('p') ? card.querySelector('p').textContent : '').trim();
      const eyebrow = (card.querySelector('.c-eyebrow') ? card.querySelector('.c-eyebrow').textContent : '').trim();
      const tags = Array.from(card.querySelectorAll('.c-tag')).map(t => t.textContent.trim());
      const section = card.closest('div[id]') ? card.closest('div[id]').id : '';
      
      return {
        card,
        title,
        desc,
        eyebrow,
        tags,
        section,
        allText: `${title} ${desc} ${eyebrow} ${tags.join(' ')} ${section}`.toLowerCase()
      };
    });

    function applyFilters() {
      let visible = 0;
      const q = searchQuery.toLowerCase().trim();

      cardData.forEach(item => {
        let match = true;

        // Room filter
        if (activeRoom !== 'Everything') {
          const roomLower = activeRoom.toLowerCase();
          if (roomLower === 'engineer') {
            match = item.allText.includes('coding') || item.allText.includes('machine learning') || item.allText.includes('apps') || item.section === 'apps' || item.allText.includes('developer');
          } else if (roomLower === 'creative') {
            match = item.allText.includes('photo') || item.allText.includes('video') || item.allText.includes('design') || item.allText.includes('brand') || item.section === 'photo';
          } else if (roomLower === 'me') {
            match = item.allText.includes('ventures') || item.allText.includes('writing') || item.allText.includes('roles') || item.section === 'ventures';
          }
        }

        // Quick tag filter
        if (match && activeTag) {
          const tagLower = activeTag.toLowerCase();
          match = item.allText.includes(tagLower);
        }

        // Search query
        if (match && q) {
          match = item.allText.includes(q);
        }

        if (match) {
          item.card.style.display = '';
          visible++;
        } else {
          item.card.style.display = 'none';
        }
      });

      // Update count
      if (countEl) {
        countEl.textContent = visible;
      }

      // Hide category headings if all their cards are hidden
      document.querySelectorAll('div[id]').forEach(sec => {
        const secCards = sec.querySelectorAll('.c-work-card');
        if (secCards.length > 0) {
          const anyVisible = Array.from(secCards).some(c => c.style.display !== 'none');
          sec.style.display = anyVisible ? '' : 'none';
        }
      });
    }

    // Room chip listeners
    roomChips.forEach(chip => {
      chip.addEventListener('click', () => {
        roomChips.forEach(c => c.setAttribute('aria-pressed', 'false'));
        chip.setAttribute('aria-pressed', 'true');
        activeRoom = chip.textContent.trim();
        applyFilters();
      });
    });

    // Quick tag filter listeners
    filterChips.forEach(chip => {
      chip.addEventListener('click', () => {
        const wasPressed = chip.getAttribute('aria-pressed') === 'true';
        filterChips.forEach(c => c.setAttribute('aria-pressed', 'false'));
        if (wasPressed) {
          activeTag = null;
        } else {
          chip.setAttribute('aria-pressed', 'true');
          activeTag = chip.textContent.trim();
        }
        applyFilters();
      });
    });

    // Search input listener
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value;
        applyFilters();
      });
    }

    // View toggles (Grid vs List)
    if (galleryViewBtn && listViewBtn) {
      galleryViewBtn.addEventListener('click', () => {
        galleryViewBtn.setAttribute('aria-pressed', 'true');
        listViewBtn.setAttribute('aria-pressed', 'false');
        gridContainers.forEach(g => {
          g.classList.remove('c-list-view');
          g.classList.add('c-grid-4');
        });
      });

      listViewBtn.addEventListener('click', () => {
        listViewBtn.setAttribute('aria-pressed', 'true');
        galleryViewBtn.setAttribute('aria-pressed', 'false');
        gridContainers.forEach(g => {
          g.classList.remove('c-grid-4');
          g.classList.add('c-list-view');
        });
      });
    }

    // Surprise Me
    if (surpriseBtn) {
      surpriseBtn.addEventListener('click', () => {
        const visibleCards = cardData.filter(d => d.card.style.display !== 'none');
        if (visibleCards.length > 0) {
          const random = visibleCards[Math.floor(Math.random() * visibleCards.length)];
          random.card.scrollIntoView({ behavior: 'smooth', block: 'center' });
          random.card.style.transition = 'outline 0.3s, transform 0.3s';
          random.card.style.outline = '3px solid var(--accent, #00ff66)';
          random.card.style.transform = 'scale(1.03)';
          setTimeout(() => {
            random.card.style.outline = '';
            random.card.style.transform = '';
          }, 1800);
        }
      });
    }

    // Project Card Click -> Modal Drawer
    const catalog = window.catalogItems || [];
    cards.forEach(card => {
      card.addEventListener('click', () => {
        const title = (card.querySelector('h3') ? card.querySelector('h3').textContent : '').trim();
        const found = catalog.find(item => item.title.toLowerCase() === title.toLowerCase()) || {
          title,
          desc: (card.querySelector('p') ? card.querySelector('p').textContent : '').trim(),
          category: (card.querySelector('.c-eyebrow') ? card.querySelector('.c-eyebrow').textContent : '').trim(),
          discipline: (card.querySelector('.c-tag') ? card.querySelector('.c-tag').textContent : '').trim(),
          img: card.querySelector('img') ? card.querySelector('img').src : ''
        };
        openDetailModal(found);
      });
    });

    function openDetailModal(item) {
      let modal = document.getElementById('projectModal');
      if (!modal) {
        modal = document.createElement('div');
        modal.id = 'projectModal';
        modal.className = 'c-peek-root';
        modal.innerHTML = `
          <div class="c-peek-bg" id="modalBg"></div>
          <div class="c-peek" role="dialog" aria-modal="true">
            <div class="c-peek-bar">
              <span class="c-eyebrow" id="modalCategory" style="color:var(--accent)"></span>
              <button class="c-peek-btn" id="modalCloseBtn" aria-label="Close">✕</button>
            </div>
            <div class="c-peek-body" style="padding:24px;">
              <h2 id="modalTitle" class="c-wordpeek-title" style="margin-bottom:12px"></h2>
              <div id="modalMedia" style="margin:16px 0;border-radius:14px;overflow:hidden;background:#000;max-height:360px;"></div>
              <p id="modalDesc" class="c-lede" style="font-size:16px;line-height:1.6;margin-bottom:20px;color:var(--fg)"></p>
              <div id="modalMeta" style="display:flex;gap:8px;flex-wrap:wrap"></div>
            </div>
          </div>
        `;
        document.body.appendChild(modal);

        modal.querySelector('#modalCloseBtn').addEventListener('click', () => {
          modal.setAttribute('data-open', 'false');
          setTimeout(() => { modal.style.display = 'none'; }, 250);
        });
        modal.querySelector('#modalBg').addEventListener('click', () => {
          modal.setAttribute('data-open', 'false');
          setTimeout(() => { modal.style.display = 'none'; }, 250);
        });
      }

      modal.querySelector('#modalCategory').textContent = item.category || item.discipline || 'PROJECT';
      modal.querySelector('#modalTitle').textContent = item.title;
      modal.querySelector('#modalDesc').textContent = item.longDesc || item.desc || '';

      const media = modal.querySelector('#modalMedia');
      if (item.img) {
        media.innerHTML = `<img src="${item.img}" alt="${item.title}" style="width:100%;height:100%;object-fit:cover;display:block;">`;
        media.style.display = 'block';
      } else {
        media.style.display = 'none';
      }

      const meta = modal.querySelector('#modalMeta');
      meta.innerHTML = '';
      if (item.role) meta.innerHTML += `<span class="c-tag">Role: ${item.role}</span>`;
      if (item.year) meta.innerHTML += `<span class="c-tag">Year: ${item.year}</span>`;
      if (item.discipline) meta.innerHTML += `<span class="c-tag">${item.discipline}</span>`;
      if (item.url || item.liveUrl) {
        meta.innerHTML += `<a href="${item.url || item.liveUrl}" target="_blank" rel="noopener,noreferrer" class="c-btn c-btn-primary" style="margin-top:12px;padding:6px 14px;border-radius:999px;font-size:13px;display:inline-flex;align-items:center;gap:6px">Visit Live Website ↗</a>`;
      }

      modal.style.display = 'grid';
      setTimeout(() => { modal.setAttribute('data-open', 'true'); }, 10);
    }

    // Deep linking support (e.g. /work/pj-5, /work/#pj-5, or ?p=pj-5)
    const pathParts = window.location.pathname.split('/').filter(Boolean);
    const lastPart = pathParts[pathParts.length - 1];
    const hash = window.location.hash ? window.location.hash.replace('#', '') : null;
    const urlParams = new URLSearchParams(window.location.search);
    const queryParam = urlParams.get('p') || urlParams.get('id');
    const slug = queryParam || (hash && hash !== 'main' ? hash : null) || (lastPart && lastPart !== 'work' && !lastPart.endsWith('.html') ? lastPart : null);

    if (slug && Array.isArray(window.catalogItems)) {
      const target = window.catalogItems.find(item => 
        item.id === slug || 
        item.title.toLowerCase().replace(/[^a-z0-9]/g, '-') === slug.toLowerCase()
      );
      if (target) {
        setTimeout(() => openDetailModal(target), 200);
      }
    }

  });
})();

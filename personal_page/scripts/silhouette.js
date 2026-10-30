// Exact typographic silhouette canvas implementation derived from module 59301
function initSilhouette(options = {}) {
  const canvas = document.querySelector('.c-hero-stage canvas');
  const stage = document.querySelector('.c-hero-stage');
  const heroSection = document.querySelector('.c-hero');
  const shade = document.querySelector('.c-hero-shade');
  const heroCopy = document.querySelector('.c-hero-copy');
  const heroSkip = document.querySelector('.c-hero-skip');
  const loadingIndicator = document.getElementById('loadingWords');
  const scrollCue = document.querySelector('.c-scroll-cue');
  const heroP = heroCopy ? heroCopy.querySelector('p') : null;

  if (!canvas || !stage || !heroSection) return;

  const clamp = (val, min = 0, max = 1) => Math.min(max, Math.max(min, val));
  const lerp = (start, end, factor) => start + (end - start) * factor;
  const easeInOutCubic = t => (t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2);

  const fontFam = '"Bricolage Grotesque", "Helvetica Neue", Arial, sans-serif';
  const defaultFocus = options.focus || { x: 0.36, y: 0.15 };
  const markFocus = { x: 0.5, y: 0.5 };
  const brandWords = options.brandWords || [
    "Nana", "Amoako", "Accra", "Build", "Shoot", "Ship", "Code", "Film", "Design",
    "Write", "Lead", "Make", "Edit", "Grade", "DJ", "Chef", "Think", "Brand"
  ];
  const letterSpacing = "-0.54px";

  let prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  let wordMesh = null;
  let maskImg = null;
  let backdropImgs = null;
  let pointerPos = null;
  let scrollProgress = 0;
  let animFrameId = 0;
  let isReady = false;
  let offscreenMaskCanvas = null;

  // LCG pseudo-random generator
  function shuffle(array, seed = 7) {
    let s = seed;
    const rnd = () => {
      s = (16807 * s) % 2147483647;
      return s / 2147483647;
    };
    const copy = [...array];
    for (let i = copy.length - 1; i > 0; i--) {
      const j = Math.floor(rnd() * (i + 1));
      [copy[i], copy[j]] = [copy[j], copy[i]];
    }
    return copy;
  }

  // Pre-sample silhouette words onto mask
  function buildWordMesh(img, wordList, brandList, numRows, { alphaMask = true } = {}) {
    const targetW = 220;
    const targetH = Math.round(targetW * (img.naturalHeight || img.height) / (img.naturalWidth || img.width));
    const aspect = targetH / targetW;

    const sampleCanvas = document.createElement("canvas");
    sampleCanvas.width = targetW;
    sampleCanvas.height = targetH;
    const sCtx = sampleCanvas.getContext("2d", { willReadFrequently: true });
    let imgData;
    try {
      if (sCtx && img) {
        sCtx.drawImage(img, 0, 0, targetW, targetH);
        imgData = sCtx.getImageData(0, 0, targetW, targetH).data;
      } else {
        throw new Error("Context unavailable");
      }
    } catch (e) {
      console.warn("Canvas getImageData tainted (likely file:// protocol). Using procedural silhouette fallback.");
      imgData = new Uint8ClampedArray(targetW * targetH * 4);
      for (let y = 0; y < targetH; y++) {
        for (let x = 0; x < targetW; x++) {
          const idx = (y * targetW + x) * 4;
          const cx = targetW / 2;
          const cy = targetH * 0.45;
          const rx = targetW * 0.35;
          const ry = targetH * 0.4;
          const inside = Math.pow((x - cx) / rx, 2) + Math.pow((y - cy) / ry, 2) <= 1;
          imgData[idx] = inside ? 20 : 250;
          imgData[idx + 1] = inside ? 20 : 250;
          imgData[idx + 2] = inside ? 20 : 250;
          imgData[idx + 3] = inside ? 255 : 0;
        }
      }
    }

    const getPixel = (u, v) => {
      const px = clamp(Math.round(219 * u), 0, 219);
      const py = clamp(Math.round(v * (targetH - 1)), 0, targetH - 1);
      const idx = (targetW * py + px) * 4;
      return [imgData[idx], imgData[idx + 1], imgData[idx + 2], imgData[idx + 3]];
    };

    // Calculate background average color from edges
    let bgR = 0, bgG = 0, bgB = 0, edgeCount = 0;
    for (let y = 0; y < 8; y++) {
      for (const x of [0, 1, 2, 3, 4, 5, 214, 215, 216, 217, 218, 219]) {
        const idx = (targetW * y + x) * 4;
        bgR += imgData[idx];
        bgG += imgData[idx + 1];
        bgB += imgData[idx + 2];
        edgeCount++;
      }
    }
    bgR /= edgeCount;
    bgG /= edgeCount;
    bgB /= edgeCount;

    const isForeground = (u, v) => {
      const [r, g, b, a] = getPixel(u, v);
      if (alphaMask) {
        return a > 110;
      }
      if (a < 40) return false;
      return Math.hypot(r - bgR, g - bgG, b - bgB) > 30;
    };

    const measureCanvas = document.createElement("canvas").getContext("2d");
    measureCanvas.font = `600 12px ${fontFam}`;
    measureCanvas.letterSpacing = letterSpacing;
    const widthCache = new Map();
    const getWordWidth = w => {
      if (!widthCache.has(w)) {
        widthCache.set(w, measureCanvas.measureText(w).width / 12);
      }
      return widthCache.get(w);
    };

    const em = (0.9 * aspect) / numRows;
    const gap = 0.32 * em;
    const shuffledWords = shuffle(wordList, 7);

    let wordIdx = 0;
    let brandIdx = 0;
    const cells = [];

    for (let row = 0; row < numRows; row++) {
      const rowY = (row + 0.5) / numRows;
      let rowX = (row % 2) * em * 0.6;
      let col = 0;

      while (rowX < 1) {
        if (!isForeground(rowX + 0.2 * em, rowY)) {
          rowX += 0.45 * em;
          continue;
        }

        const coverage = wordW => {
          let count = 0;
          for (let step = 0; step <= 5; step++) {
            const testX = rowX + (wordW * step) / 5;
            if (testX <= 1 && isForeground(testX, rowY)) count++;
          }
          return count / 6;
        };

        const isBrandSlot = rowY < 0.3 && brandList.length && col % 7 === 3;
        let chosenWord = null;
        let chosenW = 0;

        if (isBrandSlot) {
          const bw = brandList[brandIdx % brandList.length];
          const testW = getWordWidth(bw) * em;
          if (coverage(testW) >= 0.84) {
            chosenWord = bw;
            chosenW = testW;
            brandIdx++;
          }
        }

        for (let tries = 0; !chosenWord && tries < 18; tries++) {
          const w = shuffledWords[(wordIdx + tries) % shuffledWords.length];
          const testW = getWordWidth(w) * em;
          if (coverage(testW) >= 0.84) {
            chosenWord = w;
            chosenW = testW;
            const curIdx = wordIdx % shuffledWords.length;
            const swapIdx = (wordIdx + tries) % shuffledWords.length;
            [shuffledWords[curIdx], shuffledWords[swapIdx]] = [shuffledWords[swapIdx], shuffledWords[curIdx]];
            wordIdx++;
          }
        }

        if (!chosenWord) {
          rowX += 0.45 * em;
          continue;
        }

        let rSum = 0, gSum = 0, bSum = 0, samplePts = 0;
        for (let s = 0; s <= 4; s++) {
          const testX = rowX + (chosenW * s) / 4;
          if (testX > 1 || !isForeground(testX, rowY)) continue;
          const [pr, pg, pb] = getPixel(testX, rowY);
          rSum += pr;
          gSum += pg;
          bSum += pb;
          samplePts++;
        }
        rSum /= (samplePts || 1);
        gSum /= (samplePts || 1);
        bSum /= (samplePts || 1);

        cells.push({
          x: rowX,
          y: rowY,
          w: chosenW,
          word: chosenWord,
          r: rSum,
          g: gSum,
          b: bSum,
          lum: 0.299 * rSum + 0.587 * gSum + 0.114 * bSum,
          brand: isBrandSlot
        });

        rowX += chosenW + gap;
        col++;
      }
    }

    return { cells, aspect, rows: numRows, em };
  }

  // Calculate layout bounds
  function getBounds(w, h, aspect) {
    const isMobile = w < 720;
    let targetH = h * (isMobile ? 0.74 : 0.86);
    let targetW = targetH / aspect;
    const maxW = w * (isMobile ? 0.96 : 0.6);
    if (targetW > maxW) {
      targetW = maxW;
      targetH = targetW * aspect;
    }
    return {
      x: isMobile ? (w - targetW) / 2 : 0.62 * w - targetW / 2,
      y: h - targetH - (isMobile ? 0.16 * h : 0.04 * h),
      w: targetW,
      h: targetH
    };
  }

  // Draw frame
  function render() {
    if (!canvas || !wordMesh) return;
    const ctx = canvas.getContext("2d");
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    const clientW = canvas.clientWidth;
    const clientH = canvas.clientHeight;

    const targetPixW = Math.round(clientW * dpr);
    const targetPixH = Math.round(clientH * dpr);
    if (canvas.width !== targetPixW || canvas.height !== targetPixH) {
      canvas.width = targetPixW;
      canvas.height = targetPixH;
    }

    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    ctx.clearRect(0, 0, clientW, clientH);

    const f = scrollProgress;
    const bounds = getBounds(clientW, clientH, wordMesh.aspect);
    const easedZoom = easeInOutCubic(clamp(f / 0.78));
    const scale = lerp(7, 1, easedZoom);

    const focusPoint = defaultFocus;
    const focusX = bounds.x + focusPoint.x * bounds.w;
    const focusY = bounds.y + focusPoint.y * bounds.h;
    const offsetX = lerp(clientW / 2, focusX, easedZoom);
    const offsetY = lerp(0.42 * clientH, focusY, easedZoom);

    const rowH = (bounds.h / wordMesh.rows) * 0.9 * scale;
    if (rowH < 2.2) return;

    const isDarkMode = document.querySelector('.corner')?.getAttribute('data-theme') === 'dark';
    const illumination = clamp((f - 0.06) / 0.74);
    const pointerRadius = Math.max(110, 0.16 * Math.min(clientW, clientH));
    const fontScale = rowH / 12;

    const visibleCells = [];
    for (const cell of wordMesh.cells) {
      const renderX = offsetX + (bounds.x + cell.x * bounds.w - focusX) * scale;
      const renderY = offsetY + (bounds.y + cell.y * bounds.h - focusY) * scale;
      const renderW = cell.w * bounds.w * scale;

      if (renderY < -rowH || renderY > clientH + rowH || renderX > clientW || renderX + renderW < 0) {
        continue;
      }

      let lightLevel = clamp(1.6 * illumination - 0.6 * cell.y);
      if (pointerPos) {
        const dist = Math.hypot(renderX + renderW / 2 - pointerPos.x, renderY - pointerPos.y);
        lightLevel = Math.max(lightLevel, 0.95 * clamp(1 - dist / pointerRadius));
      }

      visibleCells.push([cell, renderX, renderY, lightLevel]);
    }

    const drawWords = (targetCtx, colorFn) => {
      targetCtx.setTransform(dpr * fontScale, 0, 0, dpr * fontScale, 0, 0);
      targetCtx.font = `600 12px ${fontFam}`;
      targetCtx.letterSpacing = letterSpacing;
      targetCtx.textBaseline = "middle";

      for (const [cell, rx, ry, lit] of visibleCells) {
        const fill = colorFn(cell, lit);
        if (fill) {
          targetCtx.fillStyle = fill;
          targetCtx.fillText(cell.word, rx / fontScale, ry / fontScale);
        }
      }
    };

    // Draw background unlit words
    drawWords(ctx, (cell, lit) => {
      if (lit >= 1) return null;
      const lumVal = Math.round(isDarkMode ? 70 + 0.22 * cell.lum : 168 - (128 - cell.lum) * 0.18);
      return `rgba(${lumVal},${lumVal},${lumVal},${1 - lit})`;
    });

    // Draw illuminated words filled with photographic mask
    if (visibleCells.some(item => item[3] > 0) && maskImg) {
      if (!offscreenMaskCanvas) {
        offscreenMaskCanvas = document.createElement("canvas");
      }
      if (offscreenMaskCanvas.width !== canvas.width || offscreenMaskCanvas.height !== canvas.height) {
        offscreenMaskCanvas.width = canvas.width;
        offscreenMaskCanvas.height = canvas.height;
      }

      const oCtx = offscreenMaskCanvas.getContext("2d");
      oCtx.setTransform(1, 0, 0, 1, 0, 0);
      oCtx.globalCompositeOperation = "source-over";
      oCtx.clearRect(0, 0, offscreenMaskCanvas.width, offscreenMaskCanvas.height);

      drawWords(oCtx, (cell, lit) => (lit > 0 ? `rgba(0,0,0,${lit})` : null));

      oCtx.setTransform(dpr, 0, 0, dpr, 0, 0);
      oCtx.globalCompositeOperation = "source-in";
      oCtx.filter = isDarkMode ? "brightness(1.45) contrast(1.75)" : "brightness(0.9) contrast(1.6)";
      oCtx.drawImage(
        maskImg,
        offsetX + (bounds.x - focusX) * scale,
        offsetY + (bounds.y - focusY) * scale,
        bounds.w * scale,
        bounds.h * scale
      );
      oCtx.filter = "none";

      ctx.setTransform(1, 0, 0, 1, 0, 0);
      ctx.drawImage(offscreenMaskCanvas, 0, 0);
    }

    // Photo reveal crossfade at end of scroll
    const photoRevealProgress = clamp((f - 0.8) / 0.17);
    if (backdropImgs && photoRevealProgress > 0) {
      const { crop } = options.backdrop;
      const cropScale = (bounds.w * scale) / crop.w;
      const fullW = crop.W * cropScale;
      const fullH = crop.H * cropScale;
      const drawX = offsetX + (bounds.x - focusX) * scale - crop.x * cropScale;
      const drawY = offsetY + (bounds.y - focusY) * scale - crop.y * cropScale;

      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      ctx.globalAlpha = easeInOutCubic(photoRevealProgress);

      if (backdropImgs.ext) {
        ctx.drawImage(backdropImgs.ext, drawX - 2 * fullW, drawY - fullH, 5 * fullW, 3 * fullH);
      }
      if (backdropImgs.full) {
        ctx.drawImage(backdropImgs.full, drawX, drawY, fullW, fullH);
      }
      ctx.globalAlpha = 1;
    }

    // Dynamic UI styling sync
    if (shade) {
      shade.style.opacity = easeInOutCubic(clamp((f - 0.8) / 0.17));
    }

    if (heroCopy) {
      const copyScale = lerp(1, 0.42, easeInOutCubic(clamp(f / 0.32)));
      heroCopy.style.transform = `scale(${copyScale})`;
      if (photoRevealProgress > 0.5) {
        heroCopy.setAttribute("data-on-photo", "");
      } else {
        heroCopy.removeAttribute("data-on-photo");
      }
    }

    const fadeOut = 1 - clamp(f / 0.18);
    if (heroP) heroP.style.opacity = fadeOut;
    if (scrollCue) scrollCue.style.opacity = fadeOut;

    if (heroSkip) {
      heroSkip.style.display = f < 0.95 && !prefersReducedMotion ? "block" : "none";
    }
  }

  function requestRender() {
    cancelAnimationFrame(animFrameId);
    animFrameId = requestAnimationFrame(render);
  }

  // Pointer interaction
  stage.addEventListener("pointermove", e => {
    const rect = stage.getBoundingClientRect();
    pointerPos = { x: e.clientX - rect.left, y: e.clientY - rect.top };
    requestRender();
  });

  stage.addEventListener("pointerleave", () => {
    pointerPos = null;
    requestRender();
  });

  // Scroll listener
  function updateScroll() {
    if (!heroSection) return;
    if (prefersReducedMotion) {
      scrollProgress = 1;
    } else {
      const rect = heroSection.getBoundingClientRect();
      const totalDist = rect.height - window.innerHeight;
      scrollProgress = totalDist > 0 ? clamp(-rect.top / totalDist) : 1;
    }
    requestRender();
  }

  window.addEventListener("scroll", updateScroll, { passive: true });

  // Resize listener
  function handleResize() {
    if (!maskImg) return;
    const isMobile = window.innerWidth < 720;
    const targetRows = isMobile ? 64 : 120;
    if (!wordMesh || wordMesh.rows !== targetRows) {
      wordMesh = buildWordMesh(maskImg, options.words || [], brandWords, targetRows, { alphaMask: options.cutout !== false });
    }
    updateScroll();
  }

  window.addEventListener("resize", handleResize);

  // Load assets with path-agnostic URLs
  const cleanUrl = url => (url && url.startsWith('/') ? url.slice(1) : url);
  const mask = new Image();
  mask.decoding = "async";
  mask.src = cleanUrl(options.src) || "images/portrait/glen-cutout.webp";

  if (options.backdrop) {
    const full = new Image();
    const ext = new Image();
    full.src = cleanUrl(options.backdrop.full);
    ext.src = cleanUrl(options.backdrop.ext);
    Promise.all([full.decode(), ext.decode()])
      .then(() => {
        backdropImgs = { full, ext };
        requestRender();
      })
      .catch(() => {});
  }

  const fontReady = document.fonts
    ? document.fonts.ready.then(() => document.fonts.load(`600 40px ${fontFam}`))
    : Promise.resolve();

  Promise.all([
    mask.decode().catch(() => new Promise(res => (mask.onload = res))),
    fontReady
  ]).then(() => {
    maskImg = mask;
    const isMobile = window.innerWidth < 720;
    const targetRows = isMobile ? 64 : 120;
    wordMesh = buildWordMesh(maskImg, options.words || [], brandWords, targetRows, { alphaMask: options.cutout !== false });
    isReady = true;
    if (loadingIndicator) loadingIndicator.style.display = "none";
    updateScroll();
  });

  if (document.fonts) {
    document.fonts.addEventListener("loadingdone", handleResize);
  }

  // Skip button click
  if (heroSkip) {
    heroSkip.addEventListener("click", () => {
      const afterEl = document.getElementById(options.afterId || "after-hero");
      if (afterEl) {
        afterEl.scrollIntoView({ behavior: prefersReducedMotion ? "auto" : "smooth" });
      }
    });
  }

  return { requestRender, updateScroll };
}

if (typeof window !== 'undefined') {
  window.initSilhouette = initSilhouette;
}

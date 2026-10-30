/* =========================================================
   Interaksi personal page
   1. Kartu ID di tali lanyard: bisa diseret, lalu berayun kembali
   2. Menu layar penuh
   3. Validasi form kontak sebelum dikirim
   4. Salin email ke clipboard
   ========================================================= */
(function () {
    'use strict';

    var root = document.documentElement;
    var $ = function (sel, ctx) { return (ctx || document).querySelector(sel); };
    var $$ = function (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); };
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- 1. Kartu ID di lanyard ---------- */
    var stage = $('#stage');
    var strap = $('#strap');
    var hanger = $('#hanger');

    var L = 210, CW = 300;                   // dibaca ulang dari CSS
    var x = 0, y = 0, vx = 0, vy = 0, rot = 0;
    var grabbed = false, grabDX = 0, grabDY = 0, lastMove = 0;
    var running = false, lastT = 0;

    var GRAVITY = 2600;                       // px/detik²
    var STIFF = 900;                          // kekakuan tali saat tertarik
    var DAMP = 1.6;                           // redaman udara

    function readSize() {
        var cs = getComputedStyle(root);
        L = parseFloat(cs.getPropertyValue('--L')) || 210;
        CW = hanger.offsetWidth || 300;
    }

    function render() {
        var d = Math.hypot(x, y) || 1;
        var a = Math.atan2(x, y);              // 0 = tegak lurus ke bawah
        var tilt = Math.max(-18, Math.min(18, vx * 0.018));
        var target = -a * 180 / Math.PI + tilt;
        rot += (target - rot) * 0.25;
        strap.style.height = d + 'px';
        strap.style.transform = 'rotate(' + (-a) + 'rad)';
        hanger.style.transform = 'translate(' + (x - CW / 2).toFixed(1) + 'px,' + y.toFixed(1) + 'px) rotate(' + rot.toFixed(2) + 'deg)';
    }

    function step(dt) {
        if (grabbed) return;
        var ax = 0, ay = GRAVITY;
        var d = Math.hypot(x, y) || 1;
        if (d > L) {                           // tali menegang: tarik kembali ke panjang L
            var nx = x / d, ny = y / d;
            var stretch = d - L;
            ax -= STIFF * stretch * nx;
            ay -= STIFF * stretch * ny;
            var radial = vx * nx + vy * ny;    // redam gerak searah tali agar tidak memantul berlebihan
            ax -= radial * 14 * nx;
            ay -= radial * 14 * ny;
        }
        vx += ax * dt; vy += ay * dt;
        var f = Math.exp(-DAMP * dt);
        vx *= f; vy *= f;
        x += vx * dt; y += vy * dt;
    }

    function atRest() {
        return !grabbed && Math.abs(vx) < 4 && Math.abs(vy) < 4 &&
               Math.abs(x) < 0.6 && Math.abs(Math.hypot(x, y) - L) < 1.5;
    }

    function loop(t) {
        var dt = Math.min(0.032, (t - lastT) / 1000 || 0.016);
        lastT = t;
        // beberapa sub-langkah agar fisika stabil
        for (var i = 0; i < 4; i++) step(dt / 4);
        render();
        if (atRest()) { running = false; return; }
        requestAnimationFrame(loop);
    }
    function wake() {
        if (running) return;
        running = true;
        lastT = performance.now();
        requestAnimationFrame(loop);
    }

    function stagePoint(ev) {
        var r = stage.getBoundingClientRect();
        return { x: ev.clientX - r.left, y: ev.clientY - r.top };
    }

    hanger.addEventListener('pointerdown', function (ev) {
        if (ev.button !== 0) return;
        ev.preventDefault();
        var p = stagePoint(ev);
        grabbed = true;
        grabDX = p.x - x; grabDY = p.y - y;
        vx = vy = 0;
        lastMove = performance.now();
        hanger.setPointerCapture(ev.pointerId);
        hanger.classList.add('is-grabbed');
        wake();
    });
    hanger.addEventListener('pointermove', function (ev) {
        if (!grabbed) return;
        var p = stagePoint(ev);
        var nx = p.x - grabDX, ny = p.y - grabDY;
        var d = Math.hypot(nx, ny);
        var max = L * 1.12;                    // tali sedikit melar saat ditarik
        if (d > max) { nx = nx / d * max; ny = ny / d * max; }
        if (ny < -L * 0.3) ny = -L * 0.3;       // jangan sampai keluar layar atas
        var now = performance.now();
        var dt = Math.max(0.008, (now - lastMove) / 1000);
        vx = vx * 0.5 + ((nx - x) / dt) * 0.5;
        vy = vy * 0.5 + ((ny - y) / dt) * 0.5;
        x = nx; y = ny; lastMove = now;
    });
    function release(ev) {
        if (!grabbed) return;
        grabbed = false;
        hanger.classList.remove('is-grabbed');
        if (performance.now() - lastMove > 80) { vx = 0; vy = 0; }   // dilepas tanpa ayunan
        var cap = Math.max(-3000, Math.min(3000, vx)); vx = cap;
        vy = Math.max(-3000, Math.min(3000, vy));
        try { hanger.releasePointerCapture(ev.pointerId); } catch (err) {}
        wake();
    }
    hanger.addEventListener('pointerup', release);
    hanger.addEventListener('pointercancel', release);

    window.addEventListener('resize', function () {
        readSize();
        wake();
    });

    readSize();
    if (reduceMotion) {
        x = 0; y = L;
    } else {
        x = -L * 0.5; y = L * 0.86;           // ayunan pembuka saat halaman dibuka
    }
    render();
    wake();

    /* ---------- 2. Menu layar penuh ---------- */
    var menu = $('#menu');
    var menuBtn = $('#menu-btn');
    var closeTimer = null;

    function openMenu() {
        clearTimeout(closeTimer);
        menu.hidden = false;
        requestAnimationFrame(function () { menu.classList.add('is-open'); });
        menuBtn.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
        var first = $('.menu-links a', menu);
        if (first) setTimeout(function () { first.focus(); }, 300);
    }
    function closeMenu(focusBtn) {
        menu.classList.remove('is-open');
        menuBtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        closeTimer = setTimeout(function () { menu.hidden = true; }, reduceMotion ? 0 : 550);
        if (focusBtn) menuBtn.focus();
    }
    menuBtn.addEventListener('click', function () {
        if (menuBtn.getAttribute('aria-expanded') === 'true') closeMenu(false);
        else openMenu();
    });
    $$('a', menu).forEach(function (a) { a.addEventListener('click', function () { closeMenu(false); }); });
    document.addEventListener('keydown', function (ev) {
        if (ev.key === 'Escape' && menuBtn.getAttribute('aria-expanded') === 'true') closeMenu(true);
    });

    /* ---------- 3. Validasi form kontak ---------- */
    var form = $('#contact-form');
    var pesan = $('#f-pesan');
    var counter = $('#count');
    var status = $('#form-status');
    var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    pesan.addEventListener('input', function () { counter.textContent = pesan.value.length; });

    function setError(name, msg) {
        var input = $('#f-' + name);
        input.closest('.field').classList.toggle('invalid', !!msg);
        input.setAttribute('aria-invalid', msg ? 'true' : 'false');
        $('#e-' + name).textContent = msg || '';
    }
    function validate() {
        var nama = $('#f-nama').value.trim();
        var email = $('#f-email').value.trim();
        var isi = pesan.value.trim();
        var ok = true;
        if (nama.length < 2) { setError('nama', 'Please enter at least 2 characters.'); ok = false; } else setError('nama', '');
        if (!emailRe.test(email)) { setError('email', 'Please enter a valid email, e.g. name@email.com.'); ok = false; } else setError('email', '');
        if (isi.length < 10) { setError('pesan', 'Your message needs at least 10 characters.'); ok = false; } else setError('pesan', '');
        return ok ? { nama: nama, email: email, isi: isi } : null;
    }
    ['nama', 'email', 'pesan'].forEach(function (n) {
        $('#f-' + n).addEventListener('blur', function () { if (form.dataset.tried) validate(); });
    });
    form.addEventListener('submit', function (ev) {
        ev.preventDefault();
        form.dataset.tried = '1';
        status.textContent = '';
        var data = validate();
        if (!data) {
            var firstBad = $('.field.invalid input, .field.invalid textarea', form);
            if (firstBad) firstBad.focus();
            return;
        }
        var subject = encodeURIComponent('Message from ' + data.nama);
        var body = encodeURIComponent(data.isi + '\n\n— ' + data.nama + ' (' + data.email + ')');
        window.location.href = 'mailto:' + form.dataset.email + '?subject=' + subject + '&body=' + body;
        status.textContent = 'Looks good. Your email app will open so you can send it.';
        form.reset();
        counter.textContent = '0';
        delete form.dataset.tried;
    });

    /* ---------- 4. Salin email ---------- */
    var toast = $('#toast');
    var toastTimer = null;
    function showToast(msg) {
        toast.textContent = msg;
        toast.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { toast.classList.remove('show'); }, 2000);
    }
    $('#copy-mail').addEventListener('click', function () {
        var text = this.dataset.copy;
        var done = function () { showToast('Email copied: ' + text); };
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(done, function () { fallbackCopy(text); done(); });
        } else {
            fallbackCopy(text); done();
        }
    });
    function fallbackCopy(text) {
        var ta = document.createElement('textarea');
        ta.value = text; ta.setAttribute('readonly', '');
        ta.style.position = 'absolute'; ta.style.left = '-9999px';
        document.body.appendChild(ta); ta.select();
        try { document.execCommand('copy'); } catch (err) {}
        document.body.removeChild(ta);
    }
})();

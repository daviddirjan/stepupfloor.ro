<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>StepUp Floor — Montaj Mochete &amp; Covoare, Timișoara</title>
  <meta name="description" content="Montaj profesional de mochete și covoare PVC în Timișoara și vestul României. Calitate, precizie și respect față de spațiul tău.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Lora:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>

<!-- ═══════════ TOP BAR ═══════════ -->
<div class="topbar">
  <div class="topbar-inner">
    <span>Timișoara · Vestul României</span>
    <span class="topbar-sep">·</span>
    <a href="tel:+40745990503" class="topbar-link">0745 990 503</a>
    <span class="topbar-sep">·</span>
    <a href="mailto:office@stepupsolutions.ro" class="topbar-link topbar-link--em">office@stepupsolutions.ro</a>
  </div>
</div>

<!-- ═══════════ SITE HEADER ═══════════ -->
<header class="site-header" id="site-header">
  <div class="header-inner">

    <!-- LOGO (actual image, nu se schimbă) -->
    <a href="<?= BASE_URL ?>" class="nav-logo" style="margin-right:3.25rem;flex-shrink:0;">
      <img src="<?= BASE_URL ?>assets/logo/stepupfloor-logo.png" alt="StepUp Floor" style="height:52px;width:auto;">
    </a>

    <!-- DESKTOP NAV -->
    <nav class="hdr-nav">
      <a href="<?= BASE_URL ?>despre-noi" class="hdr-link">Despre noi</a>

      <div class="hdr-item" id="hdr-servicii" data-mega="servicii">
        <button class="hdr-link hdr-link--sub" aria-expanded="false" aria-controls="mega-servicii">
          Servicii
          <svg class="hdr-chevron" viewBox="0 0 12 12" fill="none" width="12" height="12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </button>
        <div class="hdr-mega" id="mega-servicii">
          <div class="hdr-mega-inner">
            <div class="mega-intro">
              <p class="mega-label">Servicii</p>
              <p class="mega-title">Montaj &amp; întreținere profesională</p>
              <p class="mega-desc">Echipă specializată, termene respectate, garanție inclusă pentru orice proiect.</p>
              <a href="<?= BASE_URL ?>#servicii" class="mega-all-link">
                Toate serviciile
                <svg viewBox="0 0 14 14" fill="none" width="14" height="14"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </a>
            </div>
            <div class="mega-cards mega-cards--2">
              <a href="<?= BASE_URL ?>#montaj" class="mega-card">
                <div class="mega-card-img mega-card-img--light">
                  <div class="mega-card-img-label">fotografie montaj</div>
                  <span class="mega-card-badge">Serviciu</span>
                </div>
                <div class="mega-card-body">
                  <p class="mega-card-title">Montaj</p>
                  <p class="mega-card-desc">Instalare rapidă și precisă în 24–48 ore, fără surprize.</p>
                </div>
              </a>
              <a href="<?= BASE_URL ?>#intretinere" class="mega-card">
                <div class="mega-card-img mega-card-img--light2">
                  <div class="mega-card-img-label">fotografie întreținere</div>
                  <span class="mega-card-badge">Serviciu</span>
                </div>
                <div class="mega-card-body">
                  <p class="mega-card-title">Întreținere</p>
                  <p class="mega-card-desc">Curățenie profesională și recondiționare periodică.</p>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>

      <a href="<?= BASE_URL ?>proiecte" class="hdr-link">Proiecte</a>

      <div class="hdr-item" id="hdr-produse" data-mega="produse">
        <button class="hdr-link hdr-link--sub" aria-expanded="false" aria-controls="mega-produse">
          Produse
          <svg class="hdr-chevron" viewBox="0 0 12 12" fill="none" width="12" height="12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </button>
        <div class="hdr-mega" id="mega-produse">
          <div class="hdr-mega-inner">
            <div class="mega-intro">
              <p class="mega-label">Produse</p>
              <p class="mega-title">Gamă completă de materiale de calitate</p>
              <p class="mega-desc">Soluții pentru orice spațiu — rezidențial sau comercial.</p>
              <a href="<?= BASE_URL ?>magazin" class="mega-all-link">
                Toate produsele
                <svg viewBox="0 0 14 14" fill="none" width="14" height="14"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </a>
            </div>
            <div class="mega-cards mega-cards--4">
              <a href="<?= BASE_URL ?>categorie/mochete" class="mega-card mega-card--dark">
                <div class="mega-card-img mega-card-img--dark1">
                  <div class="mega-card-img-label mega-card-img-label--dark">fotografie mochete</div>
                  <span class="mega-card-badge mega-card-badge--top">Popular</span>
                </div>
                <div class="mega-card-body">
                  <p class="mega-card-title mega-card-title--light">Mochete</p>
                  <p class="mega-card-desc mega-card-desc--light">Mochete de birou și rezidențiale</p>
                </div>
              </a>
              <a href="<?= BASE_URL ?>categorie/lvt" class="mega-card mega-card--dark">
                <div class="mega-card-img mega-card-img--dark2">
                  <div class="mega-card-img-label mega-card-img-label--dark">fotografie LVT</div>
                </div>
                <div class="mega-card-body">
                  <p class="mega-card-title mega-card-title--light">LVT</p>
                  <p class="mega-card-desc mega-card-desc--light">Luxury vinyl tile durabil</p>
                </div>
              </a>
              <a href="<?= BASE_URL ?>categorie/covoare-pvc" class="mega-card mega-card--dark">
                <div class="mega-card-img mega-card-img--dark3">
                  <div class="mega-card-img-label mega-card-img-label--dark">fotografie covoare PVC</div>
                </div>
                <div class="mega-card-body">
                  <p class="mega-card-title mega-card-title--light">Covoare PVC</p>
                  <p class="mega-card-desc mega-card-desc--light">Soluție practică și estetică</p>
                </div>
              </a>
              <a href="<?= BASE_URL ?>categorie/dale-modulare" class="mega-card mega-card--dark">
                <div class="mega-card-img mega-card-img--dark4">
                  <div class="mega-card-img-label mega-card-img-label--dark">fotografie dale</div>
                </div>
                <div class="mega-card-body">
                  <p class="mega-card-title mega-card-title--light">Dale Modulare</p>
                  <p class="mega-card-desc mega-card-desc--light">Flexibilitate totală de design</p>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- RIGHT ACTIONS -->
    <div class="hdr-actions">
      <div class="hdr-search-group">
        <input type="text" id="search-input" class="hdr-search-input" placeholder="Caută produse...">
        <button class="hdr-icon-btn" id="search-btn" aria-label="Căutare">
          <svg viewBox="0 0 18 18" fill="none" width="18" height="18"><circle cx="7.5" cy="7.5" r="5" stroke="currentColor" stroke-width="1.6"/><path d="M11.5 11.5l3.5 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
        </button>
      </div>

      <a href="<?= BASE_URL ?>cos" class="hdr-icon-btn hdr-cart-btn" aria-label="Coș">
        <svg viewBox="0 0 18 18" fill="none" width="18" height="18"><path d="M1 1h2.5l1.6 8h8.3l1.6-5.5H4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="7.5" cy="15.5" r="1.25" fill="currentColor"/><circle cx="12.5" cy="15.5" r="1.25" fill="currentColor"/></svg>
        <span class="hdr-cart-badge"><?= CartHelper::count() ?: '' ?></span>
      </a>

      <div class="hdr-divider"></div>

      <a href="<?= BASE_URL ?>#contact" class="hdr-cta">
        Solicită ofertă
        <svg viewBox="0 0 13 13" fill="none" width="13" height="13"><path d="M1 6.5h11M7 2l5 4.5L7 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>

    <!-- MOBILE TOGGLE -->
    <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Meniu">
      <span></span><span></span><span></span>
    </button>
  </div>

  <!-- MOBILE MENU -->
  <div class="mobile-menu" id="mobile-menu">
    <a href="<?= BASE_URL ?>despre-noi" class="nav-link">Despre Noi</a>

    <div class="mobile-item">
      <button class="nav-link mobile-toggle-sub" onclick="toggleMobileSub(this)" aria-expanded="false">
        Servicii
        <svg class="chevron" viewBox="0 0 10 6" fill="none" width="10" height="6"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <div class="mobile-sub">
        <a href="<?= BASE_URL ?>#montaj"      class="mobile-sub-link" onclick="closeMobileMenu()">Montaj</a>
        <a href="<?= BASE_URL ?>#intretinere" class="mobile-sub-link" onclick="closeMobileMenu()">Întreținere</a>
      </div>
    </div>

    <a href="<?= BASE_URL ?>proiecte" class="nav-link" onclick="closeMobileMenu()">Proiecte</a>

    <div class="mobile-item">
      <button class="nav-link mobile-toggle-sub" onclick="toggleMobileSub(this)" aria-expanded="false">
        Produse
        <svg class="chevron" viewBox="0 0 10 6" fill="none" width="10" height="6"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <div class="mobile-sub">
        <a href="<?= BASE_URL ?>magazin"                   class="mobile-sub-link" onclick="closeMobileMenu()">Toate produsele</a>
        <a href="<?= BASE_URL ?>categorie/mochete"         class="mobile-sub-link" onclick="closeMobileMenu()">Mochete</a>
        <a href="<?= BASE_URL ?>categorie/lvt"             class="mobile-sub-link" onclick="closeMobileMenu()">LVT</a>
        <a href="<?= BASE_URL ?>categorie/covoare-pvc"     class="mobile-sub-link" onclick="closeMobileMenu()">Covoare PVC</a>
        <a href="<?= BASE_URL ?>categorie/dale-modulare"   class="mobile-sub-link" onclick="closeMobileMenu()">Dale Modulare</a>
      </div>
    </div>

    <a href="<?= BASE_URL ?>#contact" class="btn-primary" style="justify-content:center;" onclick="closeMobileMenu()">Solicită ofertă</a>
  </div>
</header>

<?php require $content; ?>

<!-- ═══════════ FOOTER ═══════════ -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <img src="<?= BASE_URL ?>assets/logo/stepupfloor-logo.png" alt="StepUp Floor"
             style="height:36px;width:auto;margin-bottom:1.5rem;filter:invert(1);">
        <p class="footer-tagline">Montaj profesional de mochete și covoare PVC în Timișoara și vestul României. Calitate, precizie și respect față de spațiul tău.</p>
        <div class="footer-contacts">
          <a href="tel:+40745990503" class="footer-contact-link">0745 990 503</a>
          <a href="tel:+40745456008" class="footer-contact-link">0745 456 008</a>
          <a href="mailto:office@stepupsolutions.ro" class="footer-contact-link">office@stepupsolutions.ro</a>
          <span class="footer-address">Strada Aristide Demetriade 9, 300072 Timișoara</span>
        </div>
        <div class="footer-social">
          <a href="#" class="social-link" aria-label="Facebook">
            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </a>
          <a href="#" class="social-link" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>
          <a href="#" class="social-link" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
          </a>
        </div>
      </div>

      <div class="footer-links-grid">
        <div>
          <p class="footer-col-title">Pagini</p>
          <ul>
            <li><a href="<?= BASE_URL ?>#acasa"    class="footer-link">Acasă</a></li>
            <li><a href="<?= BASE_URL ?>despre-noi" class="footer-link">Despre noi</a></li>
            <li><a href="<?= BASE_URL ?>#servicii"   class="footer-link">Servicii</a></li>
            <li><a href="<?= BASE_URL ?>proiecte"   class="footer-link">Proiecte</a></li>
            <li><a href="<?= BASE_URL ?>#produse"   class="footer-link">Produse</a></li>
            <li><a href="<?= BASE_URL ?>#contact"   class="footer-link">Contact</a></li>
          </ul>
        </div>
        <div>
          <p class="footer-col-title">Servicii</p>
          <ul>
            <li><a href="<?= BASE_URL ?>#servicii" class="footer-link">Montaj mochete</a></li>
            <li><a href="<?= BASE_URL ?>#servicii" class="footer-link">Covoare PVC</a></li>
            <li><a href="<?= BASE_URL ?>#servicii" class="footer-link">Consultanță</a></li>
            <li><a href="<?= BASE_URL ?>#contact"  class="footer-link">Ofertă gratuită</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p class="footer-copy">&copy; <?= date('Y') ?> Montaj Mochete &amp; Covoare. Toate drepturile rezervate.</p>
      <div class="footer-legal">
        <a href="<?= BASE_URL ?>politica-de-confidentialitate">Politica de confidențialitate</a>
        <a href="<?= BASE_URL ?>termeni-si-conditii">Termeni și condiții</a>
        <a href="<?= BASE_URL ?>cookies">Cookies</a>
      </div>
    </div>
  </div>
</footer>

<script>
  /* ── Desktop mega-menu ── */
  (function () {
    var header = document.getElementById('site-header');
    var items  = document.querySelectorAll('.hdr-item[data-mega]');
    var timers = {};

    function getMegaTop() {
      return header ? header.getBoundingClientRect().bottom : 72;
    }

    function openMega(key) {
      clearTimeout(timers[key]);
      items.forEach(function (el) {
        if (el.dataset.mega !== key) closeMegaNow(el.dataset.mega);
      });
      var item = document.getElementById('hdr-' + key);
      var mega = document.getElementById('mega-' + key);
      if (item) {
        item.classList.add('is-open');
        var btn = item.querySelector('.hdr-link--sub');
        if (btn) btn.setAttribute('aria-expanded', 'true');
      }
      if (mega) mega.style.top = getMegaTop() + 'px';
    }

    function scheduleClose(key, delay) {
      clearTimeout(timers[key]);
      timers[key] = setTimeout(function () { closeMegaNow(key); }, delay || 120);
    }

    function closeMegaNow(key) {
      var item = document.getElementById('hdr-' + key);
      if (item) {
        item.classList.remove('is-open');
        var btn = item.querySelector('.hdr-link--sub');
        if (btn) btn.setAttribute('aria-expanded', 'false');
      }
    }

    items.forEach(function (item) {
      var key = item.dataset.mega;
      var mega = document.getElementById('mega-' + key);
      item.addEventListener('mouseenter', function () { openMega(key); });
      item.addEventListener('mouseleave', function () { scheduleClose(key, 120); });
      if (mega) {
        mega.addEventListener('mouseenter', function () { clearTimeout(timers[key]); });
        mega.addEventListener('mouseleave', function () { scheduleClose(key, 120); });
      }
    });

    document.addEventListener('click', function (e) {
      items.forEach(function (item) {
        if (!item.contains(e.target)) closeMegaNow(item.dataset.mega);
      });
    });
  })();

  /* ── Search toggle ── */
  (function () {
    var btn   = document.getElementById('search-btn');
    var input = document.getElementById('search-input');
    if (!btn || !input) return;
    btn.addEventListener('click', function () {
      input.classList.toggle('is-open');
      if (input.classList.contains('is-open')) input.focus();
    });
    input.addEventListener('blur', function () {
      if (!input.value) input.classList.remove('is-open');
    });
  })();

  /* ── Mobile menu ── */
  function toggleMobileMenu() {
    document.getElementById('mobile-menu').classList.toggle('open');
  }
  function closeMobileMenu() {
    document.getElementById('mobile-menu').classList.remove('open');
    document.querySelectorAll('.mobile-sub').forEach(function(el){ el.classList.remove('open'); });
    document.querySelectorAll('.mobile-toggle-sub').forEach(function(el){ el.setAttribute('aria-expanded','false'); });
  }
  function toggleMobileSub(btn) {
    var sub = btn.nextElementSibling;
    var isOpen = sub.classList.contains('open');
    document.querySelectorAll('.mobile-sub').forEach(function(el){ el.classList.remove('open'); });
    document.querySelectorAll('.mobile-toggle-sub').forEach(function(el){ el.setAttribute('aria-expanded','false'); });
    if (!isOpen) { sub.classList.add('open'); btn.setAttribute('aria-expanded','true'); }
  }
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>StepUp Floor — Montaj Mochete &amp; Covoare, Timișoara</title>
  <meta name="description" content="Montaj profesional de mochete și covoare PVC în Timișoara și vestul României. Calitate, precizie și respect față de spațiul tău.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Lora:ital,wght@0,400;0,600;0,700;1,400&display=swap">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>

<!-- ═══════════ NAVBAR ═══════════ -->
<nav class="navbar">
  <div class="container nav-inner">
    <a href="<?= BASE_URL ?>" class="nav-logo">
      <img src="<?= BASE_URL ?>assets/logo/stepupfloor-logo.png" alt="StepUp Floor" style="height:38px;width:auto;">
    </a>

    <div class="desktop-nav">
      <a href="<?= BASE_URL ?>despre-noi" class="nav-link">Despre Noi</a>
      <a href="<?= BASE_URL ?>#servicii"  class="nav-link">Servicii</a>
      <a href="<?= BASE_URL ?>#produse"   class="nav-link">Produse</a>
      <a href="<?= BASE_URL ?>#contact"   class="nav-link">Contact</a>
    </div>

    <div class="desktop-actions">
      <a href="<?= BASE_URL ?>#contact" class="btn-primary btn-sm">Solicită ofertă</a>
    </div>

    <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Meniu">
      <span></span><span></span><span></span>
    </button>
  </div>

  <div class="mobile-menu" id="mobile-menu">
    <a href="<?= BASE_URL ?>despre-noi" class="nav-link">Despre Noi</a>
    <a href="<?= BASE_URL ?>#servicii"  class="nav-link" onclick="closeMobileMenu()">Servicii</a>
    <a href="<?= BASE_URL ?>#produse"   class="nav-link" onclick="closeMobileMenu()">Produse</a>
    <a href="<?= BASE_URL ?>#contact"   class="nav-link" onclick="closeMobileMenu()">Contact</a>
    <a href="<?= BASE_URL ?>#contact"   class="btn-primary" style="justify-content:center;" onclick="closeMobileMenu()">Solicită ofertă</a>
  </div>
</nav>

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
          <a href="tel:+40256123456" class="footer-contact-link">+40 256 123 456</a>
          <a href="mailto:info@stepupfloor.ro" class="footer-contact-link">info@stepupfloor.ro</a>
          <span class="footer-address">Timișoara, Timiș, România</span>
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
            <li><a href="<?= BASE_URL ?>#servicii"  class="footer-link">Servicii</a></li>
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
  function toggleMobileMenu() {
    document.getElementById('mobile-menu').classList.toggle('open');
  }
  function closeMobileMenu() {
    document.getElementById('mobile-menu').classList.remove('open');
  }
</script>
</body>
</html>

<!-- ═══════════════════════════════════════════ HERO ═══ -->
<section class="hero-section" id="acasa">
  <div class="container">
    <div class="hero-grid">
      <div class="hero-content">
        <p class="label-tag">Timișoara · Vestul României</p>
        <h1>Mochete și covoare montate perfect</h1>
        <p class="hero-sub">Transformăm spații cu instalații profesionale de mochete și covoare PVC în Timișoara și vestul țării. Calitate și precizie în fiecare proiect.</p>
        <div class="btn-group">
          <a href="#contact" class="btn-primary">Solicită ofertă</a>
          <a href="#produse" class="btn-secondary">Produse</a>
        </div>
      </div>
      <div class="hero-img-cell">
        <div class="img-placeholder"></div>
        <div class="hero-accent-bar"></div>
      </div>
    </div>

    <!-- Stats strip -->
    <div class="stats-strip stats-outer">
      <?php foreach ($stats as $key => $stat): ?>
      <div class="stat-cell">
        <p class="stat-value"><?= htmlspecialchars($stat['stat_value']) ?></p>
        <p class="stat-label"><?= htmlspecialchars($stat['label']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ INTRO ═══ -->
<section class="intro-section">
  <div class="container">
    <div class="intro-grid">
      <div class="intro-text">
        <p class="label-tag">Profesionalism</p>
        <h2>Ani de experiență în montaj și vânzări</h2>
        <p class="body-text">Lucrăm cu mochete și covoare PVC de calitate superioară, montate cu atenție la detalii. Fiecare instalație este realizată de meșterii noștri cu experiență și dedicație pentru rezultate impecabile.</p>
        <div class="btn-group">
          <a href="#servicii" class="btn-primary">Servicii</a>
          <a href="<?= BASE_URL ?>despre-noi" class="btn-secondary">Despre noi</a>
        </div>
      </div>
      <div class="feat-cards-grid">
        <div class="feat-card-2x2">
          <div class="feat-card">
            <div class="accent-bar"></div>
            <h3>Montaj rapid</h3>
            <p>Finalizăm proiectele în 24–48 ore fără compromisuri.</p>
          </div>
          <div class="feat-card">
            <div class="accent-bar"></div>
            <h3>Garanție inclus</h3>
            <p>Toate materialele vin cu garanție de 2 ani.</p>
          </div>
        </div>
        <div class="feat-card-2x2">
          <div class="feat-card">
            <div class="accent-bar"></div>
            <h3>Consultanță gratuită</h3>
            <p>Venim la voi pentru măsurători și recomandări.</p>
          </div>
          <div class="feat-card">
            <div class="accent-bar"></div>
            <h3>8 județe</h3>
            <p>Acoperim vestul României cu aceeași atenție.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ SERVICII ═══ -->
<section id="servicii" class="services-section">
  <div class="container">
    <div class="section-header">
      <p class="label-tag">Servicii</p>
      <div class="section-header-row">
        <h2>Ce oferim noi</h2>
        <p class="body-text">Montaj profesional și consultanță pentru toate nevoile tale. Lucrăm cu atenție la detalii și respect față de spațiul tău.</p>
      </div>
    </div>

    <?php foreach ($services as $i => $service): ?>
    <div class="service-row<?= ($i === count($services) - 1) ? ' service-row--last' : '' ?>">
      <div class="service-hdr">
        <span class="service-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
        <span class="service-title"><?= htmlspecialchars($service['title']) ?></span>
      </div>
      <div class="service-body-grid">
        <div class="service-text">
          <p class="label-tag"><?= htmlspecialchars($service['subtitle']) ?></p>
          <h3><?= htmlspecialchars($service['heading']) ?></h3>
          <p class="body-text"><?= htmlspecialchars($service['description']) ?></p>
          <div class="btn-group">
            <a href="#contact" class="btn-secondary">Solicită ofertă</a>
            <a href="<?= BASE_URL ?>servicii/<?= htmlspecialchars($service['slug']) ?>" class="btn-link">Detalii <span>→</span></a>
          </div>
        </div>
        <div class="service-img img-placeholder"></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ═══════════════════════════════════════════ PRODUSE ═══ -->
<section id="produse" class="products-section">
  <div class="container">
    <div class="section-header section-header--center">
      <p class="label-tag">Disponibil</p>
      <h2>Mochete și covoare</h2>
      <p class="body-text">Gama completă de materiale de calitate</p>
    </div>

    <?php if ($featured): ?>
    <div class="products-split">
      <div class="featured-img img-placeholder"></div>
      <div class="featured-content">
        <p class="badge-label"><?= htmlspecialchars($featured['badge']) ?></p>
        <h3><?= htmlspecialchars($featured['heading']) ?></h3>
        <p class="body-text"><?= htmlspecialchars($featured['description']) ?></p>
        <div class="btn-group">
          <a href="<?= BASE_URL ?>produse" class="btn-secondary">Vezi produse</a>
          <a href="<?= BASE_URL ?>produse" class="btn-link">Explorare <span>→</span></a>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <div class="product-grid feat-grid">
      <?php foreach ($products as $idx => $product): ?>
      <div class="product-card feat-card<?= ($idx === 2) ? ' feat-col2' : '' ?>">
        <div class="product-img img-placeholder" style="aspect-ratio:5/4;"></div>
        <div class="product-info">
          <p class="product-cat"><?= htmlspecialchars($product['category']) ?></p>
          <p class="product-name"><?= htmlspecialchars($product['name']) ?></p>
          <p class="product-price"><?= htmlspecialchars($product['price_label']) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="center-btn">
      <a href="<?= BASE_URL ?>produse" class="btn-secondary">Vezi toate produsele</a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ TESTIMONIALE ═══ -->
<section class="testimonials-section">
  <div class="container">
    <div class="testimonials-header">
      <div>
        <p class="label-tag">Testimoniale</p>
        <h2>Ce spun clienții</h2>
      </div>
      <p class="body-text testimonials-sub">Peste 1000 de proiecte livrate în Timișoara și vestul României.</p>
    </div>

    <div class="testimonials-grid feat-grid">
      <?php foreach ($testimonials as $t): ?>
      <div class="tcard">
        <div>
          <div class="stars"><?= str_repeat('★', max(1, min(5, (int)$t['rating']))) ?></div>
          <p class="tcard-text">"<?= htmlspecialchars($t['review_text']) ?>"</p>
        </div>
        <div class="tcard-author">
          <div class="author-avatar"></div>
          <div>
            <p class="author-name"><?= htmlspecialchars($t['name']) ?></p>
            <p class="author-role"><?= htmlspecialchars($t['location']) ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ CONTACT ═══ -->
<section id="contact" class="contact-section">
  <div class="container">
    <div class="section-header">
      <p class="label-tag">Contact</p>
      <h2>Să vorbim</h2>
      <p class="body-text">Contactați-ne pentru o ofertă fără obligații</p>
    </div>

    <?php if (!empty($_SESSION['contact_success'])): ?>
    <div class="alert alert--success"><?= htmlspecialchars($_SESSION['contact_success']) ?></div>
    <?php unset($_SESSION['contact_success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['contact_errors'])): ?>
    <div class="alert alert--error">
      <ul>
        <?php foreach ($_SESSION['contact_errors'] as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php unset($_SESSION['contact_errors']); ?>
    <?php endif; ?>

    <?php $old = $_SESSION['contact_old'] ?? []; unset($_SESSION['contact_old']); ?>

    <div class="contact-grid">
      <div class="contact-info">
        <div class="contact-block">
          <p class="contact-block-label">Email</p>
          <h3 class="contact-block-title">Scrieți-ne oricând</h3>
          <p class="contact-block-sub">Răspundem în maxim 24 ore</p>
          <a href="mailto:info@stepupfloor.ro" class="contact-block-value">info@stepupfloor.ro</a>
        </div>
        <div class="contact-divider"></div>
        <div class="contact-block">
          <p class="contact-block-label">Telefon</p>
          <h3 class="contact-block-title">Sunați direct</h3>
          <p class="contact-block-sub">Luni–Vineri, 8:00–18:00</p>
          <a href="tel:+40256123456" class="contact-block-value">+40 256 123 456</a>
        </div>
        <div class="contact-divider"></div>
        <div class="contact-block">
          <p class="contact-block-label">Adresă</p>
          <h3 class="contact-block-title">Biroul nostru</h3>
          <p class="contact-block-sub">Timișoara, județul Timiș, România</p>
        </div>
      </div>

      <div class="contact-form-wrap">
        <h3 class="form-title">Trimite un mesaj</h3>
        <form method="POST" action="<?= BASE_URL ?>contact/submit" class="contact-form" novalidate>
          <div class="form-row">
            <div class="form-group">
              <label for="name">Nume</label>
              <input type="text" id="name" name="name" placeholder="Numele tău"
                     value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
              <label for="phone">Telefon</label>
              <input type="tel" id="phone" name="phone" placeholder="+40 7xx xxx xxx"
                     value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="email@exemplu.ro"
                   value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
          </div>
          <div class="form-group">
            <label for="message">Mesaj</label>
            <textarea id="message" name="message" rows="4"
                      placeholder="Descrieți proiectul sau întrebarea dvs." required><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
          </div>
          <button type="submit" class="btn-primary btn-full">Trimite mesaj</button>
        </form>
      </div>
    </div>
  </div>
</section>

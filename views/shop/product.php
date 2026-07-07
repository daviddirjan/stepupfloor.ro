<?php
// Build color data for JS
$colorData = [];
foreach ($colorVariants as $ci => $cv) {
    $colorData[] = [
        'id'    => (int)$cv['id'],
        'label' => $cv['name'],
        'swatch'=> $cv['hex_color'] ?: '#888888',
        'image' => $cv['image'] ? BASE_URL . 'assets/images/products/' . $cv['image'] : '',
    ];
}
$hasColors   = !empty($colorData);
$firstColor  = $hasColors ? $colorData[0] : ['label' => '', 'swatch' => '#8A8E96'];
$pricePerM2  = (float)($product['price_per_m2'] ?? 0);
$hasBuyPrice = $pricePerM2 > 0;
?>

<!-- ═══ BREADCRUMB ═══ -->
<div class="prd-breadcrumb-bar">
  <div class="prd-container">
    <nav class="prd-breadcrumb">
      <a href="<?= BASE_URL ?>">Acasă</a>
      <span class="prd-bsep">›</span>
      <a href="<?= BASE_URL ?>magazin">Produse</a>
      <?php if ($category): ?>
        <span class="prd-bsep">›</span>
        <a href="<?= BASE_URL ?>categorie/<?= htmlspecialchars($category['slug']) ?>"><?= htmlspecialchars($category['name']) ?></a>
      <?php endif; ?>
      <span class="prd-bsep">›</span>
      <span class="prd-breadcrumb-current"><?= htmlspecialchars($product['name']) ?></span>
    </nav>
  </div>
</div>

<!-- ═══ PRODUCT LAYOUT ═══ -->
<div class="prd-container prd-layout-wrap">
  <div class="prd-layout">

    <!-- ─── LEFT: IMAGE PANEL ─── -->
    <div class="prd-gallery prd-gallery--sticky" id="prd-gallery">

      <!-- Main swatch panel -->
      <div class="prd-swatch-main" id="prd-swatch-main">
        <!-- Solid color layer — transitions on color change -->
        <div class="prd-swatch-bg" id="prd-swatch-bg" style="background-color:<?= htmlspecialchars($firstColor['swatch']) ?>;"></div>
        <!-- Woven texture overlay -->
        <div class="prd-swatch-texture"></div>
        <!-- Lighting gradient -->
        <div class="prd-swatch-light"></div>
        <!-- Bottom vignette -->
        <div class="prd-swatch-vignette"></div>

        <!-- Real product image (shown when available) -->
        <img src="" alt="" id="prd-main-img" class="prd-swatch-photo" style="display:none;">

        <!-- Photo placeholder (shown when no image) -->
        <div class="prd-swatch-placeholder" id="prd-swatch-placeholder">
          <svg width="44" height="44" viewBox="0 0 44 44" fill="none"><rect x="1.5" y="1.5" width="41" height="41" rx="5" stroke="rgba(255,255,255,0.28)" stroke-width="1.4" stroke-dasharray="4 3"/><circle cx="15" cy="17" r="4.5" stroke="rgba(255,255,255,0.28)" stroke-width="1.4"/><path d="M2 32l11-11 7 7 9-10 15 14" stroke="rgba(255,255,255,0.28)" stroke-width="1.4" stroke-linejoin="round"/></svg>
          <span>fotografie produs</span>
        </div>

        <!-- Color chip (bottom-left) -->
        <div class="prd-swatch-chip" id="prd-swatch-chip">
          <div class="prd-chip-dot" id="prd-chip-dot" style="background-color:<?= htmlspecialchars($firstColor['swatch']) ?>;"></div>
          <span class="prd-chip-label" id="prd-chip-label"><?= htmlspecialchars($firstColor['label']) ?></span>
        </div>

        <!-- Expand icon -->
        <div class="prd-swatch-expand">
          <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M1 1h4M1 1v4M14 1h-4M14 1v4M1 14h4M1 14v-4M14 14h-4M14 14v-4" stroke="rgba(255,255,255,0.65)" stroke-width="1.5" stroke-linecap="round"/></svg>
        </div>
      </div>

      <!-- Thumbnails (4 texture views of the active color) -->
      <div class="prd-thumbs prd-thumbs--swatch" id="prd-thumbs">
        <?php
        $thumbStyles = [
          ['', 'Vista 1'],
          ['filter:brightness(0.78);', 'Detail'],
          ['filter:brightness(1.18) saturate(0.8);', 'Ambient'],
          ['filter:brightness(0.9) saturate(1.2);', 'Textură'],
        ];
        $thumbPatterns = [
          'repeating-linear-gradient(45deg, rgba(255,255,255,0.06) 0px, rgba(255,255,255,0.06) 2px, transparent 2px, transparent 10px)',
          'repeating-linear-gradient(135deg, rgba(255,255,255,0.06) 0px, rgba(255,255,255,0.06) 2px, transparent 2px, transparent 10px)',
          'repeating-linear-gradient(90deg, rgba(0,0,0,0.08) 0px, rgba(0,0,0,0.08) 2px, transparent 2px, transparent 10px)',
          'repeating-linear-gradient(0deg, rgba(255,255,255,0.07) 0px, rgba(255,255,255,0.07) 2px, transparent 2px, transparent 10px)',
        ];
        ?>
        <?php foreach ($thumbStyles as $ti => [$style, $label]): ?>
        <button type="button"
                class="prd-thumb-swatch-btn <?= $ti === 0 ? 'prd-thumb-swatch-btn--active' : '' ?>"
                data-thumb-index="<?= $ti ?>"
                onclick="prdSelectThumb(this)">
          <div class="prd-thumb-swatch-bg" id="prd-thumb-bg-<?= $ti ?>"
               style="background-color:<?= htmlspecialchars($firstColor['swatch']) ?>; <?= $style ?>"></div>
          <div class="prd-thumb-swatch-tex" style="background:<?= $thumbPatterns[$ti] ?>;"></div>
          <span class="prd-thumb-label"><?= $label ?></span>
        </button>
        <?php endforeach; ?>
      </div>

    </div><!-- /prd-gallery -->

    <!-- ─── RIGHT: PRODUCT INFO ─── -->
    <div class="prd-info">

      <!-- Category badge -->
      <?php if ($category): ?>
      <div class="prd-badge-row">
        <span class="prd-cat-badge"><?= htmlspecialchars($category['name']) ?></span>
      </div>
      <?php endif; ?>

      <!-- Title -->
      <h1 class="prd-title"><?= htmlspecialchars($product['name']) ?></h1>

      <!-- Stars + reviews -->
      <?php if ($product['rating']): ?>
      <div class="prd-rating-row">
        <?php $fullStars = floor($product['rating']); $half = ($product['rating'] - $fullStars) >= 0.5; ?>
        <div class="prd-stars">
          <?php for ($s = 1; $s <= 5; $s++): ?>
            <span class="prd-star <?= $s <= $fullStars ? 'filled' : ($s == $fullStars + 1 && $half ? 'half' : '') ?>">★</span>
          <?php endfor; ?>
        </div>
        <span class="prd-rating-text">
          <?= number_format((float)$product['rating'], 1, '.', '') ?>
          <?php if ($product['reviews_count']): ?>
            · <span><?= (int)$product['reviews_count'] ?> recenzii</span>
          <?php endif; ?>
        </span>
      </div>
      <?php endif; ?>

      <!-- Price -->
      <?php if ($hasBuyPrice): ?>
      <div class="prd-price-row">
        <div class="prd-price-main">
          <span class="prd-price-num"><?= number_format($pricePerM2, 0, ',', '.') ?></span>
          <span class="prd-price-currency">lei</span>
          <span class="prd-price-unit">/ m²</span>
        </div>
        <?php if (!empty($product['discount_label'])): ?>
        <span class="prd-discount-badge"><?= htmlspecialchars($product['discount_label']) ?></span>
        <?php endif; ?>
      </div>
      <div class="prd-price-note">Preț include TVA · Transport gratuit la comenzi ≥ 200 m²</div>
      <?php elseif ($product['price_label']): ?>
      <div class="prd-price-row">
        <span class="prd-price-text"><?= htmlspecialchars($product['price_label']) ?></span>
      </div>
      <?php endif; ?>

      <div class="prd-divider"></div>

      <!-- COLOR SELECTOR -->
      <?php if ($hasColors): ?>
      <div class="prd-colors-section">
        <div class="prd-section-label">
          Culoare — <span class="prd-color-name" id="prd-color-name"><?= htmlspecialchars($firstColor['label']) ?></span>
        </div>
        <div class="prd-color-swatches" id="prd-swatches">
          <?php foreach ($colorData as $ci => $cd): ?>
          <div class="prd-swatch-item">
            <button type="button"
                    class="prd-swatch-btn <?= $ci === 0 ? 'active' : '' ?>"
                    title="<?= htmlspecialchars($cd['label']) ?>"
                    style="background-color:<?= htmlspecialchars($cd['swatch']) ?>;"
                    data-swatch="<?= htmlspecialchars($cd['swatch']) ?>"
                    data-color-name="<?= htmlspecialchars($cd['label']) ?>"
                    data-image="<?= htmlspecialchars($cd['image']) ?>"
                    onclick="prdSelectColor(this)">
            </button>
            <span class="prd-color-label-item"><?= htmlspecialchars($cd['label']) ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="prd-divider"></div>
      <?php endif; ?>

      <!-- SPECS GRID -->
      <?php
      $specs = [];
      if ($product['weight_per_m2']) $specs[] = ['label' => 'Greutate / m²', 'value' => number_format((float)$product['weight_per_m2'], 1, '.', ''), 'unit' => 'kg'];
      if ($product['thickness'])     $specs[] = ['label' => 'Grosime', 'value' => preg_replace('/[^0-9.,]/', '', $product['thickness']), 'unit' => preg_replace('/[0-9.,\s]/', '', $product['thickness']) ?: 'mm'];
      if ($product['usage_class'])   $specs[] = ['label' => 'Clasa de uz', 'value' => $product['usage_class'], 'unit' => ''];
      if ($product['warranty'])      $specs[] = ['label' => 'Garanție', 'value' => preg_replace('/[^0-9]/', '', $product['warranty']), 'unit' => preg_replace('/[0-9\s]/', '', $product['warranty']) ?: 'ani'];
      ?>
      <?php if ($specs): ?>
      <div class="prd-specs-grid">
        <?php foreach ($specs as $spec): ?>
        <div class="prd-spec-card">
          <div class="prd-spec-label"><?= htmlspecialchars($spec['label']) ?></div>
          <div class="prd-spec-value">
            <span class="prd-spec-num"><?= htmlspecialchars($spec['value']) ?></span>
            <?php if ($spec['unit']): ?>
            <span class="prd-spec-unit"><?= htmlspecialchars($spec['unit']) ?></span>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- DESCRIPTION -->
      <?php if ($product['description']): ?>
      <div class="prd-description">
        <div class="prd-section-label">Descriere</div>
        <div class="prd-desc-text"><?= nl2br(htmlspecialchars($product['description'])) ?></div>
      </div>
      <?php endif; ?>

      <div class="prd-divider"></div>

      <!-- ADD TO CART / OFFER -->
      <?php if ($hasBuyPrice): ?>
      <form method="POST" action="<?= BASE_URL ?>cos/adauga" id="prd-cart-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
        <input type="hidden" name="return_url" value="produs/<?= htmlspecialchars($product['slug']) ?>">

        <div class="prd-section-label" style="margin-bottom:.75rem;">Cantitate (m²)</div>
        <div class="prd-cart-row">
          <div class="prd-qty-control">
            <button type="button" class="prd-qty-btn" id="prd-qty-dec">−</button>
            <input type="number" name="area_m2" id="prd-qty-input" value="1" min="1" step="1" class="prd-qty-input">
            <button type="button" class="prd-qty-btn" id="prd-qty-inc">+</button>
          </div>
          <button type="submit" class="prd-add-btn">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M1 1h2.5l1.6 8h8.3l1.6-5.5H4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="7.5" cy="15.5" r="1.25" fill="currentColor"/><circle cx="12.5" cy="15.5" r="1.25" fill="currentColor"/></svg>
            Adaugă în coș — <span id="prd-total-price"><?= number_format($pricePerM2, 0, ',', '.') ?></span> lei
          </button>
        </div>
      </form>
      <?php endif; ?>

      <a href="<?= BASE_URL ?>#contact" class="prd-offer-btn">
        Solicită ofertă personalizată
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 3l5 4-5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>

      <!-- Stock -->
      <div class="prd-stock-badge">
        <div class="prd-stock-dot"></div>
        <span>În stoc · Livrare în 5–10 zile lucrătoare</span>
      </div>

    </div><!-- /prd-info -->
  </div><!-- /prd-layout -->
</div>

<script>
(function () {
  var pricePerM2 = <?= $pricePerM2 ?>;
  var qtyInput   = document.getElementById('prd-qty-input');
  var totalEl    = document.getElementById('prd-total-price');

  function fmt(n) { return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
  function updateTotal() {
    if (!qtyInput || !totalEl) return;
    totalEl.textContent = fmt((parseFloat(qtyInput.value) || 1) * pricePerM2);
  }
  if (qtyInput) {
    qtyInput.addEventListener('input', updateTotal);
    document.getElementById('prd-qty-dec')?.addEventListener('click', function () {
      var v = parseFloat(qtyInput.value) || 1;
      if (v > 1) { qtyInput.value = v - 1; updateTotal(); }
    });
    document.getElementById('prd-qty-inc')?.addEventListener('click', function () {
      qtyInput.value = (parseFloat(qtyInput.value) || 1) + 1; updateTotal();
    });
    updateTotal();
  }
})();

function prdApplyColor(swatch, label, imageSrc) {
  // Update gallery background
  var bg = document.getElementById('prd-swatch-bg');
  if (bg) { bg.style.backgroundColor = swatch; bg.style.transition = 'background-color 0.5s ease'; }

  // Update all thumb backgrounds
  for (var i = 0; i < 4; i++) {
    var tb = document.getElementById('prd-thumb-bg-' + i);
    if (tb) { tb.style.backgroundColor = swatch; tb.style.transition = 'background-color 0.5s ease'; }
  }

  // Update color chip
  var dot = document.getElementById('prd-chip-dot');
  var lbl = document.getElementById('prd-chip-label');
  if (dot) { dot.style.backgroundColor = swatch; dot.style.transition = 'background-color 0.4s'; }
  if (lbl) lbl.textContent = label;

  // Update color name label in selector
  var nameEl = document.getElementById('prd-color-name');
  if (nameEl) nameEl.textContent = label;

  // Show/hide real image
  var mainImg   = document.getElementById('prd-main-img');
  var placeholder = document.getElementById('prd-swatch-placeholder');
  if (imageSrc) {
    mainImg.src = imageSrc;
    mainImg.style.display = '';
    if (placeholder) placeholder.style.display = 'none';
  } else {
    mainImg.style.display = 'none';
    if (placeholder) placeholder.style.display = '';
  }
}

function prdSelectColor(btn) {
  document.querySelectorAll('.prd-swatch-btn').forEach(function (b) { b.classList.remove('active'); });
  btn.classList.add('active');
  prdApplyColor(btn.dataset.swatch, btn.dataset.colorName, btn.dataset.image || '');
}

function prdSelectThumb(btn) {
  document.querySelectorAll('.prd-thumb-swatch-btn').forEach(function (b) { b.classList.remove('prd-thumb-swatch-btn--active'); });
  btn.classList.add('prd-thumb-swatch-btn--active');
}
</script>

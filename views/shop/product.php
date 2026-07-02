<?php
// Flash message
if (!empty($_SESSION['flash'])):
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
?>
<div class="flash flash-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['msg']) ?></div>
<?php endif; ?>

<?php
// Build image sets:
// - productImages: [main image, ...gallery images] up to 4 total
// - colorImages: per color, keyed by color id => [img1, img2, img3, img4]
$productImgs = [];
if ($product['image']) $productImgs[] = BASE_URL . 'assets/images/products/' . $product['image'];
foreach ($images as $img) {
    if (count($productImgs) >= 4) break;
    $productImgs[] = BASE_URL . 'assets/images/products/' . $img['filename'];
}

$colorData = [];
foreach ($colorVariants as $cv) {
    $imgs = [];
    foreach (['image', 'image2', 'image3', 'image4'] as $f) {
        $imgs[] = !empty($cv[$f]) ? BASE_URL . 'assets/images/products/' . $cv[$f] : '';
    }
    $colorData[] = [
        'id'        => $cv['id'],
        'name'      => $cv['name'],
        'hex_color' => $cv['hex_color'] ?: '#888888',
        'images'    => $imgs,
    ];
}

$hasColors     = !empty($colorData);
$activeColor   = $hasColors ? $colorData[0] : null;
$activeImages  = $hasColors ? $activeColor['images'] : $productImgs;

$mainImg   = $activeImages[0] ?? null;
$thumbImgs = array_slice($activeImages, 0, 4);
// Pad to 4 with empty strings
while (count($thumbImgs) < 4) $thumbImgs[] = '';
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

        <!-- ─── LEFT: GALLERY ─── -->
        <div class="prd-gallery" id="prd-gallery">

            <!-- Main image -->
            <div class="prd-gallery-main" id="prd-main-wrap">
                <?php if ($mainImg): ?>
                    <img src="<?= htmlspecialchars($mainImg) ?>" alt="<?= htmlspecialchars($product['name']) ?>" id="prd-main-img" class="prd-main-img">
                <?php else: ?>
                    <div class="prd-img-placeholder" id="prd-main-placeholder">
                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none"><rect x="1.5" y="1.5" width="41" height="41" rx="5" stroke="rgba(15,36,67,0.18)" stroke-width="1.4" stroke-dasharray="4 3"/><circle cx="15" cy="17" r="4.5" stroke="rgba(15,36,67,0.18)" stroke-width="1.4"/><path d="M2 32l11-11 7 7 9-10 15 14" stroke="rgba(15,36,67,0.18)" stroke-width="1.4" stroke-linejoin="round"/></svg>
                        <span>fotografie produs</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Thumbnails (4 slots) -->
            <div class="prd-thumbs" id="prd-thumbs">
                <?php foreach ($thumbImgs as $ti => $timg): ?>
                <button type="button"
                        class="prd-thumb-btn <?= $ti === 0 ? 'active' : '' ?>"
                        data-img="<?= htmlspecialchars($timg) ?>"
                        onclick="prdSelectThumb(this)"
                        <?= $timg ? '' : 'style="visibility:hidden;"' ?>>
                    <?php if ($timg): ?>
                        <img src="<?= htmlspecialchars($timg) ?>" alt="Imagine <?= $ti + 1 ?>">
                    <?php else: ?>
                        <div class="prd-thumb-empty"></div>
                    <?php endif; ?>
                </button>
                <?php endforeach; ?>
            </div>
        </div>

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
                <?php
                $fullStars = floor($product['rating']);
                $half = ($product['rating'] - $fullStars) >= 0.5;
                ?>
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
            <?php if ($product['price_per_m2']): ?>
            <div class="prd-price-row">
                <div class="prd-price-main">
                    <span class="prd-price-num"><?= number_format((float)$product['price_per_m2'], 0, ',', '.') ?></span>
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

            <!-- Color selector -->
            <?php if ($hasColors): ?>
            <div class="prd-colors-section">
                <div class="prd-section-label">
                    Culoare — <span class="prd-color-name" id="prd-color-name"><?= htmlspecialchars($colorData[0]['name']) ?></span>
                </div>
                <div class="prd-color-swatches">
                    <?php foreach ($colorData as $ci => $cd): ?>
                    <button type="button"
                            class="prd-swatch-btn <?= $ci === 0 ? 'active' : '' ?>"
                            title="<?= htmlspecialchars($cd['name']) ?>"
                            style="background-color:<?= htmlspecialchars($cd['hex_color']) ?>;"
                            data-color-name="<?= htmlspecialchars($cd['name']) ?>"
                            data-images="<?= htmlspecialchars(json_encode($cd['images'])) ?>"
                            onclick="prdSelectColor(this)">
                    </button>
                    <?php endforeach; ?>
                </div>
                <div class="prd-color-labels">
                    <?php foreach ($colorData as $cd): ?>
                    <div class="prd-color-label-item"><?= htmlspecialchars($cd['name']) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="prd-divider"></div>
            <?php endif; ?>

            <!-- Specs grid -->
            <?php
            $specs = [];
            if ($product['weight_per_m2']) $specs[] = ['label' => 'Greutate / m²', 'value' => number_format((float)$product['weight_per_m2'], 1, '.', ''), 'unit' => 'kg'];
            if ($product['thickness'])     $specs[] = ['label' => 'Grosime',        'value' => preg_replace('/[^0-9.]/', '', $product['thickness']), 'unit' => preg_replace('/[0-9.]/', '', $product['thickness']) ?: 'mm'];
            if ($product['usage_class'])   $specs[] = ['label' => 'Clasa de uz',    'value' => $product['usage_class'], 'unit' => ''];
            if ($product['warranty'])      $specs[] = ['label' => 'Garanție',        'value' => preg_replace('/[^0-9]/', '', $product['warranty']), 'unit' => preg_replace('/[0-9]/', '', $product['warranty']) ?: 'ani'];
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

            <!-- Description -->
            <?php if ($product['description']): ?>
            <div class="prd-description">
                <div class="prd-section-label">Descriere</div>
                <div class="prd-desc-text"><?= nl2br(htmlspecialchars($product['description'])) ?></div>
            </div>
            <?php endif; ?>

            <div class="prd-divider"></div>

            <!-- Add to cart / offer -->
            <?php if ($product['price_per_m2']): ?>
            <form method="POST" action="<?= BASE_URL ?>cos/adauga" id="prd-cart-form">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                <input type="hidden" name="return_url" value="produs/<?= htmlspecialchars($product['slug']) ?>">

                <div class="prd-section-label" style="margin-bottom:.75rem;">Cantitate (m²)</div>

                <div class="prd-cart-row">
                    <!-- Qty stepper -->
                    <div class="prd-qty-control">
                        <button type="button" class="prd-qty-btn" id="prd-qty-dec">−</button>
                        <input type="number" name="area_m2" id="prd-qty-input" value="1" min="1" step="1" class="prd-qty-input">
                        <button type="button" class="prd-qty-btn" id="prd-qty-inc">+</button>
                    </div>
                    <!-- Add to cart button -->
                    <button type="submit" class="prd-add-btn">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M1 1h2.5l1.6 8h8.3l1.6-5.5H4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="7.5" cy="15.5" r="1.25" fill="currentColor"/><circle cx="12.5" cy="15.5" r="1.25" fill="currentColor"/></svg>
                        Adaugă în coș — <span id="prd-total-price"><?= number_format((float)$product['price_per_m2'], 0, ',', '.') ?></span> lei
                    </button>
                </div>
            </form>

            <a href="<?= BASE_URL ?>#contact" class="prd-offer-btn">
                Solicită ofertă personalizată
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 3l5 4-5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <?php else: ?>
            <a href="<?= BASE_URL ?>#contact" class="prd-add-btn" style="display:flex;align-items:center;justify-content:center;text-decoration:none;">
                Solicită ofertă
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" style="margin-left:8px;"><path d="M1 6.5h11M7 2l5 4.5L7 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <?php endif; ?>

            <!-- Stock indicator -->
            <div class="prd-stock-badge">
                <div class="prd-stock-dot"></div>
                <span>În stoc · Livrare în 5–10 zile lucrătoare</span>
            </div>

        </div><!-- /prd-info -->
    </div><!-- /prd-layout -->
</div><!-- /prd-layout-wrap -->

<script>
(function () {
    var pricePerM2 = <?= (float)($product['price_per_m2'] ?? 0) ?>;
    var qtyInput   = document.getElementById('prd-qty-input');
    var totalEl    = document.getElementById('prd-total-price');

    function formatNum(n) {
        return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateTotal() {
        if (!qtyInput || !totalEl) return;
        var qty   = parseFloat(qtyInput.value) || 1;
        var total = qty * pricePerM2;
        totalEl.textContent = formatNum(total);
    }

    if (qtyInput) {
        qtyInput.addEventListener('input', updateTotal);
        document.getElementById('prd-qty-dec')?.addEventListener('click', function () {
            var v = parseFloat(qtyInput.value) || 1;
            if (v > 1) { qtyInput.value = v - 1; updateTotal(); }
        });
        document.getElementById('prd-qty-inc')?.addEventListener('click', function () {
            qtyInput.value = (parseFloat(qtyInput.value) || 1) + 1;
            updateTotal();
        });
        updateTotal();
    }
})();

function prdSelectThumb(btn) {
    document.querySelectorAll('.prd-thumb-btn').forEach(function (b) { b.classList.remove('active'); });
    btn.classList.add('active');
    var img   = btn.dataset.img;
    var mainI = document.getElementById('prd-main-img');
    var mainP = document.getElementById('prd-main-placeholder');
    if (img) {
        if (mainI) { mainI.src = img; mainI.style.display = ''; }
        if (mainP) mainP.style.display = 'none';
        if (!mainI) {
            var el = document.createElement('img');
            el.id = 'prd-main-img'; el.className = 'prd-main-img';
            el.src = img; el.alt = '';
            document.getElementById('prd-main-wrap').appendChild(el);
        }
    }
}

function prdSelectColor(btn) {
    // Update swatch active state
    document.querySelectorAll('.prd-swatch-btn').forEach(function (b) { b.classList.remove('active'); });
    btn.classList.add('active');

    // Update color name label
    var nameEl = document.getElementById('prd-color-name');
    if (nameEl) nameEl.textContent = btn.dataset.colorName;

    // Update gallery images
    var imgs = JSON.parse(btn.dataset.images || '[]');
    var thumbBtns = document.querySelectorAll('.prd-thumb-btn');
    thumbBtns.forEach(function (tb, idx) {
        var src = imgs[idx] || '';
        tb.dataset.img = src;
        tb.style.visibility = src ? '' : 'hidden';
        var imgEl = tb.querySelector('img');
        var emptyEl = tb.querySelector('.prd-thumb-empty');
        if (src) {
            if (imgEl) { imgEl.src = src; }
            else {
                var newImg = document.createElement('img');
                newImg.src = src; newImg.alt = '';
                if (emptyEl) emptyEl.replaceWith(newImg);
                else tb.appendChild(newImg);
            }
            if (emptyEl) emptyEl.style.display = 'none';
        } else {
            if (imgEl) imgEl.style.display = 'none';
        }
    });

    // Set main image to first available
    var firstSrc = imgs[0] || '';
    var mainI = document.getElementById('prd-main-img');
    var mainP = document.getElementById('prd-main-placeholder');
    if (firstSrc) {
        if (mainI) { mainI.src = firstSrc; mainI.style.display = ''; }
        if (mainP) mainP.style.display = 'none';
    } else {
        if (mainI) mainI.style.display = 'none';
        if (mainP) mainP.style.display = '';
    }

    // Reset active thumb to first
    thumbBtns.forEach(function (tb) { tb.classList.remove('active'); });
    if (thumbBtns[0]) thumbBtns[0].classList.add('active');
}
</script>

<?php
// Flash message
if (!empty($_SESSION['flash'])):
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
?>
<div class="flash flash-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['msg']) ?></div>
<?php endif; ?>

<!-- Breadcrumb -->
<div class="container">
    <nav class="breadcrumb">
        <a href="<?= BASE_URL ?>magazin" class="breadcrumb-link">Magazin</a>
        <?php if ($category): ?>
            <span class="breadcrumb-sep">›</span>
            <a href="<?= BASE_URL ?>categorie/<?= htmlspecialchars($category['slug']) ?>" class="breadcrumb-link">
                <?= htmlspecialchars($category['name']) ?>
            </a>
        <?php endif; ?>
        <span class="breadcrumb-sep">›</span>
        <span><?= htmlspecialchars($product['name']) ?></span>
    </nav>
</div>

<!-- Product Layout -->
<div class="container">
    <div class="product-layout">

        <!-- Left: Image Gallery -->
        <div class="product-gallery">
            <?php
            // Build all images: main image + gallery images
            $allImages = [];
            if ($product['image']) $allImages[] = $product['image'];
            foreach ($images as $img) {
                if (!in_array($img['filename'], $allImages)) $allImages[] = $img['filename'];
            }
            $mainImg = $allImages[0] ?? null;
            ?>
            <div class="product-gallery-main">
                <?php if ($mainImg): ?>
                    <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($mainImg) ?>"
                         alt="<?= htmlspecialchars($product['name']) ?>"
                         id="gallery-main-img">
                <?php else: ?>
                    <div class="product-card-placeholder" style="height:100%;min-height:400px;"></div>
                <?php endif; ?>
            </div>
            <?php if (count($allImages) > 1): ?>
                <div class="product-gallery-thumbs">
                    <?php foreach ($allImages as $i => $img): ?>
                        <button class="gallery-thumb-btn <?= $i === 0 ? 'active' : '' ?>"
                                onclick="swapMainImage(this, '<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($img) ?>')"
                                type="button">
                            <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($img) ?>"
                                 alt="Imagine <?= $i + 1 ?>">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right: Product Info -->
        <div class="product-info">
            <?php if ($product['badge']): ?>
                <span class="product-info-badge"><?= htmlspecialchars($product['badge']) ?></span>
            <?php endif; ?>

            <h1 class="product-info-title"><?= htmlspecialchars($product['name']) ?></h1>

            <?php if ($product['price_per_m2']): ?>
                <p class="product-info-price">
                    <?= number_format((float)$product['price_per_m2'], 2, ',', '.') ?>
                    <span class="product-info-price-unit">lei/m²</span>
                </p>
            <?php elseif ($product['price_label']): ?>
                <p class="product-info-price"><?= htmlspecialchars($product['price_label']) ?></p>
            <?php endif; ?>

            <?php if ($product['heading']): ?>
                <p class="product-info-heading"><?= htmlspecialchars($product['heading']) ?></p>
            <?php endif; ?>

            <?php if ($product['description']): ?>
                <p class="product-info-desc"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            <?php endif; ?>

            <!-- Specs Table -->
            <?php $hasSpecs = $product['thickness'] || $product['color'] || $product['weight_per_m2']; ?>
            <?php if ($hasSpecs): ?>
                <table class="specs-table">
                    <?php if ($product['thickness']): ?>
                        <tr>
                            <th>Grosime</th>
                            <td><?= htmlspecialchars($product['thickness']) ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($product['color']): ?>
                        <tr>
                            <th>Culoare</th>
                            <td><?= htmlspecialchars($product['color']) ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($product['weight_per_m2']): ?>
                        <tr>
                            <th>Greutate / m²</th>
                            <td><?= number_format((float)$product['weight_per_m2'], 2, ',', '.') ?> kg/m²</td>
                        </tr>
                    <?php endif; ?>
                </table>
            <?php endif; ?>

            <!-- Add to Cart -->
            <?php if ($product['price_per_m2']): ?>
                <form method="POST" action="<?= BASE_URL ?>cos/adauga" class="add-to-cart-form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                    <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                    <input type="hidden" name="return_url" value="produs/<?= htmlspecialchars($product['slug']) ?>">

                    <div class="qty-row">
                        <label for="area-input">Suprafață (m²)</label>
                        <input type="number" id="area-input" name="area_m2" value="1" min="0.1" step="0.1">
                    </div>

                    <p class="price-preview">
                        Total estimat: <strong id="total-preview">
                            <?= number_format((float)$product['price_per_m2'], 2, ',', '.') ?> lei
                        </strong>
                    </p>

                    <button type="submit" class="btn-primary btn-full">
                        <svg viewBox="0 0 18 18" fill="none" width="16" height="16" style="margin-right:.4rem;">
                            <path d="M1 1h2.5l1.6 8h8.3l1.6-5.5H4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="7.5" cy="15.5" r="1.25" fill="currentColor"/>
                            <circle cx="12.5" cy="15.5" r="1.25" fill="currentColor"/>
                        </svg>
                        Adaugă în coș
                    </button>
                </form>
            <?php else: ?>
                <a href="<?= BASE_URL ?>#contact" class="btn-primary btn-full" style="justify-content:center;">
                    Solicită ofertă
                </a>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
(function () {
    var pricePerM2 = <?= (float)($product['price_per_m2'] ?? 0) ?>;
    var areaInput  = document.getElementById('area-input');
    var preview    = document.getElementById('total-preview');

    if (!areaInput || !preview) return;

    function updatePreview() {
        var area  = parseFloat(areaInput.value.replace(',', '.')) || 0;
        var total = area * pricePerM2;
        preview.textContent = total.toFixed(2).replace('.', ',') + ' lei';
    }

    areaInput.addEventListener('input', updatePreview);
    updatePreview();
})();

function swapMainImage(btn, src) {
    document.querySelectorAll('.gallery-thumb-btn').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    var main = document.getElementById('gallery-main-img');
    if (main) main.src = src;
}
</script>

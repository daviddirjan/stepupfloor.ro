<!-- Flash message -->
<?php if (!empty($_SESSION['flash'])): ?>
    <div class="flash flash-<?= $_SESSION['flash']['type'] ?>">
        <?= htmlspecialchars($_SESSION['flash']['msg']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<!-- Page Hero -->
<section class="shop-hero">
    <div class="container">
        <p class="shop-hero-label">Colecție</p>
        <h1 class="shop-hero-title">Magazin</h1>
        <p class="shop-hero-desc">Descoperă gama noastră de pardoseli — mochete, covoare PVC, LVT și dale modulare pentru orice spațiu.</p>
    </div>
</section>

<!-- Category Filter Bar -->
<div class="container">
    <div class="category-filter-bar">
        <a href="<?= BASE_URL ?>magazin"
           class="category-filter-btn <?= $activeCategoryId === 0 ? 'active' : '' ?>">
            Toate produsele
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="<?= BASE_URL ?>categorie/<?= htmlspecialchars($cat['slug']) ?>"
               class="category-filter-btn <?= $activeCategoryId === (int)$cat['id'] ? 'active' : '' ?>">
                <?= htmlspecialchars($cat['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Products Grid -->
    <?php if (empty($products)): ?>
        <div class="shop-empty">
            <p>Niciun produs disponibil momentan.</p>
            <a href="<?= BASE_URL ?>magazin" class="btn-secondary" style="margin-top:1rem;display:inline-flex;">Resetează filtrele</a>
        </div>
    <?php else: ?>
        <div class="shop-grid">
            <?php foreach ($products as $p): ?>
                <a href="<?= BASE_URL ?>produs/<?= htmlspecialchars($p['slug']) ?>" class="product-card">
                    <div class="product-card-img">
                        <?php if ($p['image']): ?>
                            <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($p['image']) ?>"
                                 alt="<?= htmlspecialchars($p['name']) ?>">
                        <?php else: ?>
                            <div class="product-card-placeholder"></div>
                        <?php endif; ?>
                        <?php if ($p['badge']): ?>
                            <span class="product-card-badge"><?= htmlspecialchars($p['badge']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="product-card-body">
                        <?php if (!empty($p['category_name'])): ?>
                            <p class="product-card-category"><?= htmlspecialchars($p['category_name']) ?></p>
                        <?php endif; ?>
                        <p class="product-card-name"><?= htmlspecialchars($p['name']) ?></p>
                        <?php if ($p['price_per_m2']): ?>
                            <p class="product-card-price"><?= number_format((float)$p['price_per_m2'], 2, ',', '.') ?> lei/m²</p>
                        <?php elseif ($p['price_label']): ?>
                            <p class="product-card-price"><?= htmlspecialchars($p['price_label']) ?></p>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Breadcrumb -->
<div class="container">
    <nav class="breadcrumb">
        <a href="<?= BASE_URL ?>magazin" class="breadcrumb-link">Magazin</a>
        <span class="breadcrumb-sep">›</span>
        <span><?= htmlspecialchars($category['name']) ?></span>
    </nav>
</div>

<!-- Category Header -->
<section class="shop-hero">
    <div class="container">
        <p class="shop-hero-label">Categorie</p>
        <h1 class="shop-hero-title"><?= htmlspecialchars($category['name']) ?></h1>
    </div>
</section>

<div class="container">
    <div class="shop-layout">

        <!-- Sidebar Filtre -->
        <aside class="shop-sidebar">
            <form method="GET" action="<?= BASE_URL ?>categorie/<?= htmlspecialchars($category['slug']) ?>">

                <?php if (!empty($thicknesses)): ?>
                    <div class="filter-group">
                        <p class="filter-group-title">Grosime</p>
                        <?php foreach ($thicknesses as $t): ?>
                            <label class="filter-check-item">
                                <input type="checkbox" name="grosime[]" value="<?= htmlspecialchars($t) ?>"
                                       <?= in_array($t, $filters['thickness'], true) ? 'checked' : '' ?>>
                                <?= htmlspecialchars($t) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($colors)): ?>
                    <div class="filter-group">
                        <p class="filter-group-title">Culoare</p>
                        <?php foreach ($colors as $c): ?>
                            <label class="filter-check-item">
                                <input type="checkbox" name="culoare[]" value="<?= htmlspecialchars($c) ?>"
                                       <?= in_array($c, $filters['color'], true) ? 'checked' : '' ?>>
                                <?= htmlspecialchars($c) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="filter-group">
                    <p class="filter-group-title">Preț / m² (RON)</p>
                    <div class="filter-price-row">
                        <input type="number" name="pret_min" placeholder="Min"
                               value="<?= $filters['price_min'] > 0 ? htmlspecialchars($filters['price_min']) : '' ?>"
                               min="0" step="1">
                        <span>—</span>
                        <input type="number" name="pret_max" placeholder="Max"
                               value="<?= $filters['price_max'] > 0 ? htmlspecialchars($filters['price_max']) : '' ?>"
                               min="0" step="1">
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">Aplică filtrele</button>
                <a href="<?= BASE_URL ?>categorie/<?= htmlspecialchars($category['slug']) ?>"
                   class="btn-secondary" style="width:100%;justify-content:center;margin-top:.5rem;">Resetează</a>
            </form>
        </aside>

        <!-- Products Grid -->
        <div>
            <?php if (empty($products)): ?>
                <div class="shop-empty">
                    <p>Niciun produs găsit cu filtrele selectate.</p>
                    <a href="<?= BASE_URL ?>categorie/<?= htmlspecialchars($category['slug']) ?>"
                       class="btn-secondary" style="margin-top:1rem;display:inline-flex;">Resetează filtrele</a>
                </div>
            <?php else: ?>
                <p class="shop-count"><?= count($products) ?> produs<?= count($products) !== 1 ? 'e' : '' ?></p>
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
                                <p class="product-card-name"><?= htmlspecialchars($p['name']) ?></p>
                                <?php if ($p['thickness']): ?>
                                    <p class="product-card-spec">Grosime: <?= htmlspecialchars($p['thickness']) ?></p>
                                <?php endif; ?>
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

    </div>
</div>

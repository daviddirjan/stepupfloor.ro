<?php if (!empty($errors)): ?>
    <div class="flash flash-error">
        <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" enctype="multipart/form-data"
          action="<?= BASE_URL ?>admin/products/<?= $product['id'] ? 'update/' . $product['id'] : 'store' ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="name">Nume *</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($product['slug']) ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category_id">Categorie</label>
                <select id="category_id" name="category_id">
                    <option value="0">— Fără categorie —</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (int)$product['category_id'] === (int)$cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price_label">Preț / etichetă</label>
                <input type="text" id="price_label" name="price_label" value="<?= htmlspecialchars($product['price_label']) ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="heading">Titlu secțiune (heading)</label>
            <input type="text" id="heading" name="heading" value="<?= htmlspecialchars($product['heading']) ?>">
        </div>

        <div class="form-group">
            <label for="description">Descriere</label>
            <textarea id="description" name="description"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="badge">Badge</label>
                <input type="text" id="badge" name="badge" value="<?= htmlspecialchars($product['badge']) ?>">
            </div>
            <div class="form-group" style="max-width:160px;">
                <label for="sort_order">Ordine</label>
                <input type="number" id="sort_order" name="sort_order" value="<?= (int)$product['sort_order'] ?>" min="0">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="thickness">Grosime <small>(ex: 6mm, 10mm)</small></label>
                <input type="text" id="thickness" name="thickness" value="<?= htmlspecialchars($product['thickness'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="color">Culoare</label>
                <input type="text" id="color" name="color" value="<?= htmlspecialchars($product['color'] ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="weight_per_m2">Greutate / m² <small>(kg)</small></label>
                <input type="number" id="weight_per_m2" name="weight_per_m2" step="0.01" min="0"
                       value="<?= htmlspecialchars($product['weight_per_m2'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="price_per_m2">Preț / m² <small>(RON) *</small></label>
                <input type="number" id="price_per_m2" name="price_per_m2" step="0.01" min="0"
                       value="<?= htmlspecialchars($product['price_per_m2'] ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label>
                <div class="checkbox-row">
                    <input type="checkbox" name="is_featured" <?= $product['is_featured'] ? 'checked' : '' ?>>
                    <span>Produs featured</span>
                </div>
            </label>
        </div>

        <div class="form-group">
            <label for="image">Imagine principală <small>(JPG, PNG, WebP — max 3MB)</small></label>
            <?php if ($product['image']): ?>
                <div style="margin-bottom:.5rem;">
                    <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($product['image']) ?>" class="img-preview">
                    <div style="font-size:0.78rem;color:#6b7280;margin-top:.25rem;">Imaginea curentă: <?= htmlspecialchars($product['image']) ?></div>
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
        </div>

        <div class="form-group">
            <label>Galerie imagini <small>(multiple, JPG/PNG/WebP, max 3MB fiecare)</small></label>
            <?php if (!empty($galleryImages)): ?>
                <div class="gallery-admin-grid">
                    <?php foreach ($galleryImages as $img): ?>
                        <div class="gallery-admin-thumb">
                            <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($img['filename']) ?>" alt="">
                            <?php if ($product['id']): ?>
                            <form method="POST"
                                  action="<?= BASE_URL ?>admin/products/delete-image/<?= $product['id'] ?>/<?= $img['id'] ?>"
                                  onsubmit="return confirm('Ștergi această imagine?')">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                <button type="submit" class="gallery-del-btn" title="Șterge">✕</button>
                            </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" style="margin-top:.5rem;">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Salvează</button>
            <a href="<?= BASE_URL ?>admin/products" class="btn-secondary">Anulează</a>
        </div>
    </form>
</div>

<script>
document.getElementById('name').addEventListener('input', function () {
    const slug = document.getElementById('slug');
    if (slug.value === '') {
        slug.value = this.value.toLowerCase()
            .replace(/[ăâ]/g,'a').replace(/[îí]/g,'i').replace(/[șş]/g,'s').replace(/[țţ]/g,'t')
            .replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
    }
});
</script>

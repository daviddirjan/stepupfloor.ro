<?php if (!empty($errors)): ?>
    <div class="flash flash-error">
        <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" enctype="multipart/form-data"
          action="<?= BASE_URL ?>admin/products/<?= $product['id'] ? 'update/' . $product['id'] : 'store' ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <!-- ─── Identificare ─── -->
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
                <label for="badge">Badge <small>(ex: Nou, Recomandat)</small></label>
                <input type="text" id="badge" name="badge" value="<?= htmlspecialchars($product['badge']) ?>">
            </div>
        </div>

        <!-- ─── Texte ─── -->
        <div class="form-group">
            <label for="heading">Titlu secțiune (heading)</label>
            <input type="text" id="heading" name="heading" value="<?= htmlspecialchars($product['heading']) ?>">
        </div>

        <div class="form-group">
            <label for="description">Descriere</label>
            <textarea id="description" name="description"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <!-- ─── Preț ─── -->
        <div class="form-row">
            <div class="form-group">
                <label for="price_per_m2">Preț / m² <small>(RON)</small></label>
                <input type="number" id="price_per_m2" name="price_per_m2" step="0.01" min="0"
                       value="<?= htmlspecialchars($product['price_per_m2'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="discount_label">Etichetă reducere <small>(ex: -15% față de list)</small></label>
                <input type="text" id="discount_label" name="discount_label"
                       value="<?= htmlspecialchars($product['discount_label'] ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="price_label">Preț text alternativ <small>(dacă nu ai preț/m²)</small></label>
            <input type="text" id="price_label" name="price_label" value="<?= htmlspecialchars($product['price_label']) ?>">
        </div>

        <!-- ─── Specificații ─── -->
        <div class="form-row">
            <div class="form-group">
                <label for="thickness">Grosime <small>(ex: 6mm)</small></label>
                <input type="text" id="thickness" name="thickness" value="<?= htmlspecialchars($product['thickness'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="weight_per_m2">Greutate / m² <small>(kg)</small></label>
                <input type="number" id="weight_per_m2" name="weight_per_m2" step="0.01" min="0"
                       value="<?= htmlspecialchars($product['weight_per_m2'] ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="usage_class">Clasa de uz <small>(ex: 32 - uz intensiv comercial)</small></label>
                <input type="text" id="usage_class" name="usage_class"
                       value="<?= htmlspecialchars($product['usage_class'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="warranty">Garanție <small>(ex: 10 ani)</small></label>
                <input type="text" id="warranty" name="warranty"
                       value="<?= htmlspecialchars($product['warranty'] ?? '') ?>">
            </div>
        </div>

        <!-- ─── Rating ─── -->
        <div class="form-row">
            <div class="form-group">
                <label for="rating">Rating <small>(1.0 – 5.0, lasă gol pentru a nu afișa)</small></label>
                <input type="number" id="rating" name="rating" step="0.1" min="1" max="5"
                       value="<?= htmlspecialchars($product['rating'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="reviews_count">Număr recenzii</label>
                <input type="number" id="reviews_count" name="reviews_count" min="0"
                       value="<?= (int)($product['reviews_count'] ?? 0) ?>">
            </div>
        </div>

        <!-- ─── Ordine & featured ─── -->
        <div class="form-row">
            <div class="form-group">
                <label for="sort_order">Ordine</label>
                <input type="number" id="sort_order" name="sort_order" value="<?= (int)$product['sort_order'] ?>" min="0">
            </div>
            <div class="form-group" style="justify-content:flex-end; padding-top:1.5rem;">
                <label>
                    <div class="checkbox-row">
                        <input type="checkbox" name="is_featured" <?= $product['is_featured'] ? 'checked' : '' ?>>
                        <span>Produs featured</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- ─── Imagine principală produs ─── -->
        <div class="form-group">
            <label for="image">Imagine principală produs <small>(JPG, PNG, WebP — max 3MB)</small></label>
            <?php if ($product['image']): ?>
                <div style="margin-bottom:.5rem;">
                    <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($product['image']) ?>" class="img-preview">
                    <div style="font-size:.78rem;color:#6b7280;margin-top:.25rem;"><?= htmlspecialchars($product['image']) ?></div>
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
        </div>

        <!-- ─── Galerie secundară produs (max 3) ─── -->
        <div class="form-group">
            <label>Galerie produs — imagini secundare <small>(max 3: JPG/PNG/WebP, max 3MB fiecare)</small></label>
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
            <?php $galleryCount = count($galleryImages ?? []); ?>
            <?php if ($galleryCount < 3): ?>
                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                       style="margin-top:.5rem;"
                       title="Poți adăuga până la <?= 3 - $galleryCount ?> imagine(i)">
            <?php else: ?>
                <p style="font-size:.8rem;color:#6b7280;margin-top:.5rem;">Ai atins limita de 3 imagini secundare. Șterge una pentru a adăuga alta.</p>
            <?php endif; ?>
        </div>

        <!-- ─── Variații de culoare ─── -->
        <div class="form-group" style="margin-top:1.5rem;">
            <label style="font-weight:600;font-size:.95rem;">Variații de culoare</label>
            <p style="font-size:.8rem;color:#6b7280;margin:.25rem 0 .75rem;">
                Fiecare culoare poate avea o imagine principală și 3 secundare (afișate în galeria produsului când culoarea este selectată).
            </p>

            <div id="color-variants-list" style="margin-top:.25rem;">
                <?php foreach ($colorVariants as $i => $cv): ?>
                <div class="color-variant-row" data-index="<?= $i ?>" style="border:1px solid #e5e7eb;border-radius:10px;padding:1.25rem;margin-bottom:1rem;background:#fafafa;">
                    <input type="hidden" name="colors[<?= $i ?>][id]" value="<?= $cv['id'] ?>">
                    <input type="hidden" name="colors[<?= $i ?>][_delete]" value="0" class="cv-delete-flag">

                    <!-- Row 1: name, code, hex -->
                    <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:.75rem;margin-bottom:.75rem;align-items:end;">
                        <div>
                            <label style="font-size:.8rem;color:#6b7280;">Nume culoare *</label>
                            <input type="text" name="colors[<?= $i ?>][name]" value="<?= htmlspecialchars($cv['name']) ?>" placeholder="ex: Gri Antracit" style="margin-top:.25rem;">
                        </div>
                        <div>
                            <label style="font-size:.8rem;color:#6b7280;">Cod comercial</label>
                            <input type="text" name="colors[<?= $i ?>][code]" value="<?= htmlspecialchars($cv['code']) ?>" placeholder="ex: 2456" style="margin-top:.25rem;">
                        </div>
                        <div style="text-align:center;">
                            <label style="font-size:.8rem;color:#6b7280;display:block;margin-bottom:.25rem;">Culoare swatch</label>
                            <input type="color" name="colors[<?= $i ?>][hex_color]"
                                   value="<?= htmlspecialchars($cv['hex_color'] ?: '#888888') ?>"
                                   style="width:48px;height:38px;padding:2px;border:1px solid #d1d5db;border-radius:6px;cursor:pointer;">
                        </div>
                    </div>

                    <!-- Row 2: 4 image slots -->
                    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem;margin-bottom:.75rem;">
                        <?php
                        $imgSlots = [
                            ['field' => 'image',  'label' => 'Imagine principală', 'inputName' => 'color_images',  'slot' => 1],
                            ['field' => 'image2', 'label' => 'Secundară 1',        'inputName' => 'color_images2', 'slot' => 2],
                            ['field' => 'image3', 'label' => 'Secundară 2',        'inputName' => 'color_images3', 'slot' => 3],
                            ['field' => 'image4', 'label' => 'Secundară 3',        'inputName' => 'color_images4', 'slot' => 4],
                        ];
                        foreach ($imgSlots as $slot):
                            $currentImg = $cv[$slot['field']] ?? '';
                        ?>
                        <div style="border:1px solid #e5e7eb;border-radius:8px;padding:.6rem;background:#fff;">
                            <div style="font-size:.75rem;font-weight:600;color:#374151;margin-bottom:.4rem;"><?= $slot['label'] ?></div>
                            <?php if ($currentImg && $product['id']): ?>
                                <div style="position:relative;margin-bottom:.35rem;">
                                    <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($currentImg) ?>"
                                         style="width:100%;height:70px;object-fit:cover;border-radius:4px;border:1px solid #e5e7eb;">
                                    <form method="POST"
                                          action="<?= BASE_URL ?>admin/products/delete-color-image/<?= $product['id'] ?>/<?= $cv['id'] ?>/<?= $slot['slot'] ?>"
                                          onsubmit="return confirm('Ștergi imaginea?')"
                                          style="margin:0;">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                        <button type="submit" style="margin-top:.25rem;font-size:.7rem;color:#ef4444;background:none;border:none;cursor:pointer;padding:0;">✕ Șterge</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="<?= $slot['inputName'] ?>[<?= $i ?>]"
                                   accept="image/jpeg,image/png,image/webp"
                                   style="font-size:.72rem;width:100%;">
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Delete row button -->
                    <div style="text-align:right;">
                        <button type="button" class="cv-remove-btn" style="background:#fee2e2;border:none;border-radius:6px;padding:.35rem .75rem;color:#dc2626;cursor:pointer;font-size:.82rem;">✕ Șterge culoarea</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="add-color-variant" style="background:#eff6ff;border:1px dashed #93c5fd;border-radius:6px;padding:.5rem 1rem;color:#2563eb;cursor:pointer;font-size:.85rem;">+ Adaugă culoare</button>
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

(function () {
    const list = document.getElementById('color-variants-list');
    let nextIndex = <?= max(count($colorVariants), 0) ?>;

    function attachRemove(row) {
        row.querySelector('.cv-remove-btn').addEventListener('click', function () {
            const flag = row.querySelector('.cv-delete-flag');
            const hasId = row.querySelector('input[name*="[id]"]')?.value;
            if (hasId) {
                flag.value = '1';
                row.style.opacity = '0.35';
                row.style.pointerEvents = 'none';
                this.textContent = 'Marcat pentru ștergere';
            } else {
                row.remove();
            }
        });
    }

    list.querySelectorAll('.color-variant-row').forEach(attachRemove);

    document.getElementById('add-color-variant').addEventListener('click', function () {
        const i = nextIndex++;
        const div = document.createElement('div');
        div.className = 'color-variant-row';
        div.dataset.index = i;
        div.style.cssText = 'border:1px solid #e5e7eb;border-radius:10px;padding:1.25rem;margin-bottom:1rem;background:#fafafa;';
        div.innerHTML = `
            <input type="hidden" name="colors[${i}][_delete]" value="0" class="cv-delete-flag">
            <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:.75rem;margin-bottom:.75rem;align-items:end;">
                <div>
                    <label style="font-size:.8rem;color:#6b7280;">Nume culoare *</label>
                    <input type="text" name="colors[${i}][name]" placeholder="ex: Gri Antracit" style="margin-top:.25rem;">
                </div>
                <div>
                    <label style="font-size:.8rem;color:#6b7280;">Cod comercial</label>
                    <input type="text" name="colors[${i}][code]" placeholder="ex: 2456" style="margin-top:.25rem;">
                </div>
                <div style="text-align:center;">
                    <label style="font-size:.8rem;color:#6b7280;display:block;margin-bottom:.25rem;">Culoare swatch</label>
                    <input type="color" name="colors[${i}][hex_color]" value="#888888"
                           style="width:48px;height:38px;padding:2px;border:1px solid #d1d5db;border-radius:6px;cursor:pointer;">
                </div>
            </div>
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem;margin-bottom:.75rem;">
                ${['Imagine principală','Secundară 1','Secundară 2','Secundară 3'].map((lbl, s) => {
                    const inputNames = ['color_images','color_images2','color_images3','color_images4'];
                    return `<div style="border:1px solid #e5e7eb;border-radius:8px;padding:.6rem;background:#fff;">
                        <div style="font-size:.75rem;font-weight:600;color:#374151;margin-bottom:.4rem;">${lbl}</div>
                        <input type="file" name="${inputNames[s]}[${i}]" accept="image/jpeg,image/png,image/webp" style="font-size:.72rem;width:100%;">
                    </div>`;
                }).join('')}
            </div>
            <div style="text-align:right;">
                <button type="button" class="cv-remove-btn" style="background:#fee2e2;border:none;border-radius:6px;padding:.35rem .75rem;color:#dc2626;cursor:pointer;font-size:.82rem;">✕ Șterge culoarea</button>
            </div>
        `;
        list.appendChild(div);
        attachRemove(div);
        div.querySelector('input[type="text"]').focus();
    });
})();
</script>

<?php if (!empty($errors)): ?>
    <div class="flash flash-error">
        <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="<?= BASE_URL ?>admin/testimonials/<?= $testimonial['id'] ? 'update/' . $testimonial['id'] : 'store' ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="name">Nume client *</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($testimonial['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Locație</label>
                <input type="text" id="location" name="location" value="<?= htmlspecialchars($testimonial['location']) ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="review_text">Recenzie *</label>
            <textarea id="review_text" name="review_text" rows="5"><?= htmlspecialchars($testimonial['review_text']) ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="rating">Rating (1–5 stele)</label>
                <select id="rating" name="rating">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?= $i ?>" <?= (int)$testimonial['rating'] === $i ? 'selected' : '' ?>>
                            <?= str_repeat('★', $i) ?> (<?= $i ?>)
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="form-group" style="max-width:160px;">
                <label for="sort_order">Ordine</label>
                <input type="number" id="sort_order" name="sort_order" value="<?= (int)$testimonial['sort_order'] ?>" min="0">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Salvează</button>
            <a href="<?= BASE_URL ?>admin/testimonials" class="btn-secondary">Anulează</a>
        </div>
    </form>
</div>

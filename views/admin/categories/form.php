<?php if (!empty($errors)): ?>
    <div class="flash flash-error">
        <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="<?= BASE_URL ?>admin/categories/<?= $category['id'] ? 'update/' . $category['id'] : 'store' ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <div class="form-group">
            <label for="name">Nume *</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($category['name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="slug">Slug <small>(auto-generat dacă e gol)</small></label>
            <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($category['slug']) ?>">
        </div>

        <div class="form-group" style="max-width:160px;">
            <label for="sort_order">Ordine afișare</label>
            <input type="number" id="sort_order" name="sort_order" value="<?= (int)$category['sort_order'] ?>" min="0">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Salvează</button>
            <a href="<?= BASE_URL ?>admin/categories" class="btn-secondary">Anulează</a>
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

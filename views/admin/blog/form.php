<?php if (!empty($errors)): ?>
    <div class="flash flash-error">
        <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="form-card" style="max-width:900px;">
    <form method="POST" enctype="multipart/form-data"
          action="<?= BASE_URL ?>admin/blog/<?= $post['id'] ? 'update/' . $post['id'] : 'store' ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="title">Titlu *</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($post['slug']) ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="excerpt">Rezumat (excerpt)</label>
            <textarea id="excerpt" name="excerpt" rows="3"><?= htmlspecialchars($post['excerpt']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="body">Conținut * <small>(HTML acceptat)</small></label>
            <textarea id="body" name="body" class="body-area"><?= htmlspecialchars($post['body']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Imagine cover <small>(JPG, PNG, WebP — max 3MB)</small></label>
            <?php if ($post['image']): ?>
                <div style="margin-bottom:.5rem;">
                    <img src="<?= BASE_URL ?>assets/images/blog/<?= htmlspecialchars($post['image']) ?>" class="img-preview">
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>&nbsp;</label>
                <div class="checkbox-row" style="margin-top:.35rem;">
                    <input type="checkbox" id="is_published" name="is_published" <?= $post['is_published'] ? 'checked' : '' ?>>
                    <label for="is_published">Publicat</label>
                </div>
            </div>
            <div class="form-group">
                <label for="published_at">Dată publicare <small>(opțional)</small></label>
                <input type="text" id="published_at" name="published_at" placeholder="YYYY-MM-DD HH:MM:SS"
                       value="<?= htmlspecialchars($post['published_at'] ?? '') ?>">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Salvează</button>
            <a href="<?= BASE_URL ?>admin/blog" class="btn-secondary">Anulează</a>
        </div>
    </form>
</div>

<script>
document.getElementById('title').addEventListener('input', function () {
    const slug = document.getElementById('slug');
    if (slug.value === '') {
        slug.value = this.value.toLowerCase()
            .replace(/[ăâ]/g,'a').replace(/[îí]/g,'i').replace(/[șş]/g,'s').replace(/[țţ]/g,'t')
            .replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
    }
});
</script>

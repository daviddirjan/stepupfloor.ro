<?php if (!empty($errors)): ?>
    <div class="flash flash-error">
        <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="form-card" style="max-width:900px;">
    <form method="POST" enctype="multipart/form-data"
          action="<?= BASE_URL ?>admin/projects/<?= $project['id'] ? 'update/' . $project['id'] : 'store' ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="title">Titlu *</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($project['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($project['slug']) ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="client">Client</label>
                <input type="text" id="client" name="client" value="<?= htmlspecialchars($project['client']) ?>">
            </div>
            <div class="form-group">
                <label for="location">Localitate *</label>
                <input type="text" id="location" name="location" value="<?= htmlspecialchars($project['location']) ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="year">An *</label>
                <input type="number" id="year" name="year" min="2000" max="2099"
                       value="<?= (int)($project['year'] ?: date('Y')) ?>" required>
            </div>
            <div class="form-group">
                <label for="surface">Suprafață (m²)</label>
                <input type="number" id="surface" name="surface" min="0"
                       value="<?= (int)$project['surface'] ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Tag-uri</label>
            <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:4px;">
                <?php foreach ($allTags as $tag): ?>
                <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-weight:400;">
                    <input type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag) ?>"
                           <?= in_array($tag, $project['tags'], true) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($tag) ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Descriere</label>
            <textarea id="description" name="description" rows="4"><?= htmlspecialchars($project['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Imagine proiect <small>(JPG, PNG, WebP — max 5MB)</small></label>
            <?php if ($project['image']): ?>
                <div style="margin-bottom:.5rem;">
                    <img src="<?= BASE_URL ?>assets/images/projects/<?= htmlspecialchars($project['image']) ?>" class="img-preview">
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
        </div>

        <div class="form-group">
            <div class="checkbox-row">
                <input type="checkbox" id="is_published" name="is_published" <?= $project['is_published'] ? 'checked' : '' ?>>
                <label for="is_published">Publicat</label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Salvează</button>
            <a href="<?= BASE_URL ?>admin/projects" class="btn-secondary">Anulează</a>
        </div>
    </form>
</div>

<script>
document.getElementById('title').addEventListener('input', function () {
    var slug = document.getElementById('slug');
    if (slug.value === '') {
        slug.value = this.value.toLowerCase()
            .replace(/[ăâ]/g,'a').replace(/[îí]/g,'i').replace(/[șş]/g,'s').replace(/[țţ]/g,'t')
            .replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
    }
});
</script>

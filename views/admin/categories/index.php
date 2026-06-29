<div style="margin-bottom:1rem;text-align:right;">
    <a href="<?= BASE_URL ?>admin/categories/create" class="btn-primary">+ Categorie nouă</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nume</th>
                <th>Slug</th>
                <th>Ordine</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($categories)): ?>
            <tr><td colspan="5" style="text-align:center;color:#9ca3af;padding:2rem;">Nicio categorie încă.</td></tr>
        <?php else: ?>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat['id'] ?></td>
                <td><?= htmlspecialchars($cat['name']) ?></td>
                <td><code><?= htmlspecialchars($cat['slug']) ?></code></td>
                <td><?= $cat['sort_order'] ?></td>
                <td>
                    <div class="actions">
                        <a href="<?= BASE_URL ?>admin/categories/edit/<?= $cat['id'] ?>" class="btn-secondary btn-sm">Editează</a>
                        <form method="POST" action="<?= BASE_URL ?>admin/categories/delete/<?= $cat['id'] ?>" onsubmit="return confirm('Ștergi categoria?')">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                            <button type="submit" class="btn-danger btn-sm">Șterge</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

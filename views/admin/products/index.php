<div style="margin-bottom:1rem;text-align:right;">
    <a href="<?= BASE_URL ?>admin/products/create" class="btn-primary">+ Produs nou</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Imagine</th>
                <th>Nume</th>
                <th>Categorie</th>
                <th>Preț</th>
                <th>Ordine</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($products)): ?>
            <tr><td colspan="7" style="text-align:center;color:#9ca3af;padding:2rem;">Niciun produs încă.</td></tr>
        <?php else: ?>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td>
                    <?php if ($p['image']): ?>
                        <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($p['image']) ?>" style="height:40px;border-radius:4px;object-fit:cover;">
                    <?php else: ?>
                        <span style="color:#9ca3af;">—</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= htmlspecialchars($p['category_name'] ?? $p['category'] ?? '—') ?></td>
                <td><?= htmlspecialchars($p['price_label']) ?></td>
                <td><?= $p['sort_order'] ?></td>
                <td>
                    <div class="actions">
                        <a href="<?= BASE_URL ?>admin/products/edit/<?= $p['id'] ?>" class="btn-secondary btn-sm">Editează</a>
                        <form method="POST" action="<?= BASE_URL ?>admin/products/delete/<?= $p['id'] ?>" onsubmit="return confirm('Ștergi produsul?')">
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

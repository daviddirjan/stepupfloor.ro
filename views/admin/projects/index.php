<div style="margin-bottom:1rem;text-align:right;">
    <a href="<?= BASE_URL ?>admin/projects/create" class="btn-primary">+ Proiect nou</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Titlu</th>
                <th>Localitate</th>
                <th>An</th>
                <th>Suprafață</th>
                <th>Tag-uri</th>
                <th>Status</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($projects)): ?>
            <tr><td colspan="8" style="text-align:center;color:#9ca3af;padding:2rem;">Niciun proiect încă.</td></tr>
        <?php else: ?>
            <?php foreach ($projects as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['title']) ?></td>
                <td><?= htmlspecialchars($p['location']) ?></td>
                <td><?= (int)$p['year'] ?></td>
                <td><?= $p['surface'] ? number_format((int)$p['surface'], 0, ',', '.') . ' m²' : '—' ?></td>
                <td><?= htmlspecialchars(implode(', ', $p['tags'])) ?: '—' ?></td>
                <td>
                    <?php if ($p['is_published']): ?>
                        <span class="pill pill-green">Publicat</span>
                    <?php else: ?>
                        <span class="pill pill-gray">Draft</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="actions">
                        <a href="<?= BASE_URL ?>admin/projects/edit/<?= $p['id'] ?>" class="btn-secondary btn-sm">Editează</a>
                        <form method="POST" action="<?= BASE_URL ?>admin/projects/delete/<?= $p['id'] ?>" onsubmit="return confirm('Ștergi proiectul?')">
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

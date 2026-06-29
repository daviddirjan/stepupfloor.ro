<div style="margin-bottom:1rem;text-align:right;">
    <a href="<?= BASE_URL ?>admin/blog/create" class="btn-primary">+ Articol nou</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Titlu</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Publicat la</th>
                <th>Creat la</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($posts)): ?>
            <tr><td colspan="7" style="text-align:center;color:#9ca3af;padding:2rem;">Niciun articol încă.</td></tr>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td><?= $post['id'] ?></td>
                <td><?= htmlspecialchars($post['title']) ?></td>
                <td><code><?= htmlspecialchars($post['slug']) ?></code></td>
                <td>
                    <?php if ($post['is_published']): ?>
                        <span class="pill pill-green">Publicat</span>
                    <?php else: ?>
                        <span class="pill pill-gray">Draft</span>
                    <?php endif; ?>
                </td>
                <td><?= $post['published_at'] ? date('d.m.Y', strtotime($post['published_at'])) : '—' ?></td>
                <td><?= date('d.m.Y', strtotime($post['created_at'])) ?></td>
                <td>
                    <div class="actions">
                        <a href="<?= BASE_URL ?>admin/blog/edit/<?= $post['id'] ?>" class="btn-secondary btn-sm">Editează</a>
                        <form method="POST" action="<?= BASE_URL ?>admin/blog/delete/<?= $post['id'] ?>" onsubmit="return confirm('Ștergi articolul?')">
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

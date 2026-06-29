<div style="margin-bottom:1rem;text-align:right;">
    <a href="<?= BASE_URL ?>admin/testimonials/create" class="btn-primary">+ Testimonial nou</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nume</th>
                <th>Locație</th>
                <th>Rating</th>
                <th>Recenzie</th>
                <th>Ordine</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($testimonials)): ?>
            <tr><td colspan="7" style="text-align:center;color:#9ca3af;padding:2rem;">Niciun testimonial încă.</td></tr>
        <?php else: ?>
            <?php foreach ($testimonials as $t): ?>
            <tr>
                <td><?= $t['id'] ?></td>
                <td><?= htmlspecialchars($t['name']) ?></td>
                <td><?= htmlspecialchars($t['location']) ?></td>
                <td><?= str_repeat('★', (int)$t['rating']) ?></td>
                <td style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    <?= htmlspecialchars(mb_strimwidth($t['review_text'], 0, 80, '…')) ?>
                </td>
                <td><?= $t['sort_order'] ?></td>
                <td>
                    <div class="actions">
                        <a href="<?= BASE_URL ?>admin/testimonials/edit/<?= $t['id'] ?>" class="btn-secondary btn-sm">Editează</a>
                        <form method="POST" action="<?= BASE_URL ?>admin/testimonials/delete/<?= $t['id'] ?>" onsubmit="return confirm('Ștergi testimonialul?')">
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

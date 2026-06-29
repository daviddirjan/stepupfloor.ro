<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Nume</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Mesaj</th>
                <th>Status</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($contacts)): ?>
            <tr><td colspan="8" style="text-align:center;color:#9ca3af;padding:2rem;">Niciun mesaj primit încă.</td></tr>
        <?php else: ?>
            <?php foreach ($contacts as $c): ?>
            <tr class="<?= !$c['is_read'] ? 'tr-unread' : '' ?>">
                <td><?= $c['id'] ?></td>
                <td style="white-space:nowrap;"><?= date('d.m.Y H:i', strtotime($c['created_at'])) ?></td>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td><a href="mailto:<?= htmlspecialchars($c['email']) ?>"><?= htmlspecialchars($c['email']) ?></a></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
                <td style="max-width:280px;">
                    <span title="<?= htmlspecialchars($c['message']) ?>">
                        <?= htmlspecialchars(mb_strimwidth($c['message'], 0, 70, '…')) ?>
                    </span>
                </td>
                <td>
                    <?php if ($c['is_read']): ?>
                        <span class="pill pill-green">Citit</span>
                    <?php else: ?>
                        <span class="pill pill-yellow">Necitit</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!$c['is_read']): ?>
                    <form method="POST" action="<?= BASE_URL ?>admin/contacts/read/<?= $c['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                        <button type="submit" class="btn-warning btn-sm">Marchează citit</button>
                    </form>
                    <?php else: ?>
                        <span style="color:#9ca3af;font-size:.8rem;">—</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

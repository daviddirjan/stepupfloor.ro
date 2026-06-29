<div style="margin-bottom:1rem;text-align:right;">
    <a href="<?= BASE_URL ?>admin/orders/create" class="btn-primary">+ Comandă nouă</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Client</th>
                <th>Email / Telefon</th>
                <th>Total</th>
                <th>Status</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($orders)): ?>
            <tr><td colspan="7" style="text-align:center;color:#9ca3af;padding:2rem;">Nicio comandă încă.</td></tr>
        <?php else: ?>
            <?php foreach ($orders as $o): ?>
            <?php
                $statusClass = match($o['status']) {
                    'completed' => 'pill-green',
                    'confirmed' => 'pill-yellow',
                    'cancelled' => 'pill-gray',
                    default     => 'pill-yellow',
                };
            ?>
            <tr>
                <td><?= $o['id'] ?></td>
                <td style="white-space:nowrap;"><?= date('d.m.Y', strtotime($o['created_at'])) ?></td>
                <td><?= htmlspecialchars($o['customer_name']) ?></td>
                <td>
                    <?php if ($o['customer_email']): ?>
                        <a href="mailto:<?= htmlspecialchars($o['customer_email']) ?>"><?= htmlspecialchars($o['customer_email']) ?></a><br>
                    <?php endif; ?>
                    <?= htmlspecialchars($o['customer_phone']) ?>
                </td>
                <td><strong><?= number_format((float)$o['total'], 2, ',', '.') ?> RON</strong></td>
                <td><span class="pill <?= $statusClass ?>"><?= htmlspecialchars($statuses[$o['status']] ?? $o['status']) ?></span></td>
                <td>
                    <div class="actions">
                        <a href="<?= BASE_URL ?>admin/orders/edit/<?= $o['id'] ?>" class="btn-secondary btn-sm">Editează</a>
                        <form method="POST" action="<?= BASE_URL ?>admin/orders/delete/<?= $o['id'] ?>" onsubmit="return confirm('Ștergi comanda?')">
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

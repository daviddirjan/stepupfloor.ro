<div class="container" style="padding-top:3rem;padding-bottom:5rem;">
    <div class="confirmation-box">

        <div class="confirmation-icon">
            <svg viewBox="0 0 64 64" fill="none" width="64" height="64">
                <circle cx="32" cy="32" r="30" stroke="#27AE60" stroke-width="2.5"/>
                <path d="M20 33l8 8 16-16" stroke="#27AE60" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <?php $isConfirmed = ($order['status'] ?? '') === 'confirmed'; ?>

        <h1 class="confirmation-title"><?= $isConfirmed ? 'Comandă confirmată!' : 'Comandă înregistrată!' ?></h1>
        <p class="confirmation-subtitle">
            Mulțumim, <strong><?= htmlspecialchars($order['customer_name']) ?></strong>!
            Am primit comanda dumneavoastră și vă vom contacta în scurt timp.
        </p>

        <div class="order-summary-box">
            <div class="order-meta">
                <div class="order-meta-row">
                    <span>Număr comandă</span>
                    <strong>#<?= (int)$order['id'] ?></strong>
                </div>
                <div class="order-meta-row">
                    <span>Data</span>
                    <strong><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></strong>
                </div>
                <div class="order-meta-row">
                    <span>Status</span>
                    <strong style="color:#27AE60;"><?= $isConfirmed ? 'Confirmat' : 'În procesare' ?></strong>
                </div>
                <?php if ($order['customer_email']): ?>
                    <div class="order-meta-row">
                        <span>Email</span>
                        <strong><?= htmlspecialchars($order['customer_email']) ?></strong>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($order['items'])): ?>
                <table class="cart-table" style="margin-top:1.5rem;font-size:.9rem;">
                    <thead>
                        <tr>
                            <th>Produs</th>
                            <th>m²</th>
                            <th>Preț/m²</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                <td><?= htmlspecialchars($item['area_m2']) ?></td>
                                <td><?= number_format((float)$item['price_per_m2'], 2, ',', '.') ?> lei</td>
                                <td><?= number_format((float)$item['total_price'], 2, ',', '.') ?> lei</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <div class="cart-total-row" style="margin-top:1rem;">
                <span>Total plătit</span>
                <span><?= number_format((float)$order['total'], 2, ',', '.') ?> RON</span>
            </div>
        </div>

        <div class="confirmation-contact">
            <p>Aveți întrebări? Sunați la
                <a href="tel:+40745990503"><strong>0745 990 503</strong></a>
                sau scrieți la
                <a href="mailto:office@stepupsolutions.ro"><strong>office@stepupsolutions.ro</strong></a>
            </p>
        </div>

        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;margin-top:2rem;">
            <a href="<?= BASE_URL ?>magazin" class="btn-primary">
                Continuă cumpărăturile
            </a>
            <a href="<?= BASE_URL ?>#contact" class="btn-secondary">
                Contactează-ne
            </a>
        </div>
    </div>
</div>

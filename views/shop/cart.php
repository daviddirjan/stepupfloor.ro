<?php
if (!empty($_SESSION['flash'])):
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
?>
<div class="flash flash-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['msg']) ?></div>
<?php endif; ?>

<section class="shop-hero">
    <div class="container">
        <p class="shop-hero-label">Cumpărături</p>
        <h1 class="shop-hero-title">Coșul meu</h1>
    </div>
</section>

<div class="container" style="padding-bottom:4rem;">
    <?php if (empty($items)): ?>
        <div class="shop-empty" style="text-align:center;padding:4rem 0;">
            <svg viewBox="0 0 48 48" fill="none" width="64" height="64" style="margin:0 auto 1.5rem;display:block;opacity:.3;">
                <path d="M4 4h6l4 22h22l4-14H12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="20" cy="41" r="3" fill="currentColor"/>
                <circle cx="34" cy="41" r="3" fill="currentColor"/>
            </svg>
            <p style="font-family:var(--font-ui);font-size:1.125rem;margin-bottom:1.5rem;">Coșul tău este gol.</p>
            <a href="<?= BASE_URL ?>magazin" class="btn-primary" style="display:inline-flex;">Mergi la magazin</a>
        </div>
    <?php else: ?>

        <form method="POST" action="<?= BASE_URL ?>cos/update" id="cart-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Produs</th>
                        <th>Suprafață (m²)</th>
                        <th>Preț / m²</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $key => $item): ?>
                        <tr>
                            <td>
                                <div class="cart-product-cell">
                                    <?php if ($item['image']): ?>
                                        <img src="<?= BASE_URL ?>assets/images/products/<?= htmlspecialchars($item['image']) ?>"
                                             alt="" class="cart-thumb">
                                    <?php endif; ?>
                                    <a href="<?= BASE_URL ?>produs/<?= htmlspecialchars($item['product_slug']) ?>"
                                       class="cart-product-name">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <input type="number" class="cart-area-input"
                                       name="items[<?= htmlspecialchars($key) ?>][area_m2]"
                                       value="<?= htmlspecialchars($item['quantity_m2']) ?>"
                                       min="0.1" step="0.1">
                            </td>
                            <td><?= number_format((float)$item['price_per_m2'], 2, ',', '.') ?> lei</td>
                            <td class="cart-line-total">
                                <?= number_format($item['quantity_m2'] * $item['price_per_m2'], 2, ',', '.') ?> lei
                            </td>
                            <td>
                                <form method="POST" action="<?= BASE_URL ?>cos/sterge" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                    <input type="hidden" name="item_key" value="<?= htmlspecialchars($key) ?>">
                                    <button type="submit" class="cart-remove-btn" title="Șterge">✕</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-actions">
                <button type="submit" class="btn-secondary">Actualizează coșul</button>
            </div>
        </form>

        <div class="cart-summary">
            <div class="cart-summary-row">
                <span>Subtotal</span>
                <span><?= number_format($total, 2, ',', '.') ?> lei</span>
            </div>
            <div class="cart-total-row">
                <span>Total</span>
                <span><?= number_format($total, 2, ',', '.') ?> lei</span>
            </div>
            <p class="cart-note">TVA și transport calculate la checkout.</p>
            <a href="<?= BASE_URL ?>checkout" class="btn-primary btn-full" style="justify-content:center;margin-top:1rem;">
                Finalizează comanda
                <svg viewBox="0 0 13 13" fill="none" width="13" height="13" style="margin-left:.4rem;">
                    <path d="M1 6.5h11M7 2l5 4.5L7 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <a href="<?= BASE_URL ?>magazin" class="btn-secondary btn-full" style="justify-content:center;margin-top:.5rem;">
                Continuă cumpărăturile
            </a>
        </div>

    <?php endif; ?>
</div>

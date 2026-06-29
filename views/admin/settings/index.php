<?php
$pk  = $settings['stripe_publishable_key'] ?? '';
$sk  = $settings['stripe_secret_key']      ?? '';
$wh  = $settings['stripe_webhook_secret']  ?? '';

$pkSet = $pk !== '';
$skSet = $sk !== '';
$whSet = $wh !== '';
?>

<div class="form-card">

    <!-- Stripe Status Banner -->
    <div class="settings-status-bar <?= ($pkSet && $skSet) ? 'settings-status-bar--ok' : 'settings-status-bar--warn' ?>">
        <?php if ($pkSet && $skSet): ?>
            <svg viewBox="0 0 16 16" fill="none" width="16" height="16"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M5 8l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Stripe este configurat și activ.
        <?php else: ?>
            <svg viewBox="0 0 16 16" fill="none" width="16" height="16"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M8 5v4M8 11v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            Stripe nu este configurat. Completați cheile de mai jos pentru a activa plățile online.
        <?php endif; ?>
    </div>

    <form method="POST" action="<?= BASE_URL ?>admin/settings/save" autocomplete="off">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <h2 class="settings-section-title">
            <svg viewBox="0 0 24 24" fill="none" width="18" height="18" style="vertical-align:middle;margin-right:.4rem;">
                <rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/>
                <path d="M2 10h20" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            Stripe — Plăți online
        </h2>
        <p class="settings-desc">
            Găsești aceste chei în
            <a href="https://dashboard.stripe.com/apikeys" target="_blank" rel="noopener">Stripe Dashboard → Developers → API keys</a>.
            Folosește cheile <strong>test</strong> pentru mediul de dezvoltare și cheile <strong>live</strong> înainte de lansare.
        </p>

        <div class="form-group">
            <label for="stripe_publishable_key">
                Publishable Key
                <span class="settings-key-hint">Începe cu <code>pk_test_</code> sau <code>pk_live_</code></span>
            </label>
            <div class="settings-input-wrap">
                <input type="text" id="stripe_publishable_key" name="stripe_publishable_key"
                       value="<?= htmlspecialchars($pk) ?>"
                       placeholder="pk_test_..."
                       spellcheck="false" autocomplete="off">
                <?php if ($pkSet): ?>
                    <span class="settings-badge settings-badge--ok">Setat</span>
                <?php else: ?>
                    <span class="settings-badge settings-badge--warn">Lipsă</span>
                <?php endif; ?>
            </div>
            <p class="settings-field-note">Cheie publică — folosită în browser pentru Stripe.js</p>
        </div>

        <div class="form-group">
            <label for="stripe_secret_key">
                Secret Key
                <span class="settings-key-hint">Începe cu <code>sk_test_</code> sau <code>sk_live_</code></span>
            </label>
            <div class="settings-input-wrap">
                <input type="password" id="stripe_secret_key" name="stripe_secret_key"
                       value="<?= htmlspecialchars($sk) ?>"
                       placeholder="sk_test_..."
                       spellcheck="false" autocomplete="new-password">
                <button type="button" class="settings-toggle-btn" onclick="toggleVisibility('stripe_secret_key', this)" title="Arată/ascunde">
                    <svg id="eye-sk" viewBox="0 0 20 20" fill="none" width="16" height="16"><path d="M1 10s3.5-6 9-6 9 6 9 6-3.5 6-9 6-9-6-9-6z" stroke="currentColor" stroke-width="1.4"/><circle cx="10" cy="10" r="2.5" stroke="currentColor" stroke-width="1.4"/></svg>
                </button>
                <?php if ($skSet): ?>
                    <span class="settings-badge settings-badge--ok">Setat</span>
                <?php else: ?>
                    <span class="settings-badge settings-badge--warn">Lipsă</span>
                <?php endif; ?>
            </div>
            <p class="settings-field-note">Cheie secretă — folosită server-side. Nu o expune niciodată în browser.</p>
        </div>

        <div class="form-group">
            <label for="stripe_webhook_secret">
                Webhook Secret
                <span class="settings-key-hint">Începe cu <code>whsec_</code></span>
            </label>
            <div class="settings-input-wrap">
                <input type="password" id="stripe_webhook_secret" name="stripe_webhook_secret"
                       value="<?= htmlspecialchars($wh) ?>"
                       placeholder="whsec_..."
                       spellcheck="false" autocomplete="new-password">
                <button type="button" class="settings-toggle-btn" onclick="toggleVisibility('stripe_webhook_secret', this)" title="Arată/ascunde">
                    <svg viewBox="0 0 20 20" fill="none" width="16" height="16"><path d="M1 10s3.5-6 9-6 9 6 9 6-3.5 6-9 6-9-6-9-6z" stroke="currentColor" stroke-width="1.4"/><circle cx="10" cy="10" r="2.5" stroke="currentColor" stroke-width="1.4"/></svg>
                </button>
                <?php if ($whSet): ?>
                    <span class="settings-badge settings-badge--ok">Setat</span>
                <?php else: ?>
                    <span class="settings-badge settings-badge--warn">Opțional</span>
                <?php endif; ?>
            </div>
            <p class="settings-field-note">
                Secretul webhook-ului — necesar pentru verificarea evenimentelor Stripe trimise la
                <code><?= htmlspecialchars(rtrim((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'), '/')) ?>/stripe/webhook</code>
            </p>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Salvează setările</button>
        </div>
    </form>
</div>

<script>
function toggleVisibility(inputId, btn) {
    var input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.title = 'Ascunde';
        btn.style.opacity = '1';
    } else {
        input.type = 'password';
        btn.title = 'Arată';
        btn.style.opacity = '';
    }
}
</script>

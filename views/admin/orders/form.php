<?php if (!empty($errors)): ?>
    <div class="flash flash-error">
        <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="<?= BASE_URL ?>admin/orders/<?= $order['id'] ? 'update/' . $order['id'] : 'store' ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="customer_name">Nume client *</label>
                <input type="text" id="customer_name" name="customer_name" value="<?= htmlspecialchars($order['customer_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <?php foreach ($statuses as $key => $label): ?>
                        <option value="<?= $key ?>" <?= $order['status'] === $key ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="customer_email">Email</label>
                <input type="text" id="customer_email" name="customer_email" value="<?= htmlspecialchars($order['customer_email']) ?>">
            </div>
            <div class="form-group">
                <label for="customer_phone">Telefon</label>
                <input type="text" id="customer_phone" name="customer_phone" value="<?= htmlspecialchars($order['customer_phone']) ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="total">Total (RON)</label>
            <input type="text" id="total" name="total" value="<?= htmlspecialchars($order['total']) ?>">
        </div>

        <div class="form-group">
            <label for="notes">Note / Detalii comandă</label>
            <textarea id="notes" name="notes" rows="4"><?= htmlspecialchars($order['notes'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Salvează</button>
            <a href="<?= BASE_URL ?>admin/orders" class="btn-secondary">Anulează</a>
        </div>
    </form>
</div>

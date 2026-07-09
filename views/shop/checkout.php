<section class="shop-hero">
    <div class="container">
        <p class="shop-hero-label">Pas final</p>
        <h1 class="shop-hero-title">Finalizare comandă</h1>
    </div>
</section>

<div class="container" style="padding-bottom:4rem;">
    <div class="checkout-layout">

        <!-- Left: Customer Form -->
        <div>
            <h2 class="checkout-section-title">Date de livrare</h2>

            <form id="checkout-form" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="customer_name">Nume complet *</label>
                        <input type="text" id="customer_name" name="customer_name" required placeholder="Ion Popescu">
                    </div>
                    <div class="form-group">
                        <label for="customer_phone">Telefon *</label>
                        <input type="tel" id="customer_phone" name="customer_phone" required placeholder="0745 123 456">
                    </div>
                </div>

                <div class="form-group">
                    <label for="customer_email">Email *</label>
                    <input type="email" id="customer_email" name="customer_email" required placeholder="email@exemplu.ro">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="customer_city">Oraș *</label>
                        <input type="text" id="customer_city" name="customer_city" required placeholder="Timișoara">
                    </div>
                    <div class="form-group">
                        <label for="customer_address">Adresă</label>
                        <input type="text" id="customer_address" name="customer_address" placeholder="Str. Exemplu, nr. 10">
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Observații</label>
                    <textarea id="notes" name="notes" rows="3" placeholder="Instrucțiuni speciale, etaj, interfon..."></textarea>
                </div>

                <h2 class="checkout-section-title" style="margin-top:2rem;">Plată cu cardul</h2>

                <div id="payment-element" class="stripe-payment-element"></div>
                <div id="card-errors" role="alert"></div>

                <button type="submit" id="submit-btn" class="btn-primary btn-full" style="justify-content:center;margin-top:1.5rem;">
                    <span id="submit-text">
                        Plătește <?= number_format($total, 2, ',', '.') ?> RON
                    </span>
                    <span id="submit-spinner" style="display:none;">Se procesează...</span>
                </button>
            </form>
        </div>

        <!-- Right: Order Summary -->
        <div>
            <div class="checkout-summary">
                <h2 class="checkout-section-title">Sumar comandă</h2>
                <table class="cart-table" style="font-size:.9rem;">
                    <thead>
                        <tr>
                            <th>Produs</th>
                            <th>m²</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td data-label="m²"><?= htmlspecialchars($item['quantity_m2']) ?></td>
                                <td data-label="Total"><?= number_format($item['quantity_m2'] * $item['price_per_m2'], 2, ',', '.') ?> lei</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart-total-row" style="margin-top:1rem;">
                    <span>Total</span>
                    <span><?= number_format($total, 2, ',', '.') ?> RON</span>
                </div>

                <div class="checkout-trust">
                    <svg viewBox="0 0 24 24" fill="none" width="16" height="16" style="flex-shrink:0;">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Plată securizată prin Stripe. Datele cardului nu sunt stocate.</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
(function () {
    var stripe   = Stripe('<?= htmlspecialchars($stripePublishableKey) ?>');
    var elements;
    var paymentElement;

    var form       = document.getElementById('checkout-form');
    var submitBtn  = document.getElementById('submit-btn');
    var submitText = document.getElementById('submit-text');
    var submitSpin = document.getElementById('submit-spinner');
    var errBox     = document.getElementById('card-errors');

    function showError(msg) {
        errBox.textContent = msg;
        submitBtn.disabled = false;
        submitText.style.display = '';
        submitSpin.style.display = 'none';
    }

    function setLoading(on) {
        submitBtn.disabled = on;
        submitText.style.display = on ? 'none' : '';
        submitSpin.style.display = on ? '' : 'none';
    }

    // Create PaymentIntent and mount Elements
    fetch('<?= BASE_URL ?>stripe/create-intent', { method: 'POST' })
        .then(function(r){ return r.json(); })
        .then(function(data) {
            if (data.error) { showError(data.error); return; }

            elements = stripe.elements({ clientSecret: data.client_secret });
            paymentElement = elements.create('payment', { layout: 'tabs' });
            paymentElement.mount('#payment-element');
        })
        .catch(function() { showError('Nu am putut inițializa plata. Reîncărcați pagina.'); });

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (!elements) return;

        errBox.textContent = '';
        setLoading(true);

        // Validate required fields
        var name    = form.customer_name.value.trim();
        var email   = form.customer_email.value.trim();
        var phone   = form.customer_phone.value.trim();
        var city    = form.customer_city.value.trim();

        if (!name || !email || !phone || !city) {
            showError('Completați toate câmpurile obligatorii (*).');
            return;
        }

        // Confirm payment
        var result = await stripe.confirmPayment({
            elements: elements,
            confirmParams: { return_url: window.location.href },
            redirect: 'if_required',
        });

        if (result.error) {
            showError(result.error.message);
            return;
        }

        var paymentIntent = result.paymentIntent;
        if (!paymentIntent || paymentIntent.status !== 'succeeded') {
            showError('Plata nu a fost confirmată. Încercați din nou.');
            return;
        }

        // Create order
        var fd = new FormData(form);
        fd.append('payment_intent_id', paymentIntent.id);

        fetch('<?= BASE_URL ?>stripe/create-order', { method: 'POST', body: fd })
            .then(function(r){ return r.json(); })
            .then(function(data) {
                if (data.success) {
                    window.location.href = '<?= BASE_URL ?>confirmare/' + data.order_id;
                } else {
                    showError(data.error || 'Eroare la salvarea comenzii. Plata a fost procesată. Contactați-ne la 0745 990 503.');
                }
            })
            .catch(function() {
                showError('Eroare de rețea. Plata a fost procesată. Contactați-ne la 0745 990 503.');
            });
    });
})();
</script>

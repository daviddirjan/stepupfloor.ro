<?php

class CheckoutController
{
    public function checkout(): void
    {
        if (CartHelper::count() === 0) {
            header('Location: ' . BASE_URL . 'cos');
            exit;
        }

        $this->render('shop/checkout', [
            'pageTitle'            => 'Finalizare comandă',
            'items'                => CartHelper::getAll(),
            'total'                => CartHelper::total(),
            'stripePublishableKey' => SettingsModel::get('stripe_publishable_key'),
        ]);
    }

    public function confirmation(int $orderId): void
    {
        // Doar cumpărătorul care tocmai a plasat comanda (în această sesiune) o poate vedea.
        // Previne enumerarea /confirmare/{id} și expunerea datelor personale ale altor clienți.
        $recent = $_SESSION['recent_order_ids'] ?? [];
        if (!in_array($orderId, array_map('intval', $recent), true)) {
            http_response_code(404);
            echo '<h1>404 — Comanda nu a fost găsită</h1>';
            return;
        }

        $order = (new OrderModel())->findWithItems($orderId);
        if (!$order) {
            http_response_code(404);
            echo '<h1>404 — Comanda nu a fost găsită</h1>';
            return;
        }

        $this->render('shop/confirmation', [
            'pageTitle' => 'Comandă confirmată',
            'order'     => $order,
        ]);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $content = BASE_PATH . '/views/' . $view . '.php';
        require BASE_PATH . '/views/layouts/main.php';
    }
}

<?php

class StripeController
{
    public function dispatch(array $parts): void
    {
        $action = $parts[1] ?? '';
        match ($action) {
            'create-intent' => $this->createIntent(),
            'create-order'  => $this->createOrder(),
            'webhook'       => $this->webhook(),
            default         => (function () { http_response_code(404); })(),
        };
    }

    private function createIntent(): void
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'POST only']);
            return;
        }

        $amountBani = (int)(CartHelper::total() * 100);
        if ($amountBani < 100) {
            echo json_encode(['error' => 'Coșul este gol.']);
            return;
        }

        try {
            $intent = StripeClient::createPaymentIntent($amountBani, 'ron');
            echo json_encode(['client_secret' => $intent['client_secret']]);
        } catch (RuntimeException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    private function createOrder(): void
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'POST only']);
            return;
        }

        if (($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            echo json_encode(['error' => 'Token invalid.']);
            return;
        }

        $items = CartHelper::getAll();
        if (empty($items)) {
            echo json_encode(['error' => 'Coșul este gol.']);
            return;
        }

        $customerName = trim($_POST['customer_name'] ?? '');
        $customerEmail = trim($_POST['customer_email'] ?? '');
        $customerPhone = trim($_POST['customer_phone'] ?? '');

        if ($customerName === '' || $customerEmail === '' || $customerPhone === '') {
            echo json_encode(['error' => 'Completați toate câmpurile obligatorii.']);
            return;
        }

        $order = [
            'customer_name'            => $customerName,
            'customer_email'           => filter_var($customerEmail, FILTER_SANITIZE_EMAIL),
            'customer_phone'           => $customerPhone,
            'customer_address'         => trim($_POST['customer_address'] ?? ''),
            'customer_city'            => trim($_POST['customer_city'] ?? ''),
            'notes'                    => trim($_POST['notes'] ?? ''),
            'stripe_payment_intent_id' => trim($_POST['payment_intent_id'] ?? ''),
            'total'                    => CartHelper::total(),
            'status'                   => 'confirmed',
        ];

        $lineItems = [];
        foreach ($items as $item) {
            $lineItems[] = [
                'product_id'   => $item['product_id'],
                'product_name' => $item['name'],
                'product_slug' => $item['product_slug'],
                'area_m2'      => $item['quantity_m2'],
                'price_per_m2' => $item['price_per_m2'],
                'total_price'  => round($item['quantity_m2'] * $item['price_per_m2'], 2),
            ];
        }

        try {
            $orderId = (new OrderModel())->createWithItems($order, $lineItems);
            CartHelper::clear();
            echo json_encode(['success' => true, 'order_id' => $orderId]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Nu am putut salva comanda. Vă rugăm să ne contactați.']);
        }
    }

    private function webhook(): void
    {
        $payload   = file_get_contents('php://input');
        $sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

        try {
            $event = StripeClient::verifyWebhookSignature($payload, $sigHeader);
        } catch (RuntimeException $e) {
            http_response_code(400);
            exit;
        }

        if ($event['type'] === 'payment_intent.succeeded') {
            $intentId = $event['data']['object']['id'];
            $orderModel = new OrderModel();
            $order = $orderModel->findByPaymentIntent($intentId);
            if ($order && $order['status'] === 'pending') {
                $orderModel->updateStatus((int)$order['id'], 'confirmed');
            }
        }

        http_response_code(200);
        echo 'ok';
    }
}

<?php

class CartController
{
    public function dispatch(array $parts): void
    {
        $action = $parts[1] ?? '';
        match ($action) {
            'adauga' => $this->add(),
            'sterge' => $this->remove(),
            'update' => $this->update(),
            default  => $this->view(),
        };
    }

    private function view(): void
    {
        $this->render('shop/cart', [
            'pageTitle' => 'Coșul meu',
            'items'     => CartHelper::getAll(),
            'total'     => CartHelper::total(),
        ]);
    }

    private function add(): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $productId = (int)($_POST['product_id'] ?? 0);
        $areaM2    = max(0.1, (float)str_replace(',', '.', $_POST['area_m2'] ?? '1'));

        $product = (new ProductModel())->findById($productId);
        if (!$product || !$product['price_per_m2']) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Produsul nu este disponibil pentru comandă online.'];
            $this->redirect('magazin');
            return;
        }

        CartHelper::add(
            $productId,
            $product['slug'],
            $product['name'],
            $areaM2,
            (float)$product['price_per_m2'],
            $product['image'] ?? ''
        );

        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Produsul a fost adăugat în coș.'];

        $returnUrl = trim($_POST['return_url'] ?? '', '/');
        $this->redirect($returnUrl ?: 'cos');
    }

    private function remove(): void
    {
        $this->requirePost();
        $this->verifyCsrf();
        CartHelper::remove($_POST['item_key'] ?? '');
        $this->redirect('cos');
    }

    private function update(): void
    {
        $this->requirePost();
        $this->verifyCsrf();
        $items = $_POST['items'] ?? [];
        foreach ($items as $key => $val) {
            $area = (float)str_replace(',', '.', $val['area_m2'] ?? '0');
            CartHelper::update($key, $area);
        }
        $this->redirect('cos');
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('cos');
        }
    }

    private function verifyCsrf(): void
    {
        if (($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            echo 'Token invalid.';
            exit;
        }
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $content = BASE_PATH . '/views/' . $view . '.php';
        require BASE_PATH . '/views/layouts/main.php';
    }

    private function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . ltrim($path, '/'));
        exit;
    }
}

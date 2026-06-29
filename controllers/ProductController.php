<?php

class ProductController
{
    public function show(string $slug): void
    {
        $product = (new ProductModel())->findBySlug($slug);
        if (!$product) {
            http_response_code(404);
            echo '<h1>404 — Produsul nu a fost găsit</h1>';
            return;
        }

        $images   = (new ProductImageModel())->getByProductId((int)$product['id']);
        $category = $product['category_id']
            ? (new CategoryModel())->findById((int)$product['category_id'])
            : null;

        $this->render('shop/product', [
            'pageTitle' => $product['name'],
            'product'   => $product,
            'images'    => $images,
            'category'  => $category,
        ]);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $content = BASE_PATH . '/views/' . $view . '.php';
        require BASE_PATH . '/views/layouts/main.php';
    }
}

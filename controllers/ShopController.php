<?php

class ShopController
{
    public function index(): void
    {
        $categoryModel = new CategoryModel();
        $productModel  = new ProductModel();

        $categoryId = (int)($_GET['categorie'] ?? 0);
        $categories = $categoryModel->getAll();

        $filters = [
            'thickness' => array_filter((array)($_GET['grosime'] ?? [])),
            'color'     => array_filter((array)($_GET['culoare'] ?? [])),
            'price_min' => (float)str_replace(',', '.', $_GET['pret_min'] ?? '0'),
            'price_max' => (float)str_replace(',', '.', $_GET['pret_max'] ?? '0'),
        ];

        $products = $categoryId
            ? $productModel->getByCategory($categoryId, $filters)
            : $productModel->getAllForShop($filters);

        $this->render('shop/index', [
            'pageTitle'        => 'Magazin',
            'categories'       => $categories,
            'products'         => $products,
            'activeCategoryId' => $categoryId,
        ]);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $content = BASE_PATH . '/views/' . $view . '.php';
        require BASE_PATH . '/views/layouts/main.php';
    }
}

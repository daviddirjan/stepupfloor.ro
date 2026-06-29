<?php

class CategoryController
{
    public function show(string $slug): void
    {
        $categoryModel = new CategoryModel();
        $productModel  = new ProductModel();

        $category = $categoryModel->findBySlug($slug);
        if (!$category) {
            http_response_code(404);
            echo '<h1>404 — Categoria nu există</h1>';
            return;
        }

        $filters = [
            'thickness' => array_filter((array)($_GET['grosime'] ?? [])),
            'color'     => array_filter((array)($_GET['culoare'] ?? [])),
            'price_min' => (float)str_replace(',', '.', $_GET['pret_min'] ?? '0'),
            'price_max' => (float)str_replace(',', '.', $_GET['pret_max'] ?? '0'),
        ];

        $products    = $productModel->getByCategory((int)$category['id'], $filters);
        $thicknesses = $productModel->getDistinctThicknesses((int)$category['id']);
        $colors      = $productModel->getDistinctColors((int)$category['id']);

        $this->render('shop/category', [
            'pageTitle'   => $category['name'],
            'category'    => $category,
            'products'    => $products,
            'thicknesses' => $thicknesses,
            'colors'      => $colors,
            'filters'     => $filters,
        ]);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $content = BASE_PATH . '/views/' . $view . '.php';
        require BASE_PATH . '/views/layouts/main.php';
    }
}

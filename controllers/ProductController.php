<?php

class ProductController
{
    public function show(string $slug): void
    {
        $product = (new ProductModel())->findBySlug($slug);
        if (!$product) {
            (new ErrorController())->notFound();
            return;
        }

        $images        = (new ProductImageModel())->getByProductId((int)$product['id']);
        $colorVariants = !empty($product['is_variable'])
            ? (new ProductColorModel())->getByProductId((int)$product['id'])
            : [];
        $category      = $product['category_id']
            ? (new CategoryModel())->findById((int)$product['category_id'])
            : null;

        $this->render('shop/product', [
            'pageTitle'     => $product['name'],
            'product'       => $product,
            'images'        => $images,
            'colorVariants' => $colorVariants,
            'category'      => $category,
        ]);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $content = BASE_PATH . '/views/' . $view . '.php';
        require BASE_PATH . '/views/layouts/main.php';
    }
}

<?php

class HomeController
{
    private ServiceModel $serviceModel;
    private ProductModel $productModel;
    private TestimonialModel $testimonialModel;

    public function __construct()
    {
        $this->serviceModel     = new ServiceModel();
        $this->productModel     = new ProductModel();
        $this->testimonialModel = new TestimonialModel();
    }

    public function index(): void
    {
        $data = [
            'services'     => $this->serviceModel->getAll(),
            'products'     => $this->productModel->getGrid(4),
            'testimonials' => $this->testimonialModel->getAll(),
        ];

        $this->render('home/index', $data);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $content = BASE_PATH . '/views/' . $view . '.php';
        require BASE_PATH . '/views/layouts/main.php';
    }
}

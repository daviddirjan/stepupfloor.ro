<?php

class HomeController
{
    private ServiceModel $serviceModel;
    private ProductModel $productModel;
    private TestimonialModel $testimonialModel;
    private StatModel $statModel;

    public function __construct()
    {
        $this->serviceModel     = new ServiceModel();
        $this->productModel     = new ProductModel();
        $this->testimonialModel = new TestimonialModel();
        $this->statModel        = new StatModel();
    }

    public function index(): void
    {
        $data = [
            'stats'        => $this->statModel->getAll(),
            'services'     => $this->serviceModel->getAll(),
            'featured'     => $this->productModel->getFeatured(),
            'products'     => $this->productModel->getGrid(3),
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

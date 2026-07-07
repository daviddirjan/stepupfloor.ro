<?php

class ServiceController
{
    public function desprenoi(): void
    {
        $content = BASE_PATH . '/views/despre-noi/index.php';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function montaj(): void
    {
        $content = BASE_PATH . '/views/servicii/montaj.php';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function intretinere(): void
    {
        $content = BASE_PATH . '/views/servicii/intretinere.php';
        require BASE_PATH . '/views/layouts/main.php';
    }
}

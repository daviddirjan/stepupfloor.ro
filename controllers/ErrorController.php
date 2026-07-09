<?php

class ErrorController
{
    public function notFound(): void
    {
        http_response_code(404);
        $pageTitle = 'Pagina nu a fost găsită';
        $content   = BASE_PATH . '/views/errors/404.php';
        require BASE_PATH . '/views/layouts/main.php';
    }
}

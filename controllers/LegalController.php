<?php

class LegalController
{
    private const PAGES = [
        'politica-de-confidentialitate' => 'Politica de confidențialitate',
        'termeni-si-conditii'           => 'Termeni și condiții',
        'cookies'                       => 'Politica de cookies',
    ];

    public function show(string $slug): void
    {
        if (!isset(self::PAGES[$slug])) {
            http_response_code(404);
            echo '<h1>404 — Pagina nu a fost găsită</h1>';
            return;
        }

        $pageTitle = self::PAGES[$slug];
        $content   = BASE_PATH . '/views/legal/' . $slug . '.php';
        require BASE_PATH . '/views/layouts/main.php';
    }
}

<?php

class AdminDocsController
{
    public function index(): void
    {
        extract(['pageTitle' => 'Documentatie']);
        $content = BASE_PATH . '/views/admin/docs.php';
        require BASE_PATH . '/views/layouts/admin.php';
    }
}

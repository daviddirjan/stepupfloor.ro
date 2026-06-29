<?php

class AdminSettingsController
{
    public function index(): void
    {
        $this->render('admin/settings/index', [
            'pageTitle' => 'Setări',
            'settings'  => SettingsModel::getAll(),
        ]);
    }

    public function save(): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $allowed = [
            'stripe_publishable_key',
            'stripe_secret_key',
            'stripe_webhook_secret',
        ];

        foreach ($allowed as $key) {
            if (isset($_POST[$key])) {
                SettingsModel::set($key, trim($_POST[$key]));
            }
        }

        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Setările au fost salvate.'];
        $this->redirect('admin/settings');
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/settings');
        }
    }

    private function verifyCsrf(): void
    {
        if (($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            echo 'Token invalid.';
            exit;
        }
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $content = BASE_PATH . '/views/' . $view . '.php';
        require BASE_PATH . '/views/layouts/admin.php';
    }

    private function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . ltrim($path, '/'));
        exit;
    }
}

<?php

class AdminAuthController
{
    public function handleLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = trim($_POST['username'] ?? '');
            $pass = $_POST['password'] ?? '';

            if ($user === ADMIN_USER && password_verify($pass, ADMIN_PASS_HASH)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['csrf_token']      = bin2hex(random_bytes(32));
                header('Location: ' . BASE_URL . 'admin/dashboard');
                exit;
            }

            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Utilizator sau parolă incorectă.'];
        }

        require BASE_PATH . '/views/admin/login.php';
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: ' . BASE_URL . 'admin/login');
        exit;
    }
}

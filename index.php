<?php

define('BASE_PATH', __DIR__);
define('BASE_URL',  '/');   // subdomeniu: nou.stepupfloor.ro

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require BASE_PATH . '/config/database.php';
require BASE_PATH . '/config/admin.php';
require BASE_PATH . '/config/stripe.php';

// Auto-load classes from models/ and controllers/
spl_autoload_register(function (string $class): void {
    $dirs = [
        BASE_PATH . '/models/',
        BASE_PATH . '/controllers/',
        BASE_PATH . '/controllers/admin/',
    ];
    foreach ($dirs as $dir) {
        $file = $dir . $class . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

// Simple router
$url    = trim($_GET['url'] ?? '', '/');
$parts  = explode('/', $url);
$segment = $parts[0] ?? '';

// Track page views for public pages (skip admin and contact/submit)
if ($segment !== 'admin' && !($segment === 'contact' && ($parts[1] ?? '') === 'submit')) {
    if (empty($_SESSION['admin_logged_in'])) {
        try {
            $db  = Database::connection();
            $sid = $_SESSION['visitor_id'] ?? null;
            if (!$sid) {
                $sid = hash('sha256', uniqid('v', true) . random_bytes(8));
                $_SESSION['visitor_id'] = $sid;
            }
            $db->prepare('INSERT INTO page_views (session_id, url, ip_hash) VALUES (?, ?, ?)')
               ->execute([$sid, '/' . $url, hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? '') . ($_SERVER['HTTP_USER_AGENT'] ?? ''))]);
        } catch (Exception) { /* nu bloca pagina dacă tracking-ul pică */ }
    }
}

switch ($segment) {
    case 'contact':
        if (($parts[1] ?? '') === 'submit') {
            (new ContactController())->submit();
        } else {
            (new HomeController())->index();
        }
        break;

    case 'admin':
        $action = $parts[1] ?? 'dashboard';

        if ($action !== 'login' && empty($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASE_URL . 'admin/login');
            exit;
        }

        match ($action) {
            'login'        => (new AdminAuthController())->handleLogin(),
            'logout'       => (new AdminAuthController())->logout(),
            'dashboard'    => (new AdminDashboardController())->index(),
            'categories'   => (new AdminCategoryController())->dispatch($parts),
            'products'     => (new AdminProductController())->dispatch($parts),
            'blog'         => (new AdminBlogController())->dispatch($parts),
            'projects'     => (new AdminProjectController())->dispatch($parts),
            'testimonials' => (new AdminTestimonialController())->dispatch($parts),
            'contacts'     => (new AdminContactController())->dispatch($parts),
            'orders'       => (new AdminOrderController())->dispatch($parts),
            'settings'     => match ($parts[2] ?? 'index') {
                'save'  => (new AdminSettingsController())->save(),
                default => (new AdminSettingsController())->index(),
            },
            'docs'         => (new AdminDocsController())->index(),
            default        => (function () { http_response_code(404); echo '<h1>404</h1>'; })(),
        };
        break;

    case 'proiecte':
        (new ProjectController())->index();
        break;

    case 'magazin':
        (new ShopController())->index();
        break;

    case 'categorie':
        (new CategoryController())->show($parts[1] ?? '');
        break;

    case 'produs':
        (new ProductController())->show($parts[1] ?? '');
        break;

    case 'cos':
        (new CartController())->dispatch($parts);
        break;

    case 'checkout':
        (new CheckoutController())->checkout();
        break;

    case 'confirmare':
        (new CheckoutController())->confirmation((int)($parts[1] ?? 0));
        break;

    case 'stripe':
        (new StripeController())->dispatch($parts);
        break;

    case '':
    case 'acasa':
        (new HomeController())->index();
        break;

    default:
        http_response_code(404);
        echo '<h1>404 — Pagina nu a fost găsită</h1>';
        break;
}

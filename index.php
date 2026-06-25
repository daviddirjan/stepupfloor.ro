<?php

define('BASE_PATH', __DIR__);
define('BASE_URL',  '/');   // subdomeniu: nou.stepupfloor.ro

session_start();

require BASE_PATH . '/config/database.php';

// Auto-load classes from models/ and controllers/
spl_autoload_register(function (string $class): void {
    $dirs = [BASE_PATH . '/models/', BASE_PATH . '/controllers/'];
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

switch ($segment) {
    case 'contact':
        if (($parts[1] ?? '') === 'submit') {
            (new ContactController())->submit();
        } else {
            (new HomeController())->index();
        }
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

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — StepUp Floor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Lora:wght@400;600;700&family=DM+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/admin/admin.css">
</head>
<body class="admin-body">

<!-- Sidebar -->
<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <img src="<?= BASE_URL ?>assets/logo/stepupfloor-logo.png" alt="StepUp Floor">
    </div>

    <?php
    $currentUrl  = trim($_GET['url'] ?? '', '/');
    $unreadCount = (int) Database::connection()
        ->query('SELECT COUNT(*) FROM contact_submissions WHERE is_read = 0')
        ->fetchColumn();
    ?>

    <nav class="sidebar-nav">
        <div class="sidebar-section-label">General</div>

        <a href="<?= BASE_URL ?>admin/dashboard" class="<?= $currentUrl === 'admin/dashboard' || $currentUrl === 'admin' ? 'active' : '' ?>">
            <span class="nav-dot"></span>
            Dashboard
        </a>

        <div class="sidebar-section-label">Catalog</div>

        <a href="<?= BASE_URL ?>admin/categories" class="<?= str_starts_with($currentUrl, 'admin/categories') ? 'active' : '' ?>">
            <span class="nav-dot"></span>
            Categorii
        </a>
        <a href="<?= BASE_URL ?>admin/products" class="<?= str_starts_with($currentUrl, 'admin/products') ? 'active' : '' ?>">
            <span class="nav-dot"></span>
            Produse
        </a>
        <a href="<?= BASE_URL ?>admin/blog" class="<?= str_starts_with($currentUrl, 'admin/blog') ? 'active' : '' ?>">
            <span class="nav-dot"></span>
            Blog
        </a>
        <a href="<?= BASE_URL ?>admin/projects" class="<?= str_starts_with($currentUrl, 'admin/projects') ? 'active' : '' ?>">
            <span class="nav-dot"></span>
            Proiecte
        </a>

        <div class="sidebar-section-label">Clienți</div>

        <a href="<?= BASE_URL ?>admin/testimonials" class="<?= str_starts_with($currentUrl, 'admin/testimonials') ? 'active' : '' ?>">
            <span class="nav-dot"></span>
            Testimoniale
        </a>
        <a href="<?= BASE_URL ?>admin/contacts" class="<?= str_starts_with($currentUrl, 'admin/contacts') ? 'active' : '' ?>">
            <span class="nav-dot"></span>
            Contacte
            <?php if ($unreadCount > 0): ?>
                <span class="badge"><?= $unreadCount ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= BASE_URL ?>admin/orders" class="<?= str_starts_with($currentUrl, 'admin/orders') ? 'active' : '' ?>">
            <span class="nav-dot"></span>
            Comenzi
        </a>

        <div class="sidebar-section-label">Sistem</div>

        <a href="<?= BASE_URL ?>admin/settings" class="<?= str_starts_with($currentUrl, 'admin/settings') ? 'active' : '' ?>">
            <span class="nav-dot"></span>
            Setări
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= BASE_URL ?>">Mergi la site</a>
        <a href="<?= BASE_URL ?>admin/docs" class="<?= str_starts_with($currentUrl, 'admin/docs') ? 'active' : '' ?>">Documentatie</a>
        <a href="<?= BASE_URL ?>admin/logout">Deconectare</a>
    </div>
</aside>

<!-- Main content -->
<main class="admin-main">
    <div class="admin-topbar">
        <h1><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?></h1>
    </div>

    <div class="admin-content">
        <?php if (!empty($_SESSION['flash'])): ?>
            <?php $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
            <div class="flash flash-<?= htmlspecialchars($flash['type']) ?>">
                <?= htmlspecialchars($flash['msg']) ?>
            </div>
        <?php endif; ?>

        <?php require $content; ?>
    </div>
</main>

</body>
</html>

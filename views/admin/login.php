<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentificare — StepUp Floor Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Lora:wght@400;700&family=DM+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/admin/admin.css">
</head>
<body class="admin-login-page">

<div class="login-wrap">
    <div class="login-box">
        <div class="login-logo">
            <img src="<?= BASE_URL ?>assets/logo/stepupfloor-logo.png" alt="StepUp Floor">
        </div>
        <h1>Panou administrare</h1>

        <?php if (!empty($_SESSION['flash'])): ?>
            <?php $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
            <div class="flash flash-<?= htmlspecialchars($flash['type']) ?>" style="margin-bottom:1.25rem;">
                <?= htmlspecialchars($flash['msg']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>admin/login">
            <div class="form-group">
                <label for="username">Utilizator</label>
                <input type="text" id="username" name="username" required autofocus autocomplete="username">
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label for="password">Parolă</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-primary btn-full">Autentificare</button>
        </form>
    </div>
</div>

</body>
</html>

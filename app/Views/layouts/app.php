<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(config('name')) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= e(asset('css/app.css')) ?>">
</head>
<body>
    <div class="page-shell">
        <nav class="navbar navbar-expand-lg navbar-light kids-navbar">
            <div class="container py-2">
                <a class="navbar-brand brand-pill" href="<?= e(app_url()) ?>">Kids Platform</a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Abrir menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                        <li class="nav-item"><a class="nav-link" href="<?= e(app_url()) ?>">Inicio</a></li>
                        <?php if (is_authenticated()): ?>
                            <li class="nav-item"><a class="nav-link" href="<?= e(app_url('dashboard')) ?>">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= e(app_url('children')) ?>">Criancas</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= e(app_url('games')) ?>">Jogos</a></li>
                            <?php if (has_role(['admin', 'teacher'])): ?>
                                <li class="nav-item"><a class="nav-link" href="<?= e(app_url('admin')) ?>">Admin</a></li>
                            <?php endif; ?>
                            <li class="nav-item ms-lg-2"><a class="btn btn-bubble btn-bubble-secondary" href="<?= e(app_url('logout')) ?>">Sair</a></li>
                        <?php else: ?>
                            <li class="nav-item ms-lg-2"><a class="btn btn-bubble" href="<?= e(app_url('login')) ?>">Entrar</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container py-4 py-lg-5">
            <?php if ($message = flash('success')): ?>
                <div class="alert alert-success rounded-4 shadow-sm border-0"><?= e($message) ?></div>
            <?php endif; ?>

            <?php if ($message = flash('error')): ?>
                <div class="alert alert-danger rounded-4 shadow-sm border-0"><?= e($message) ?></div>
            <?php endif; ?>

            <?= $content ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>

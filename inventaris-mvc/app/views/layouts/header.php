<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Aplikasi Inventaris') ?> - <?= e(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <?php if ($loggedIn): ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
            <div class="container">
                <a class="navbar-brand fw-bold" href="<?= e(base_url()) ?>">📦 Inventaris MVC</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <?php foreach ($navItems as $key => $nav): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $current === $key ? 'active' : '' ?>"
                                    href="<?= e(base_url($nav['url'])) ?>">
                                    <?= e($nav['label']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <span class="navbar-text text-white-50 me-3">
                        Login sebagai:
                        <strong><?= e($user['full_name'] ?? $user['username'] ?? 'Pengguna') ?></strong>
                    </span>
                    <a class="btn btn-outline-light btn-sm" href="<?= e(base_url('auth/logout')) ?>">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </nav>
    <?php endif; ?>

    <main class="container mt-3">
        <?php if ($flash): ?>
            <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show shadow-sm" role="alert">
                <?= e($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

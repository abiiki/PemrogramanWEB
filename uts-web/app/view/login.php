<?php
$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$error = $error ?? null;
$username = $username ?? '';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $escape($title ?? 'Login') ?> - Perpustakaan</title>
    <style>
        * { box-sizing: border-box; }
        body { display: grid; min-height: 100vh; margin: 0; place-items: center; background: #f1f5f9; color: #1e293b; font-family: Arial, sans-serif; }
        main { width: min(100% - 32px, 400px); padding: 32px; border-radius: 12px; background: #fff; box-shadow: 0 12px 36px #0f172a14; }
        h1 { margin: 0 0 8px; }
        .subheading { margin: 0 0 24px; color: #64748b; }
        label { display: block; margin: 16px 0 6px; font-weight: 600; }
        input { width: 100%; padding: 11px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font: inherit; }
        button { width: 100%; margin-top: 22px; padding: 11px; border: 0; border-radius: 6px; background: #2457a7; color: #fff; cursor: pointer; font: inherit; font-weight: 600; }
        .error { padding: 12px; border-radius: 6px; background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <main>
        <h1>Perpustakaan</h1>
        <p class="subheading">Masuk untuk mengelola data buku.</p>

        <?php if ($error): ?>
            <p class="error" role="alert"><?= $escape($error) ?></p>
        <?php endif; ?>

        <form method="post" action="<?= $escape(BASEURL) ?>/login">
            <?= Security::csrfField() ?>
            <label for="username">Username</label>
            <input id="username" name="username" autocomplete="username" required value="<?= $escape($username) ?>">

            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>

            <button type="submit">Login</button>
        </form>
    </main>
</body>
</html>
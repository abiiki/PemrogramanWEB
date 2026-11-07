<?php
$book = $book ?? [];
$escape = static fn($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Edit Buku', ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f8;
            color: #202833;
        }

        main {
            max-width: 560px;
            margin: 40px auto;
            padding: 24px;
            background: #fff;
        }

        label {
            display: block;
            margin-top: 14px;
        }

        input {
            box-sizing: border-box;
            width: 100%;
            margin-top: 5px;
            padding: 9px;
        }

        button,
        .back {
            display: inline-block;
            margin-top: 18px;
            padding: 9px 13px;
            border: 0;
            border-radius: 4px;
            background: #2457a7;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            font: inherit;
        }

        .error {
            padding: 12px;
            background: #fdecec;
            color: #8d1710;
        }
    </style>
</head>

<body>
    <main>
        <h1><?= htmlspecialchars($title ?? 'Edit Buku', ENT_QUOTES, 'UTF-8') ?></h1>

        <?php if (!empty($errors)): ?>
            <div class="error" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= $escape(BASEURL) ?>/book/update/<?= (int) ($book['id'] ?? 0) ?>">
            <?= Security::csrfField() ?>
            <label for="code">Kode</label>
            <input id="code" name="code" maxlength="10" required
                value="<?= htmlspecialchars($book['code'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <label for="title">Judul</label>
            <input id="title" name="title" maxlength="150" required
                value="<?= htmlspecialchars($book['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <label for="author">Penulis</label>
            <input id="author" name="author" maxlength="100" required
                value="<?= htmlspecialchars($book['author'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <label for="published_year">Tahun terbit</label>
            <input id="published_year" name="published_year" type="number" min="1901" max="2155" required
                value="<?= htmlspecialchars($book['published_year'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <label for="stock">Stok</label>
            <input id="stock" name="stock" type="number" min="0" step="1" required
                value="<?= htmlspecialchars($book['stock'] ?? '0', ENT_QUOTES, 'UTF-8') ?>">

            <button type="submit">Perbarui</button>
        </form>

        <p><a class="back" href="<?= $escape(BASEURL) ?>/book">Kembali</a></p>
    </main>
</body>

</html>
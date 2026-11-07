<?php
$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$books = $books ?? [];
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $escape($title ?? 'Perpustakaan') ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f6f8; color: #202833; }
        main { max-width: 1000px; margin: 40px auto; padding: 24px; background: #fff; }
        header, .actions { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        a, button { display: inline-block; padding: 9px 13px; border: 0; border-radius: 4px; background: #2457a7; color: #fff; text-decoration: none; cursor: pointer; font: inherit; }
        .danger { background: #b42318; }
        .secondary { background: #556273; }
        .notice { margin: 16px 0; padding: 12px; background: #e8f4e8; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { padding: 11px; border: 1px solid #d6dbe1; text-align: left; }
        th { background: #edf1f5; }
        td form { display: inline; }
        @media (max-width: 700px) {
            main { margin: 16px; padding: 16px; overflow-x: auto; }
            table { min-width: 640px; }
        }
    </style>
</head>
<body>
    <main>
        <header>
            <h1><?= $escape($title ?? 'Daftar Buku') ?></h1>
            <div class="actions">
                <span>Halo, <?= $escape($_SESSION['user']['name'] ?? $_SESSION['user']['username'] ?? '') ?></span>
                <form method="post" action="<?= $escape(BASEURL) ?>/logout">
                    <?= Security::csrfField() ?>
                    <button class="secondary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <?php if (!empty($_SESSION['flash'])): ?>
            <p class="notice" role="status"><?= $escape($_SESSION['flash']['message'] ?? '') ?></p>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <p class="actions">
            <a href="<?= $escape(BASEURL) ?>/book/create">+ Tambah Buku</a>
            <a class="secondary" href="<?= $escape(BASEURL) ?>/book/trash">Sampah buku</a>
        </p>

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($books === []): ?>
                    <tr><td colspan="6">Belum ada data buku.</td></tr>
                <?php else: ?>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= $escape($book['code'] ?? '') ?></td>
                            <td><?= $escape($book['title'] ?? '') ?></td>
                            <td><?= $escape($book['author'] ?? '') ?></td>
                            <td><?= $escape($book['published_year'] ?? '') ?></td>
                            <td><?= $escape($book['stock'] ?? '') ?></td>
                            <td class="actions">
                                <a href="<?= $escape(BASEURL) ?>/book/edit/<?= (int) $book['id'] ?>">Ubah</a>
                                <form method="post"
                                      action="<?= $escape(BASEURL) ?>/book/destroy/<?= (int) $book['id'] ?>"
                                      onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                    <?= Security::csrfField() ?>
                                    <button class="danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>

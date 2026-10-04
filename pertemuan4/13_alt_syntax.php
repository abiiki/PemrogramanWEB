<?php
declare(strict_types=1);
$buah = ['Apel', 'Jeruk', 'Mangga'];
$stok = 3;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Sintaks Alternatif</title>
</head>

<body>
    <?php if ($stok > 0): ?>
        <p>Stok tersedia: <?= $stok ?></p>
    <?php else: ?>
        <p>Stok habis</p>
    <?php endif; ?>
    <ul>
        <?php foreach ($buah as $b): ?>
            <li><?= htmlspecialchars($b, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>
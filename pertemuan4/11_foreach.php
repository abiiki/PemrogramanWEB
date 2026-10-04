<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>foreach</title>
</head>

<body>
    <?php
    $buah = ['Apel', 'Jeruk', 'Mangga'];
    foreach ($buah as $b) {
        echo "- $b\n";
    }
    $ipk = ['Andi' => 3.8, 'Budi' => 3.2, 'Citra' => 2.9];
    foreach ($ipk as $nama => $nilai) {
        echo "$nama: $nilai\n";
    }
    // Menghitung total dengan foreach
    $total = 0;
    foreach ($ipk as $nilai) {
        $total += $nilai;
    }
    echo "Rata-rata IPK: " . number_format($total / count($ipk), 2) . "\n";
    ?>
</body>

</html>
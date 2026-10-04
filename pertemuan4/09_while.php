<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>while</title>
</head>

<body>
    <?php

    $i = 1;
    while ($i <= 5) {
        echo "i = $i\n";
        $i++;
    }
    // Menjumlahkan digit sebuah bilangan
    $n = 1234;
    $jumlah = 0;
    while ($n > 0) {
        $jumlah += $n % 10;
        $n = intdiv($n, 10);
    }
    echo "Jumlah digit 1234 = $jumlah\n";
    ?>

</body>

</html>
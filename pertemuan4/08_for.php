<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>for</title>
</head>

<body>
    <?php
    // Cetak 1..5
    for ($i = 1; $i <= 5; $i++) {
        echo "Iterasi ke-$i\n";
    }
    // Jumlah deret 1..100
    $total = 0;
    for ($i = 1; $i <= 100; $i++) {
        $total += $i;
    }
    echo "Jumlah 1..100 = $total\n";
    // Faktorial 5
    $faktorial = 1;
    for ($i = 1; $i <= 5; $i++) {
        $faktorial *= $i;
    }
    echo "5! = $faktorial\n";
    ?>


</body>

</html>
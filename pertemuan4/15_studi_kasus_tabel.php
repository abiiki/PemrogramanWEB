<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>studi kasus Tabel</title>
</head>

<body>

    <?php
    // perkalian 1..5
    echo "Tabel Perkalian\n";
    for ($i = 1; $i <= 5; $i++) {
        for ($j = 1; $j <= 5; $j++) {
            printf("%4d", $i * $j);
        }
        echo "\n";
    }
    // Faktorial berulang
    echo "\nFaktorial\n";
    for ($n = 1; $n <= 6; $n++) {
        $f = 1;
        for ($k = 1; $k <= $n; $k++) {
            $f *= $k;
        }
        echo "$n! = $f\n";
    }
    ?>

</body>

</html>
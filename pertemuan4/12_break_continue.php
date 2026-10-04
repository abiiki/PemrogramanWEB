<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>break continue</title>
</head>

<body>
    <?php
    // continue: lewati bilangan genap; break: berhenti setelah 7
    for ($i = 1; $i <= 10; $i++) {
        if ($i % 2 === 0) {
            continue;
        }
        if ($i > 7) {
            break;
        }
        echo "$i ";
    }
    echo "\n";
    // break 2: keluar dari dua tingkat loop bersarang
    for ($i = 1; $i <= 3; $i++) {
        for ($j = 1; $j <= 3; $j++) {
            if ($i * $j === 6) {
                echo "Ditemukan i=$i, j=$j\n";
                break 2;
            }
        }
    }
    ?>


</body>

</html>
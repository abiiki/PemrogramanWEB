<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>do while</title>
</head>

<body>

    <?php
    $i = 10;
    do {
        echo "Dijalankan sekali walau i = $i\n";
        $i++;
    } while ($i <= 5);

    $percobaan = 0;
    do {
        $percobaan++;
        $nilai = 30 + $percobaan * 20;
    } while ($nilai < 80);
    echo "Diperoleh nilai $nilai setelah $percobaan percobaan\n";
    ?>
</body>

</html>
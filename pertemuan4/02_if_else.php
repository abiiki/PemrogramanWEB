<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>if else</title>
</head>

<body>
    <?php
    $nilai = 68;
    if ($nilai >= 75) {
        echo "<p>Nilai $nilai: Status: lulus</p>";
    } else {
        echo "<p>Nilai $nilai: tidak lulus</p>";
    }

    $n = 17;
    if ($n % 2 === 0) {
        echo "<p>$n bilangan genap</p>";
    } else {
        echo "<p>$n bilangan ganjil</p>";
    }
    ?>

</body>

</html>
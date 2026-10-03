<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ternery</title>
</head>

<body>
    <?php
    $a = 10;
    $b = 20;
    $maks = $a > $b ? $a : $b;
    
    echo "Maksimum: $maks\n";
    $nilai = 80;
    $status = $nilai >= 75 ? 'LULUS' : 'TIDAK LULUS';
    echo "Status: $status\n";
    // Elvis vs null coalescing
    $input = "0";
    echo "Elvis ?: " . ($input ?: 'default') . "\n"; // default (karena "0" falsy)
    echo "Null ?? : " . ($input ?? 'default') . "\n"; // 0 (karena tidak null)
    $umur = $_GET['umur'] ?? 0;
    echo "Umur: $umur\n";
    ?>

</body>

</html>
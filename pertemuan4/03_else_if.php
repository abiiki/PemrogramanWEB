<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>else if</title>
</head>
<body>
    <?php
    $nilai = 82;
    
    if ($nilai >= 85) {
        $huruf = "A";
    } else if ($nilai >= 75) {
        $huruf = "B";
    } else if ($nilai >= 65) {
        $huruf = "C";
    } else if ($nilai >= 50) {
        $huruf = "D"; 
    } else {
        $huruf = "E";
    }
    echo "<p>Nilai $nilai: Huruf Mutu: $huruf</p>";
 
    ?>
    
</body>
</html>
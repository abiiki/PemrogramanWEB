<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>switch</title>
</head>
<body>
    <?php
    $pilihan = 2;
    switch ($pilihan) {
        case 1:
            echo "<p>lihat saldo</p>";
            break;
        case 2:
            echo "<p>transfer dana</p>";
            break;
        case 3:
            echo "<p>bayar tagihan</p>";
            break;
        default:
            echo "<p>Pilihan tidak valid</p>";
    }

    //atau fall trough yang disengaja
    $jawab = 'y';
    switch ($jawab) {
        case 'y':
        case 'Y':
            echo "<p>Anda memilih YA</p>";
            break;
        case 'n':
        case 'N':
            echo "<p>Anda memilih TIDAK</p>";
            break;
        default:
            echo "<p>Pilihan tidak valid</p>";
    }
    ?>
    
</body>
</html>
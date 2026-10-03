<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nested if</title>
</head>
<body>
    <?php
    $sudahLogin = true;
    $peran = 'admin';

    if ($sudahLogin) {
        if ($peran === 'admin') {
            echo "<p>Selamat datang, Admin!, akses penuh.</p>";
        } else if ($peran === 'user') {
            echo "<p>Selamat datang, User!, akses terbatas.</p>";
        } else {
            echo "<p>Peran tidak dikenali.</p>";
        }
    } else {
        echo "<p>Silakan login terlebih dahulu.</p>";
    }

    //alternatif daftar dengan &&

    $terverifikasi = true;
    $saldo = 120000;
    if ($sudahLogin && $terverifikasi && $saldo >= 100000) {
        echo "<p>Transaksi Besar Diizinkan.</p>";
    } 

    ?>
    
</body>
</html>
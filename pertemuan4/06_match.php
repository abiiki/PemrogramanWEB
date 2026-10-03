<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>match</title>
</head>
<body>
    <?php
    $huruf = "B";
    $predikat = match($huruf){
        "A" => "istimewa",
        "B" => "Sangat Baik",
        "C" => "Baik",
        "D" => "Cukup",
        default => "Kurang"
    };
    echo "<p>Huruf $huruf -> $predikat</p>";

    //beberapa nilai bercabang
    $hari = "Minggu";
    $jenis = match ($hari){
        'Sabtu', 'Minggu' => "akhir pekan",
        default => "hari kerja"
    };
    echo "<p>Hari $hari -> $jenis</p>";

    //match menggunakan perbandingan ketat (===)
    $kode = 0;
    $hasil = match($kode){
        0 => "nol (integer)",
        '0' => "nol (string)",
        default => "lain"
    };
    echo "<p>Kode $kode -> $hasil</p>";
    ?>
    
</body>
</html>
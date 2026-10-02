<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Latihan Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        h1 {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .campus-logo {
            width: 64px;
            height: 64px;
            object-fit: contain;
            flex: 0 0 auto;
        }

        .card-header .card-title {
            margin: 0;
            font-size: 1.4rem;
        }

        .naruto-frame {
            width: 150px;
            height: 150px;
            margin: 1rem auto 0;
            border: 5px solid #f0a500;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php
    $color = "red";

    $judul = "Kartu Mahasiswa";
    $nama = "Rizqi Fauzan";
    $nim = "2441081";
    $jurusan = "Teknik Informatika";
    $angkatan = "2024";
    $status = "Aktif";

    ?>
    <div class="card mx-auto" style="width: 22rem; max-width: 100%;">
        <div class="card-header d-flex align-items-center justify-content-center gap-3">
            <img src="logokampus.jpg" class="campus-logo" alt="Logo kampus">
            <h1 class="card-title"><?php echo $judul; ?></h1>
        </div>
        <img src="naruto.webp" class="card-img-top naruto-frame" alt="Naruto">
        <div class="card-body">
            <table class="table table-sm table-striped align-middle mb-3">
                <tbody>
                    <tr>
                        <th scope="row">Nama</th>
                        <td><?php echo $nama; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">NIM</th>
                        <td><?php echo $nim; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Jurusan</th>
                        <td><?php echo $jurusan; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Angkatan</th>
                        <td><?php echo $angkatan; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td><?php echo $status; ?></td>
                    </tr>
                </tbody>
            </table>
            <a href="profil.html" class="btn btn-primary">Profil Web</a>
        </div>
    </div>

    <br>


</body>

</html>
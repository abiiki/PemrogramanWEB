<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="p-5 mb-4 bg-white rounded-3 shadow-sm border-0">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold text-primary">
            <i class="bi bi-box-seam"></i> Selamat Datang, <?= e($user['full_name'] ?? $user['username'] ?? 'Admin') ?>!
        </h1>
        <p class="col-md-8 fs-5 text-muted mt-2">
            Aplikasi Sistem Inventaris Barang berbasis arsitektur MVC murni (PHP & MySQL).
            Gunakan tombol di bawah untuk mengelola data master dengan cepat.
        </p>
        <hr class="my-4">
        <div class="d-flex flex-wrap gap-3">
            <a href="<?= BASEURL ?>/items" class="btn btn-primary btn-lg px-4">
                <i class="bi bi-box"></i> Kelola Barang
            </a>
            <a href="<?= BASEURL ?>/categories" class="btn btn-success btn-lg px-4">
                <i class="bi bi-tags"></i> Kelola Kategori
            </a>
            <a href="<?= BASEURL ?>/transactions" class="btn btn-outline-info btn-lg px-4">
                <i class="bi bi-clock-history"></i> Riwayat Transaksi
            </a>
        </div>
    </div>
</div>

<!-- Kartu Informasi / Statistik Singkat -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Jenis Barang</div>
                    <div class="fs-3 fw-bold text-primary"><?= e($totalItems ?? 0) ?></div>
                </div>
                <i class="bi bi-box text-primary fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Kategori</div>
                    <div class="fs-3 fw-bold text-success"><?= e($totalCategories ?? 0) ?></div>
                </div>
                <i class="bi bi-tags text-success fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Akumulasi Stok</div>
                    <div class="fs-3 fw-bold text-warning"><?= e($totalStock ?? 0) ?></div>
                </div>
                <i class="bi bi-stack text-warning fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="p-5 mb-4 bg-white rounded-3 shadow-sm border-0">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold text-primary">
            <i class="bi bi-box-seam"></i>
            Selamat Datang, <?= e($user['full_name'] ?? $user['username'] ?? 'Admin') ?>!
        </h1>
        <p class="col-md-8 fs-5 text-muted mt-2">
            Aplikasi Sistem Inventaris Barang berbasis arsitektur MVC murni (PHP &amp; MySQL).
            Gunakan tombol di bawah untuk mengelola data master dengan cepat.
        </p>
        <hr class="my-4">
        <div class="d-flex flex-wrap gap-3">
            <a href="<?= e(base_url('items')) ?>" class="btn btn-primary btn-lg px-4">
                <i class="bi bi-box"></i> Kelola Barang
            </a>
            <a href="<?= e(base_url('categories')) ?>" class="btn btn-success btn-lg px-4">
                <i class="bi bi-tags"></i> Kelola Kategori
            </a>
            <a href="<?= e(base_url('transactions')) ?>" class="btn btn-outline-info btn-lg px-4">
                <i class="bi bi-clock-history"></i> Riwayat Transaksi
            </a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Jenis Barang</div>
                    <div class="fs-3 fw-bold text-primary"><?= e($totalItems) ?></div>
                </div>
                <i class="bi bi-box text-primary fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Kategori</div>
                    <div class="fs-3 fw-bold text-success"><?= e($totalCategories) ?></div>
                </div>
                <i class="bi bi-tags text-success fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Akumulasi Stok</div>
                    <div class="fs-3 fw-bold text-warning"><?= e($totalStock) ?></div>
                </div>
                <i class="bi bi-stack text-warning fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Nilai Aset</div>
                    <div class="fs-5 fw-bold text-danger"><?= e(rupiah($totalAssetValue)) ?></div>
                </div>
                <i class="bi bi-cash-coin text-danger fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="bi bi-exclamation-triangle text-warning"></i> Stok Menipis (≤ 5)
                </h5>
                <span class="badge bg-warning text-dark"><?= e($lowStockCount) ?></span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th class="text-center">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($lowStockItems)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Semua stok barang masih aman.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($lowStockItems as $row): ?>
                                <tr>
                                    <td><code><?= e($row['code']) ?></code></td>
                                    <td><?= e($row['name']) ?></td>
                                    <td><?= e($row['category_name'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-danger rounded-pill"><?= e($row['quantity']) ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white text-end">
                <a href="<?= e(base_url('items')) ?>" class="btn btn-sm btn-outline-primary">Kelola Barang</a>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="bi bi-clock-history text-info"></i> Transaksi Terbaru
                </h5>
                <span class="badge bg-info text-dark">Hari ini: <?= e($todayTransactions) ?></span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>Barang</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentTransactions)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Belum ada riwayat transaksi.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentTransactions as $row): ?>
                                <tr>
                                    <td class="text-muted small"><?= e(date('d/m H:i', strtotime($row['created_at']))) ?></td>
                                    <td>
                                        <strong><?= e($row['item_code']) ?></strong>
                                        <?= e($row['item_name']) ?>
                                    </td>
                                    <td>
                                        <?php if ($row['type'] === 'IN'): ?>
                                            <span class="badge bg-success">Masuk</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Keluar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-bold <?= $row['type'] === 'IN' ? 'text-success' : 'text-danger' ?>">
                                        <?= $row['type'] === 'IN' ? '+' : '-' ?><?= e($row['quantity']) ?>
                                    </td>
                                    <td><?= e($row['user_name']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white text-end">
                <a href="<?= e(base_url('transactions')) ?>" class="btn btn-sm btn-outline-info">Lihat Semua</a>
            </div>
        </div>
    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>

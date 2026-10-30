<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 fw-bold">Riwayat Transaksi</h3>
        <small class="text-muted">Catatan barang masuk & keluar</small>
    </div>
    <a href="<?= BASEURL ?>/items" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Barang
    </a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form method="get" action="<?= BASEURL ?>/transactions" class="d-flex align-items-center gap-2">
                <label class="mb-0 text-muted">Tampilkan:</label>
                <select name="limit" class="form-select form-select-sm" style="width:auto"
                    onchange="this.form.submit()">
                    <?php foreach ([5, 10, 20, 50, 100] as $opt): ?>
                        <option value="<?= $opt ?>" <?= $currentLimit === $opt ? 'selected' : '' ?>>
                            <?= $opt ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="text-muted">per halaman</span>
            </form>
            <?php if ($transactions['total_data'] > 0): ?>
                <span class="text-muted small">
                    Total
                    <?= e($transactions['total_data']) ?> transaksi
                </span>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Tipe</th>
                        <th class="text-center">Qty</th>
                        <th>User</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions['data'])): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada riwayat transaksi.</td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $no = ($transactions['current_page'] - 1) * $currentLimit + 1;
                        foreach ($transactions['data'] as $trx): ?>
                            <tr>
                                <td>
                                    <?= $no++ ?>
                                </td>
                                <td>
                                    <?= e(date('d/m/Y H:i', strtotime($trx['created_at']))) ?>
                                </td>
                                <td><code><?= e($trx['item_code'] ?? '-') ?></code></td>
                                <td>
                                    <?= e($trx['item_name'] ?? '-') ?>
                                </td>
                                <td>
                                    <?php if ($trx['type'] === 'IN'): ?>
                                        <span class="badge bg-success"><i class="bi bi-box-arrow-in-down"></i>
                                            Masuk</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="bi bi-box-arrow-up"></i> Keluar</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?= e($trx['quantity']) ?>
                                </td>
                                <td>
                                    <?= e($trx['user_name'] ?? '-') ?>
                                </td>
                                <td class="text-muted">
                                    <?= e($trx['notes'] ?? '-') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if ($transactions['total_pages'] > 1):
            $q = ['limit' => $currentLimit];
            ?>
            <nav class="mt-3">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item <?= $transactions['current_page'] <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query($q + ['page' =>
                            $transactions['current_page'] - 1]) ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $transactions['total_pages']; $i++): ?>
                        <li class="page-item <?= $i === $transactions['current_page'] ? 'active' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query($q + ['page' => $i]) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $transactions['current_page'] >= $transactions['total_pages'] ?
                        'disabled' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query($q + ['page' =>
                            $transactions['current_page'] + 1]) ?>">Next</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 fw-bold">Data Barang</h3>
        <small class="text-muted">Kelola seluruh data inventaris barang</small>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASEURL ?>/transactions" class="btn btn-outline-info">
            <i class="bi bi-clock-history"></i> Riwayat
        </a>
        <a href="<?= BASEURL ?>/items/create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Barang
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= BASEURL ?>/items" method="get" class="row g-2 mb-3">
            <div class="col-sm-5 col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari kode / nama / kategori..."
                    value="<?= e($search) ?>">
            </div>
            <div class="col-sm-4 col-md-3">
                <select name="category" class="form-select">
                    <option value="">- Semua Kategori -</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= e($c['id']) ?>" <?= (string) $category === (string) $c['id'] ? 'selected' : '' ?>>
                            <?= e($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="limit" value="<?= e($currentLimit) ?>">
            <div class="col-auto">
                <button class="btn btn-outline-primary"><i class="bi bi-search"></i> Cari</button>
                <?php if ($search !== '' || $category !== ''): ?>
                    <a href="<?= BASEURL ?>/items" class="btn btn-outline-secondary">Reset</a>
                <?php endif; ?>
            </div>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <form method="get" action="<?= BASEURL ?>/items" class="d-flex align-items-center gap-2">
                <input type="hidden" name="search" value="<?= e($search) ?>">
                <input type="hidden" name="category" value="<?= e($category) ?>">
                <label class="mb-0 text-muted small">Tampilkan: </label>
                <select name="limit" class="form-select form-select-sm" style="width:auto"
                    onchange="this.form.submit()">
                    <?php foreach ([5, 10, 20, 50, 100] as $opt): ?>
                        <option value="<?= $opt ?>" <?= $currentLimit === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="text-muted small">per halaman</span>
            </form>

            <?php if ($items['total_data'] > 0): ?>
                <?php
                $start = ($items['current_page'] - 1) * $currentLimit + 1;
                $end = $start + count($items['data']) - 1;
                ?>
                <span class="text-muted small">Menampilkan <?= $start ?>-<?= $end ?> dari <?= e($items['total_data']) ?>
                    barang</span>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th class="text-center">Stok</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center" style="width:190px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($items['data'])): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data barang.</td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $no = ($items['current_page'] - 1) * $currentLimit + 1;
                        foreach ($items['data'] as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><code><?= e($row['code']) ?></code></td>
                                <td><?= e($row['name']) ?></td>
                                <td><?= e($row['category_name'] ?? '-') ?></td>
                                <td class="text-center">
                                    <?= e($row['quantity']) ?>         <?= e($row['unit']) ?>
                                    <?php if ((int) $row['quantity'] <= 5): ?>
                                        <span class="badge bg-danger ms-1">!</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end"><?= rupiah($row['price']) ?></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-success" title="Barang Masuk"
                                            data-bs-toggle="modal" data-bs-target="#stockInModal"
                                            onclick='setStockItem(<?= json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                            <i class="bi bi-box-arrow-in-down"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" title="Barang Keluar"
                                            data-bs-toggle="modal" data-bs-target="#stockOutModal"
                                            onclick='setStockItem(<?= json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                            <i class="bi bi-box-arrow-up"></i>
                                        </button>
                                        <a href="<?= BASEURL ?>/items/edit/<?= e($row['id']) ?>" class="btn btn-outline-warning"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?= BASEURL ?>/items/delete/<?= e($row['id']) ?>" method="post"
                                            class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
                                            <button class="btn btn-outline-secondary" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($items['total_pages'] > 1):
            $q = ['search' => $search, 'category' => $category, 'limit' => $currentLimit];
            ?>
            <nav class="mt-3">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item <?= $items['current_page'] <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link"
                            href="?<?= http_build_query($q + ['page' => $items['current_page'] - 1]) ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $items['total_pages']; $i++): ?>
                        <li class="page-item <?= $i === $items['current_page'] ? 'active' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query($q + ['page' => $i]) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $items['current_page'] >= $items['total_pages'] ? 'disabled' : '' ?>">
                        <a class="page-link"
                            href="?<?= http_build_query($q + ['page' => $items['current_page'] + 1]) ?>">Next</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: Barang Masuk -->
<div class="modal fade" id="stockInModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= BASEURL ?>/transactions/stockin" method="post">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-box-arrow-in-down"></i> Barang Masuk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="item_id" id="in_item_id">
                    <p class="mb-1"><strong>Barang:</strong> <span id="in_item_name"></span></p>
                    <p class="mb-3"><strong>Stok Saat Ini:</strong> <span class="badge bg-secondary"
                            id="in_current"></span></p>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Masuk</label>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (opsional)</label>
                        <input type="text" name="notes" class="form-control"
                            placeholder="Contoh: Restock dari supplier">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Barang Keluar -->
<div class="modal fade" id="stockOutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= BASEURL ?>/transactions/stockOut" method="post">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-box-arrow-up"></i> Barang Keluar</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="item_id" id="out_item_id">
                    <p class="mb-1"><strong>Barang:</strong> <span id="out_item_name"></span></p>
                    <p class="mb-3"><strong>Stok Saat Ini:</strong> <span class="badge bg-secondary"
                            id="out_current"></span></p>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Keluar</label>
                        <input type="number" name="quantity" id="out_quantity" class="form-control" min="1" required>
                        <small class="text-muted">Tidak boleh melebihi stok saat ini.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (opsional)</label>
                        <input type="text" name="notes" class="form-control"
                            placeholder="Contoh: Penjualan ke customer X">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function setStockItem(item) {
        document.getElementById('in_item_id').value = item.id;
        document.getElementById('in_item_name').textContent = item.name;
        document.getElementById('in_current').textContent = item.quantity;
        document.getElementById('out_item_id').value = item.id;
        document.getElementById('out_item_name').textContent = item.name;
        document.getElementById('out_current').textContent = item.quantity;
        document.getElementById('out_quantity').max = item.quantity;
    }
</script>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
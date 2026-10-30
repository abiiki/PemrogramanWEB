<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 fw-bold">Data Pengguna</h3>
        <small class="text-muted">Daftar pengguna sistem</small>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data pengguna.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $i => $row): ?>
                            <?php $roleClass = $row['role'] === 'admin' ? 'primary' : ($row['role'] === 'manager' ? 'success' : 'secondary'); ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><code><?= e($row['username']) ?></code></td>
                                <td><?= e($row['full_name'] ?? '-') ?></td>
                                <td><span class="badge bg-<?= e($roleClass) ?>"><?= e($row['role']) ?></span></td>
                                <td><?= e(date('d/m/Y', strtotime($row['created_at']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>

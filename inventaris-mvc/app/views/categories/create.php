<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 fw-bold">Tambah Kategori</h3>
        <small class="text-muted">Masukkan data kategori baru</small>
    </div>
    <a href="<?= BASEURL ?>/categories" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= BASEURL ?>/categories/store" method="post">
            <?php require ROOT_PATH . '/app/views/categories/_form.php'; ?>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="<?= BASEURL ?>/categories" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
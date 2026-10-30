<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="text-center" style="margin-top: 10vh;">
    <h1 class="display-3 fw-bold text-danger">404</h1>
    <h4 class="mb-3">Halaman Tidak Ditemukan</h4>
    <p class="text-muted">
        Maaf, halaman <code><?= e($path ?? '') ?></code> tidak tersedia atau sudah dipindahkan.
    </p>
    <a href="<?= e(base_url()) ?>" class="btn btn-primary mt-2">
        <i class="bi bi-house"></i> Kembali ke Dashboard
    </a>
</div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>

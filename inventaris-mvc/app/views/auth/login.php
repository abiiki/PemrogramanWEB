<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="row justify-content-center" style="margin-top: 8vh;">
    <div class="col-md-5 col-lg-4">
        <div class="text-center mb-4">
            <i class="bi bi-box-seam text-primary" style="font-size: 3rem;"></i>
            <h3 class="fw-bold mt-2 mb-0"><?= e(APP_NAME) ?></h3>
            <small class="text-muted">Sistem Inventaris Barang</small>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-4 text-center">Login ke Akun Anda</h5>
                <form method="post" action="<?= e(base_url('auth/authenticate')) ?>">
                    <div class="mb-3">
                        <label class="form-label" for="username">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="username" id="username" class="form-control"
                                placeholder="Masukkan username" autocomplete="username" required autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Masukkan password" autocomplete="current-password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>
                <p class="text-muted small text-center mt-3 mb-0">Demo: admin / 123456</p>
            </div>
        </div>
    </div>
</div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>

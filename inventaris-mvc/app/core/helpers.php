<?php
function e($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
function rupiah($value): string {
    return 'Rp ' . number_format((float) $value, 0, ',', '.');
}
function base_url(string $path = ''): string {
    return BASEURL . '/' . ltrim($path, '/');
}
function take_flash(): ?array {
    if (empty($_SESSION['flash'])) {
        return null;
    }

    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $f;
}

function view_shared_data(): array {
    $current = strtolower(trim((string) ($_GET['url'] ?? ''), '/'));
    $current = explode('/', $current)[0] ?? '';

    return [
        'flash' => take_flash(),
        'loggedIn' => Middleware::isLoggedIn(),
        'user' => Middleware::user(),
        'current' => in_array($current, ['', 'dashboard'], true) ? 'home' : $current,
        'navItems' => [
            'home' => ['label' => 'Dashboard', 'url' => 'home'],
            'categories' => ['label' => 'Kategori', 'url' => 'categories'],
            'items' => ['label' => 'Barang', 'url' => 'items'],
            'transactions' => ['label' => 'Riwayat Transaksi', 'url' => 'transactions'],
            'users' => ['label' => 'Pengguna', 'url' => 'users'],
        ],
    ];
}

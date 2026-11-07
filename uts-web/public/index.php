<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/config/database.php';

spl_autoload_register(function ($class) {
    foreach (['core', 'controllers', 'models'] as $dir) {
        $file = ROOT_PATH . '/app/' . $dir . '/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once ROOT_PATH . '/app/core/Router.php';

ini_set('display_errors', APP_DEBUG ? '1' : '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Fallback jika rewrite .htaccess tidak tersedia (PHP built-in server),
// sekaligus menangani subfolder, mis. http://localhost/inventaris-mvc/public/.
if (!isset($_GET['url'])) {
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    if ($basePath !== '/' && $basePath !== '' && str_starts_with($uri, $basePath)) {
        $uri = substr($uri, strlen($basePath));
    }
    $_GET['url'] = trim((string) $uri, '/');
}
// Session dengan cookie aman + batas idle.
Security::startSession();

// Semua POST web wajib membawa token CSRF. (API dikecualikan)
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$route = strtolower(trim((string) ($_GET['url'] ?? ''), '/'));
if ($requestMethod === 'POST' && !($route === 'api' || str_starts_with($route, 'api/'))) {
    Security::requireCsrf();
}

// Jalankan router
$app = new App();

<?php

define('ROOT_PATH', dirname(__DIR__));

function loadEnv(string $file): void {
    if (!is_file($file) || !is_readable($file)) {
        return;
    }

    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$name, $value] = array_map('trim', explode('=', $line, 2));
        $value = trim($value, "\"'");
        $_ENV[$name] = $value;
        putenv($name . '=' . $value);
    }
}

loadEnv(ROOT_PATH . '/.env');

function env(string $key, mixed $default = null): mixed {
    $value = $_ENV[$key] ?? getenv($key);
    return ($value === false || $value === null || $value === '') ? $default : $value;
}

$baseUrl = env('BASE_URL');
if ($baseUrl === null) {
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $scriptDirectory = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $scriptDirectory = $scriptDirectory === '/' || $scriptDirectory === '.' ? '' : $scriptDirectory;
    $baseUrl = $scheme . '://' . $host . $scriptDirectory;
}

define('APP_NAME', env('APP_NAME', 'Library System'));
define('APP_ENV', env('APP_ENV', 'production'));
define('APP_DEBUG', filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN));
define('BASEURL', rtrim((string) $baseUrl, '/'));
date_default_timezone_set((string) env('APP_TIMEZONE', 'Asia/Jakarta'));
define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_PORT', (int) env('DB_PORT', 3306));
define('DB_USER', env('DB_USER', 'root'));
define('DB_PASS', env('DB_PASS', ''));
define('DB_NAME', env('DB_NAME', 'db_library'));
define('SESSION_IDLE_TIMEOUT', max(1, (int) env('SESSION_IDLE_TIMEOUT', 30)) * 60);

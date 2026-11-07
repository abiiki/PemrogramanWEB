<?php

class Security {
    public static function startSession(): void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        session_set_cookie_params([
            'httponly' => true,
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'samesite' => 'Lax',
            'path' => '/',
        ]);
        if (!session_start()) {
            throw new RuntimeException('Unable to start the application session.');
        }

        $lastActivity = $_SESSION['last_activity'] ?? time();
        if (time() - (int) $lastActivity > SESSION_IDLE_TIMEOUT) {
            $_SESSION = [];
            session_regenerate_id(true);
        }
        $_SESSION['last_activity'] = time();
    }

    public static function csrfField(): string {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }

        return '<input type="hidden" name="_csrf" value="' .
            htmlspecialchars($_SESSION['_csrf'], ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function requireCsrf(): void {
        $token = $_POST['_csrf'] ?? '';
        if (!is_string($token) || empty($_SESSION['_csrf']) ||
            !hash_equals($_SESSION['_csrf'], $token)) {
            http_response_code(419);
            echo '<!doctype html><html lang="id"><meta charset="utf-8"><title>Sesi berakhir</title>' .
                '<h1>Sesi tidak valid</h1><p>Muat ulang halaman lalu coba kembali.</p></html>';
            exit;
        }
    }
}

<?php

class Middleware {
    public static function isLoggedIn(): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['user']) && is_array($_SESSION['user'])
            && !empty($_SESSION['user']['id']);
    }

    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Silakan login terlebih dahulu.',
            ];
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    public static function user(): ?array {
        return self::isLoggedIn() ? $_SESSION['user'] : null;
    }
}

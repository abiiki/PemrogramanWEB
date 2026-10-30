<?php

class AuthController extends Controller {
    public function login(): void {
        if (Middleware::isLoggedIn()) {
            $this->redirect('');
        }

        $this->view('auth/login', ['title' => 'Login']);
    }

    public function authenticate(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/login');
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        if (!is_string($username) || !is_string($password)) {
            $this->flash('danger', 'Username atau password salah.');
            $this->redirect('auth/login');
        }

        $user = $this->model('User')->login(trim($username), $password);
        if (!$user) {
            $this->flash('danger', 'Username atau password salah.');
            $this->redirect('auth/login');
        }

        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        $this->flash('success', 'Selamat datang, ' . ($user['full_name'] ?: $user['username']) . '!');
        $this->redirect('');
    }

    public function logout(): void {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires' => time() - 42000,
                'path' => $params['path'],
                'domain' => $params['domain'],
                'secure' => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => $params['samesite'] ?? 'Lax',
            ]);
        }

        session_destroy();
        session_start();
        $this->flash('success', 'Anda berhasil logout.');
        $this->redirect('auth/login');
    }
}

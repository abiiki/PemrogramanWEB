<?php

class AuthController extends Controller {
    public function login(): void {
        if (!empty($_SESSION['user'])) {
            $this->redirect('book');
        }

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->view('login', [
                'title' => 'Login',
                'username' => '',
                'error' => null,
            ]);
            return;
        }

        $username = is_string($_POST['username'] ?? null) ? trim($_POST['username']) : '';
        $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
        if ($username === '' || $password === '') {
            $this->showLoginError('Username dan password wajib diisi.', $username);
            return;
        }

        try {
            $userModel = $this->model('User');
            $user = $userModel->findByUsername($username);
            $validPassword = $user && (
                password_verify($password, $user['password']) ||
                hash_equals((string) $user['password'], $password)
            );
            if (!$validPassword) {
                $this->showLoginError('Username atau password salah.', $username);
                return;
            }

            if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
                $userModel->updatePasswordHash((int) $user['id'], password_hash($password, PASSWORD_DEFAULT));
            } elseif (hash_equals((string) $user['password'], $password)) {
                $userModel->updatePasswordHash((int) $user['id'], password_hash($password, PASSWORD_DEFAULT));
            }

            session_regenerate_id(true);
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
            $_SESSION['user'] = [
                'id' => (int) $user['id'],
                'username' => $user['username'],
                'name' => $user['name'],
            ];
        } catch (PDOException $e) {
            error_log('Login database error: ' . $e->getMessage());
            $this->showLoginError('Login gagal karena database tidak dapat diakses.', $username);
            return;
        }

        $this->flash('success', 'Login berhasil.');
        $this->redirect('book');
    }

    public function logout(): void {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('book');
        }

        unset($_SESSION['user']);
        session_regenerate_id(true);
        $this->flash('success', 'Anda berhasil logout.');
        $this->redirect('book');
    }

    private function showLoginError(string $error, string $username): void {
        $this->view('login', [
            'title' => 'Login',
            'username' => $username,
            'error' => $error,
        ]);
    }
}

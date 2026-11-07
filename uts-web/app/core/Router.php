<?php

class App {
    public function __construct() {
        $this->dispatch();
    }

    private function dispatch(): void {
        $route = trim((string) ($_GET['url'] ?? ''), '/');
        $segments = $route === '' ? ['book'] : explode('/', $route);
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $section = strtolower($segments[0]);
        $action = strtolower($segments[1] ?? 'index');

        if ($section === 'login' && count($segments) === 1 && in_array($method, ['GET', 'POST'], true)) {
            (new AuthController())->login();
            return;
        }

        if ($section === 'logout' && count($segments) === 1 && $method === 'POST') {
            (new AuthController())->logout();
            return;
        }

        if (empty($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/login', true, 303);
            return;
        }

        if ($section !== 'book') {
            $this->notFound();
            return;
        }

        $controller = new BookController();
        if ($action === 'index' && count($segments) <= 2 && $method === 'GET') {
            $controller->index();
            return;
        }
        if ($action === 'create' && count($segments) === 2 && $method === 'GET') {
            $controller->create();
            return;
        }
        if ($action === 'store' && count($segments) === 2 && $method === 'POST') {
            $controller->store();
            return;
        }
        if ($action === 'trash' && count($segments) === 2 && $method === 'GET') {
            $controller->trash();
            return;
        }

        $id = $segments[2] ?? '';
        if (count($segments) === 3 && ctype_digit($id) && (int) $id > 0) {
            $id = (int) $id;
            if ($action === 'edit' && $method === 'GET') {
                $controller->edit($id);
                return;
            }
            if ($action === 'update' && $method === 'POST') {
                $controller->update($id);
                return;
            }
            if ($action === 'destroy' && $method === 'POST') {
                $controller->destroy($id);
                return;
            }
            if ($action === 'restore' && $method === 'POST') {
                $controller->restore($id);
                return;
            }
        }

        $this->notFound();
    }

    private function notFound(): void {
        http_response_code(404);
        echo '<!doctype html><html lang="id"><meta charset="utf-8"><title>Halaman tidak ditemukan</title>' .
            '<h1>Halaman tidak ditemukan</h1><p><a href="' . htmlspecialchars(BASEURL, ENT_QUOTES, 'UTF-8') .
            '/book">Kembali ke daftar buku</a></p></html>';
    }
}

<?php

class Controller {
    protected function view(string $view, array $data = []): void {
        $file = ROOT_PATH . '/app/view/' . $view . '.php';
        if (!is_file($file)) {
            throw new RuntimeException('View not found: ' . $view);
        }

        extract($data, EXTR_SKIP);
        require $file;
    }

    protected function model(string $model): object {
        if (!class_exists($model)) {
            throw new RuntimeException('Model not found: ' . $model);
        }

        return new $model();
    }

    protected function input(): array {
        return $_POST;
    }

    protected function redirect(string $path): never {
        header('Location: ' . BASEURL . '/' . ltrim($path, '/'), true, 303);
        exit;
    }

    protected function flash(string $type, string $message): void {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}

<?php
class Controller {
    public function view(string $view, array $data = []): void {
        extract($data);
        require ROOT_PATH . '/app/views/' . $view . '.php';
    }
    public function model(string $model) { 
        return new $model(); 
    }
    
    public function redirect(string $path): void {
        header('Location: ' . BASEURL . '/' . ltrim($path, '/'));
        exit;
    }
    
    public function flash(string $type, string $message): void {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}
<?php

class UsersController extends Controller {
    public function __construct() {
        $this->requireLogin();
    }

    public function index(): void {
        $this->view('users/index', [
            'title' => 'Data Pengguna',
            'users' => $this->model('User')->all(),
        ]);
    }
}

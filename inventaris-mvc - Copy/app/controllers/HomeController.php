<?php
class HomeController extends Controller {
    public function index(): void {
        $this->view('dashboard/index', ['title' => 'Dashboard']);
    }
}

<?php
class CategoriesController extends Controller {

    public function index(): void {
        $this->view('categories/index', [
            'title' => 'Data Kategori',
            'categories' => $this->model('Category')->all(),
        ]);
    }
    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            $this->redirect('categories');
        $input = array_map('trim', $_POST);
        if (empty($input['name'])) {
            $this->flash('danger', 'Nama kategori wajib diisi.');
            $this->redirect('categories/create');
        }
        $this->model('Category')->create([
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);
        $this->flash('success', 'Kategori berhasil ditambahkan.');
        $this->redirect('categories');
    }

}

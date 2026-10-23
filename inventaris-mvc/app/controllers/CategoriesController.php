<?php

class CategoriesController extends Controller {

    public function index(): void {
        $this->view('categories/index', [
            'title' => 'Data Kategori',
            'categories' => $this->model('Category')->all(),
        ]);
    }

    public function create(): void {
        $this->view('categories/create', [
            'title' => 'Tambah Kategori'
        ]);
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

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

    public function edit(int $id): void {
        $category = $this->model('Category')->find($id);
        if (!$category) {
            $this->flash('danger', 'Kategori tidak ditemukan.');
            $this->redirect('categories');
        }

        $this->view('categories/edit', [
            'title' => 'Edit Kategori',
            'category' => $category
        ]);
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $input = array_map('trim', $_POST);

        if (empty($input['name'])) {
            $this->flash('danger', 'Nama kategori wajib diisi.');
            $this->redirect('categories/edit/' . $id);
        }

        $this->model('Category')->update($id, [
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);

        $this->flash('success', 'Kategori berhasil diperbarui.');
        $this->redirect('categories');
    }

    public function delete(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categories');
        }

        $this->model('Category')->delete($id);
        $this->flash('success', 'Kategori berhasil dihapus.');
        $this->redirect('categories');
    }
}
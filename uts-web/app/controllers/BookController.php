<?php

class BookController extends Controller {
    public function index(): void {
        $this->view('book/index', [
            'title' => 'Daftar Buku',
            'books' => $this->model('Book')->all(),
        ]);
    }

    public function trash(): void {
        $this->view('book/trash', [
            'title' => 'Sampah Buku',
            'books' => $this->model('Book')->trashed(),
        ]);
    }

    public function restore(int $id): void {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('book/trash');
        }

        if (!$this->model('Book')->restore($id)) {
            $this->flash('danger', 'Buku tidak ditemukan di sampah atau gagal dipulihkan.');
            $this->redirect('book/trash');
        }

        $this->flash('success', 'Buku berhasil dipulihkan.');
        $this->redirect('book');
    }

    public function create(): void {
        $this->view('book/create', [
            'title' => 'Tambah Buku',
            'book' => [
                'code' => '',
                'title' => '',
                'author' => '',
                'published_year' => (string) date('Y'),
                'stock' => '0',
            ],
            'errors' => [],
        ]);
    }

    public function store(): void {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('book');
        }

        $book = $this->input();
        $data = $this->validatedBook($book);
        $errors = $this->validateBook($data);

        if ($errors !== []) {
            $this->view('book/create', [
                'title' => 'Tambah Buku',
                'book' => $data,
                'errors' => $errors,
            ]);
            return;
        }

        try {
            if (!$this->model('Book')->create($data)) {
                $this->view('book/create', [
                    'title' => 'Tambah Buku',
                    'book' => $data,
                    'errors' => ['Buku gagal disimpan. Silakan coba kembali.'],
                ]);
                return;
            }
        } catch (PDOException $e) {
            $this->view('book/create', [
                'title' => 'Tambah Buku',
                'book' => $data,
                'errors' => [$this->saveError($e)],
            ]);
            return;
        }

        $this->flash('success', 'Buku berhasil ditambahkan.');
        $this->redirect('book');
    }

    public function edit(int $id): void {
        $book = $this->model('Book')->find($id);
        if (!$book) {
            $this->flash('danger', 'Buku tidak ditemukan.');
            $this->redirect('book');
        }

        $this->view('book/edit', [
            'title' => 'Edit Buku',
            'book' => $book,
            'errors' => [],
        ]);
    }

    public function update(int $id): void {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('book');
        }

        $book = $this->validatedBook($this->input());
        $errors = $this->validateBook($book);
        $book['id'] = $id;

        if ($errors !== []) {
            $this->view('book/edit', [
                'title' => 'Edit Buku',
                'book' => $book,
                'errors' => $errors,
            ]);
            return;
        }

        $bookModel = $this->model('Book');
        try {
            if (!$bookModel->find($id)) {
                $this->flash('danger', 'Buku tidak ditemukan.');
                $this->redirect('book');
            }
            if (!$bookModel->update($id, $book)) {
                $this->view('book/edit', [
                    'title' => 'Edit Buku',
                    'book' => $book,
                    'errors' => ['Buku gagal diperbarui. Silakan coba kembali.'],
                ]);
                return;
            }
        } catch (PDOException $e) {
            $this->view('book/edit', [
                'title' => 'Edit Buku',
                'book' => $book,
                'errors' => [$this->saveError($e)],
            ]);
            return;
        }

        $this->flash('success', 'Buku berhasil diperbarui.');
        $this->redirect('book');
    }

    public function destroy(int $id): void {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('book');
        }

        try {
            if (!$this->model('Book')->destroy($id)) {
                $this->flash('danger', 'Buku tidak ditemukan atau gagal dihapus.');
                $this->redirect('book');
            }
        } catch (PDOException $e) {
            $this->flash('danger', 'Buku gagal dihapus.');
            $this->redirect('book');
        }

        $this->flash('success', 'Buku berhasil dihapus.');
        $this->redirect('book');
    }

    private function validatedBook(array $input): array {
        return [
            'code' => is_string($input['code'] ?? null) ? trim($input['code']) : '',
            'title' => is_string($input['title'] ?? null) ? trim($input['title']) : '',
            'author' => is_string($input['author'] ?? null) ? trim($input['author']) : '',
            'published_year' => is_string($input['published_year'] ?? null)
                ? trim($input['published_year'])
                : '',
            'stock' => is_string($input['stock'] ?? null) ? trim($input['stock']) : '',
        ];
    }

    private function validateBook(array $book): array {
        $errors = [];

        foreach (['code' => 'Kode', 'title' => 'Judul', 'author' => 'Penulis'] as $field => $label) {
            if ($book[$field] === '') {
                $errors[] = $label . ' wajib diisi.';
            }
        }

        if ($book['published_year'] === '' || !ctype_digit($book['published_year'])
            || (int) $book['published_year'] < 1901 || (int) $book['published_year'] > 2155) {
            $errors[] = 'Tahun terbit wajib berupa tahun antara 1901 dan 2155.';
        }

        if ($book['stock'] === '' || !ctype_digit($book['stock'])
            || (float) $book['stock'] > 2147483647) {
            $errors[] = 'Stok wajib berupa bilangan bulat nonnegatif.';
        }

        return $errors;
    }

    private function saveError(PDOException $e): string {
        if ($e->getCode() === '23000') {
            return 'Buku gagal disimpan. Pastikan kode buku belum digunakan.';
        }

        return 'Buku gagal disimpan karena terjadi kesalahan database.';
    }
}

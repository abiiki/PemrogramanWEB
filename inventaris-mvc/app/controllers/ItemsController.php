<?php

class ItemsController extends Controller {

    public function __construct() {
        $this->requireLogin();
    }

    public function index(): void {
        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';
        $search = is_string($search) ? trim($search) : '';
        $category = is_string($category) && ctype_digit($category) ? $category : '';
        $allowedLimits = [5, 10, 20, 50, 100];
        $requestedLimit = filter_var($_GET['limit'] ?? 10, FILTER_VALIDATE_INT);
        $limit = in_array($requestedLimit, $allowedLimits, true) ? $requestedLimit : 10;
        $requestedPage = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
        $page = $requestedPage !== false && $requestedPage > 0 ? $requestedPage : 1;

        $items = $this->model('Item')->paginate($limit, $page, $search, $category);
        $categories = $this->model('Category')->all();

        $this->view('items/index', [
            'title' => 'Data Barang',
            'items' => $items,
            'categories' => $categories,
            'search' => $search,
            'category' => $category,
            'currentLimit' => $limit
        ]);
    }

    public function create(): void {
        $categories = $this->model('Category')->all();
        $generatedCode = $this->model('Item')->generateCode();

        $this->view('items/create', [
            'title' => 'Tambah Barang',
            'categories' => $categories,
            'code' => $generatedCode
        ]);
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $input = array_map('trim', $_POST);

        if (empty($input['name'])) {
            $this->flash('danger', 'Nama barang wajib diisi.');
            $this->redirect('items/create');
        }

        $this->model('Item')->create($this->payload($input));
        $this->flash('success', 'Barang berhasil ditambahkan.');
        $this->redirect('items');
    }

    public function edit(int $id): void {
        $item = $this->model('Item')->find($id);
        if (!$item) {
            $this->flash('danger', 'Barang tidak ditemukan.');
            $this->redirect('items');
        }

        $categories = $this->model('Category')->all();

        $this->view('items/edit', [
            'title' => 'Edit Barang',
            'item' => $item,
            'categories' => $categories
        ]);
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $input = array_map('trim', $_POST);

        $this->model('Item')->update($id, $this->payload($input));
        $this->flash('success', 'Barang berhasil diperbarui.');
        $this->redirect('items');
    }

    public function delete(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('items');
        }

        $this->model('Item')->delete($id);
        $this->flash('success', 'Barang berhasil dihapus.');
        $this->redirect('items');
    }

    private function payload(array $input): array {
        return [
            'code' => $input['code'],
            'name' => $input['name'],
            'category_id' => ($input['category_id'] ?? '') !== '' ? (int) $input['category_id'] : null,
            'quantity' => (int) ($input['quantity'] ?? 0),
            'unit' => $input['unit'] ?: 'unit',
            'price' => (float) ($input['price'] ?? 0),
            'entry_date' => ($input['entry_date'] ?? '') !== '' ? $input['entry_date'] : null,
            'description' => $input['description'] ?? '',
        ];
    }
}

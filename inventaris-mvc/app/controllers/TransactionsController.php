<?php

class TransactionsController extends Controller {
    public function __construct() {
        $this->requireLogin();
    }

    public function index(): void {
        $allowedLimits = [5, 10, 20, 50, 100];
        $requestedLimit = filter_var($_GET['limit'] ?? 10, FILTER_VALIDATE_INT);
        $limit = in_array($requestedLimit, $allowedLimits, true) ? $requestedLimit : 10;
        $requestedPage = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
        $page = $requestedPage !== false && $requestedPage > 0 ? $requestedPage : 1;

        $transactions = $this->model('Transaction')->paginate($limit, $page);

        $this->view('transactions/index', [
            'title' => 'Riwayat Transaksi',
            'transactions' => $transactions,
            'currentLimit' => $limit
        ]);
    }
    public function stockIn(): void {
        $this->store('IN', 'Barang masuk berhasil dicatat!');
    }

    public function stockOut(): void {
        $this->store('OUT', 'Barang keluar berhasil dicatat!');
    }

    private function store(string $type, string $msg): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('transactions');
        }

        $itemId = filter_var($_POST['item_id'] ?? null, FILTER_VALIDATE_INT);
        $qty = filter_var($_POST['quantity'] ?? null, FILTER_VALIDATE_INT);

        if ($itemId === false || $itemId <= 0 || $qty === false || $qty <= 0) {
            $this->flash('danger', 'Data tidak valid.');
            $this->redirect('items');
        }

        $notes = $_POST['notes'] ?? '';
        if (!is_string($notes)) {
            $notes = '';
        }

        $ok = $this->model('Transaction')->create([
            'item_id' => $itemId,
            'user_id' => $_SESSION['user']['id'],
            'type' => $type,
            'quantity' => $qty,
            'notes' => trim($notes) ?: null,
        ]);

        $this->flash($ok ? 'success' : 'danger', $ok ? $msg : 'Gagal. Stok tidak mencukupi.');
        $this->redirect('items');
    }
}
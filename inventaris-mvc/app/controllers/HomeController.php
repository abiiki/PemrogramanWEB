<?php

class HomeController extends Controller {

    public function __construct() {
        $this->requireLogin();
    }

    public function index(): void {
        $items = $this->model('Item');
        $transactions = $this->model('Transaction');

        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'totalItems' => $items->totalItems(),
            'totalCategories' => $this->model('Category')->count(),
            'totalStock' => $items->totalStock(),
            'totalAssetValue' => $items->totalAssetValue(),
            'lowStockCount' => $items->lowStockCount(),
            'lowStockItems' => $items->lowStockItems(5, 5),
            'recentTransactions' => $transactions->recent(5),
            'todayTransactions' => $transactions->todayCount(),
        ]);
    }
}
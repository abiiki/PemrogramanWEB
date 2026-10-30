<?php

class Item extends Model {
    protected string $table = 'items';

    public function all(): array {
        $sql = "SELECT i.*, c.name AS category_name FROM items i LEFT JOIN categories c ON i.category_id = c.id ORDER BY i.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO items (code, name, category_id, quantity, unit, price, entry_date, description) VALUES (:code, :name, :category_id, :quantity, :unit, :price, :entry_date, :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool {
        $data['id'] = $id;
        $sql = "UPDATE items SET code = :code, name = :name, category_id = :category_id, quantity = :quantity, unit = :unit, price = :price, entry_date = :entry_date, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function generateCode(): string {
        $sql = "SELECT MAX(CAST(SUBSTRING(code, 4) AS UNSIGNED)) FROM items WHERE code LIKE 'ITM%'";
        $max = $this->db->query($sql)->fetchColumn();
        return 'ITM' . str_pad((string) ((($max ? (int) $max : 0) + 1)), 4, '0', STR_PAD_LEFT);
    }

    public function paginate(int $limit = 10, int $page = 1, string $search = '', string $categoryId = ''): array {
        $allowedLimits = [5, 10, 20, 50, 100];
        if (!in_array($limit, $allowedLimits, true)) {
            $limit = 10;
        }
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;
        $where = [];
        $params = [];

        if ($search !== '') {
            $where[] = "(i.code LIKE :search OR i.name LIKE :search OR c.name LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }
        if ($categoryId !== '') {
            $where[] = "i.category_id = :category_id";
            $params['category_id'] = (int) $categoryId;
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $countSql = "SELECT COUNT(*) FROM items i LEFT JOIN categories c ON i.category_id = c.id {$whereSql}";
        $count = $this->db->prepare($countSql);
        $count->execute($params);
        $total = (int) $count->fetchColumn();

        $dataSql = "SELECT i.*, c.name AS category_name FROM items i LEFT JOIN categories c ON i.category_id = c.id {$whereSql} ORDER BY i.id DESC LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->db->prepare($dataSql);
        $stmt->execute($params);

        return [
            'data' => $stmt->fetchAll(),
            'current_page' => $page,
            'total_pages' => (int) ceil($total / max($limit, 1)),
            'total_data' => $total
        ];
    }

    public function totalItems(): int {
        return (int) $this->db->query("SELECT COUNT(*) FROM items")->fetchColumn();
    }

    public function totalStock(): int {
        return (int) $this->db->query("SELECT COALESCE(SUM(quantity), 0) FROM items")->fetchColumn();
    }

    public function totalAssetValue(): float {
        return (float) $this->db->query("SELECT COALESCE(SUM(quantity * price), 0) FROM items")->fetchColumn();
    }

    public function lowStockCount(int $threshold = 5): int {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM items WHERE quantity <= :threshold');
        $stmt->execute(['threshold' => $threshold]);
        return (int) $stmt->fetchColumn();
    }

    public function lowStockItems(int $threshold = 5, int $limit = 5): array {
        $limit = max(1, min($limit, 100));
        $sql = "SELECT i.*, c.name AS category_name
                FROM items i
                LEFT JOIN categories c ON i.category_id = c.id
                WHERE i.quantity <= :threshold
                ORDER BY i.quantity ASC, i.id DESC
                LIMIT {$limit}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['threshold' => $threshold]);
        return $stmt->fetchAll();
    }

    public function countAll(): int {
        return $this->totalItems();
    }

    public function sumStock(): int {
        return $this->totalStock();
    }

    public function sumAsset(): float {
        return $this->totalAssetValue();
    }

    public function getLowStock(int $threshold = 5): array {
        return $this->lowStockItems($threshold, 100);
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM items WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
<?php

class Transaction extends Model {

    public function create(array $data): bool {
        $itemId = filter_var($data['item_id'] ?? null, FILTER_VALIDATE_INT);
        $userId = filter_var($data['user_id'] ?? null, FILTER_VALIDATE_INT);
        $quantity = filter_var($data['quantity'] ?? null, FILTER_VALIDATE_INT);
        $type = $data['type'] ?? '';

        if ($itemId === false || $itemId <= 0 || $userId === false || $userId <= 0
            || $quantity === false || $quantity <= 0 || !in_array($type, ['IN', 'OUT'], true)) {
            return false;
        }

        try {
            $this->db->beginTransaction();

            $check = $this->db->prepare('SELECT quantity FROM items WHERE id = :item_id FOR UPDATE');
            $check->execute(['item_id' => $itemId]);
            $currentStock = $check->fetchColumn();
            if ($currentStock === false) {
                $this->db->rollBack();
                return false;
            }

            $newStock = $type === 'IN'
                ? (int) $currentStock + $quantity
                : (int) $currentStock - $quantity;
            if ($newStock < 0) {
                $this->db->rollBack();
                return false;
            }

            $notes = $data['notes'] ?? null;
            if (!is_string($notes) || trim($notes) === '') {
                $notes = null;
            } else {
                $notes = trim($notes);
            }

            $this->db->prepare(
                'INSERT INTO transactions (item_id, user_id, type, quantity, notes)
                 VALUES (:item_id, :user_id, :type, :quantity, :notes)'
            )->execute([
                'item_id' => $itemId,
                'user_id' => $userId,
                'type' => $type,
                'quantity' => $quantity,
                'notes' => $notes,
            ]);
            $this->db->prepare('UPDATE items SET quantity = :quantity WHERE id = :item_id')
                ->execute(['quantity' => $newStock, 'item_id' => $itemId]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            Logger::error('Transaksi stok gagal.', [
                'exception' => $e->getMessage(),
                'item_id' => $itemId,
                'user_id' => $userId,
                'type' => $type,
            ]);
            return false;
        }
    }

    public function paginate(int $limit = 10, int $page = 1): array {
        $allowedLimits = [5, 10, 20, 50, 100];
        if (!in_array($limit, $allowedLimits, true)) {
            $limit = 10;
        }
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;
        $count = (int) $this->db->query('SELECT COUNT(*) FROM transactions')->fetchColumn();

        $sql = "SELECT t.*, i.code AS item_code, i.name AS item_name, u.username AS user_name
                FROM transactions t
                JOIN items i ON t.item_id = i.id
                JOIN users u ON t.user_id = u.id
                ORDER BY t.id DESC LIMIT {$limit} OFFSET {$offset}";

        $stmt = $this->db->query($sql);

        return [
            'data' => $stmt->fetchAll(),
            'current_page' => $page,
            'total_pages' => (int) ceil($count / $limit),
            'total_data' => $count
        ];
    }

    public function recent(int $limit = 5): array {
        $limit = max(1, min($limit, 50));
        $sql = "SELECT t.*, i.code AS item_code, i.name AS item_name, u.username AS user_name
                FROM transactions t
                JOIN items i ON t.item_id = i.id
                JOIN users u ON t.user_id = u.id
                ORDER BY t.id DESC LIMIT {$limit}";

        return $this->db->query($sql)->fetchAll();
    }

    public function todayCount(): int {
        return (int) $this->db->query(
            'SELECT COUNT(*) FROM transactions WHERE DATE(created_at) = CURDATE()'
        )->fetchColumn();
    }

    public function getRecent(int $limit = 5): array {
        return $this->recent($limit);
    }
}
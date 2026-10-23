<?php

class Item extends Model {
    protected string $table = 'items';

    public function all() {
        $sql = "SELECT i.*, c.name AS category_name FROM items i LEFT JOIN categories c ON i.category_id = c.id ORDER BY i.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO items (code, name, category_id, quantity, unit, price, entry_date, description) VALUES (:code, :name, :category_id, :quantity, :unit, :price, :entry_date, :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $sql = "UPDATE items SET code = :code, name = :name, category_id = :category_id, quantity = :quantity, unit = :unit, price = :price, entry_date = :entry_date, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function generateCode() {
        $sql = "SELECT MAX(CAST(SUBSTRING(code, 4) AS UNSIGNED)) FROM items WHERE code LIKE 'ITM%'";
        $max = $this->db->query($sql)->fetchColumn();
        return 'ITM' . str_pad((string)((($max ? (int)$max : 0) + 1)), 4, '0', STR_PAD_LEFT);
    }

    public function paginate($limit = 10, $page = 1, $search = '', $categoryId = '') {
        $offset = ($page - 1) * $limit;
        $where = []; 
        $params = [];
        
        if ($search !== '') {
            $where[] = "(i.code LIKE :search OR i.name LIKE :search OR c.name LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }
        if ($categoryId !== '') {
            $where[] = "i.category_id = :category_id";
            $params['category_id'] = (int)$categoryId;
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        
        $countSql = "SELECT COUNT(*) FROM items i LEFT JOIN categories c ON i.category_id = c.id {$whereSql}";
        $count = $this->db->prepare($countSql);
        $count->execute($params);
        $total = (int)$count->fetchColumn();

        $dataSql = "SELECT i.*, c.name AS category_name FROM items i LEFT JOIN categories c ON i.category_id = c.id {$whereSql} ORDER BY i.id DESC LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->db->prepare($dataSql);
        $stmt->execute($params);

        return [
            'data' => $stmt->fetchAll(), 
            'current_page' => $page,
            'total_pages' => (int)ceil($total / max($limit, 1)), 
            'total_data' => $total
        ];
        
    }
}

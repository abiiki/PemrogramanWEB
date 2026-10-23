<?php

class Item extends Model {
    protected $table = 'items';

    public function all() {
        return $this->db->query(
            "SELECT i.*, c.name AS category_name 
             FROM items i; 
             LEFT JOIN categories c ON i.category_id = c.id 
             ORDER BY i.id DESC"
        )->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO items (code, name, category_id, quantity, unit, price, entry_date, description) 
             VALUES (:code, :name, :category_id, :quantity, :unit, :price, :entry_date, :description)"
        );
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare(
            "UPDATE items SET 
                code = :code, 
                name = :name, 
                category_id = :category_id, 
                quantity = :quantity, 
                unit = :unit, 
                price = :price, 
                entry_date = :entry_date, 
                description = :description 
             WHERE id = :id"
        );
        return $stmt->execute($data);
    }

    public function generateCode() {
        $max = $this->db->query(
            "SELECT MAX(CAST(SUBSTRING(code, 4) AS UNSIGNED)) FROM items WHERE code LIKE 'ITM%'"
        )->fetchColumn();
        return 'ITM' . str_pad((string)((($max ? (int)$max : 0) + 1)), 4, '0', STR_PAD_LEFT);
    }
}
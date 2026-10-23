<?php
class Category extends Model {
    protected string $table = 'categories';
    public function all(): array {
        return $this->db->query(
            "SELECT c.*, (SELECT COUNT(*) FROM items i WHERE i.category_id = c.id) AS item_count
FROM categories c ORDER BY c.name"
        )->fetchAll();
    }
    public function create(array $data): bool {
        return $this->db->prepare(
            "INSERT INTO categories (name, description) VALUES (:name, :description)"
        )->execute($data);
    }
    public function update(int $id, array $data): bool {
        $data['id'] = $id;
        return $this->db->prepare(
            "UPDATE categories SET name = :name, description = :description WHERE id = :id"
        )->execute($data);
    }
}

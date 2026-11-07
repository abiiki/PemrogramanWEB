<?php

require_once ROOT_PATH . '/app/core/SoftDeletes.php';

class Book extends Model {
    protected string $table = 'books';
    use SoftDeletes;

    public function all(): array {
        $sql = 'SELECT id, code, title, author, published_year, stock FROM books WHERE deleted_at IS NULL ORDER BY id DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function trashed(): array {
        $sql = 'SELECT id, code, title, author, published_year, stock, deleted_at
                FROM books
                WHERE deleted_at IS NOT NULL
                ORDER BY deleted_at DESC, id DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function create(array $data): bool {
        $sql = 'INSERT INTO books (code, title, author, published_year, stock) VALUES (:code, :title, :author, :published_year, :stock)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['code' => $data['code'], 'title' => $data['title'], 'author' => $data['author'], 'published_year' => $data['published_year'], 'stock' => $data['stock'],
        ]);
    }

    public function update(int $id, array $data): bool {
        $sql = 'UPDATE books SET code = :code, title = :title, author = :author, published_year = :published_year, stock = :stock WHERE id = :id AND deleted_at IS NULL';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id, 'code' => $data['code'], 'title' => $data['title'], 'author' => $data['author'], 'published_year' => $data['published_year'], 'stock' => $data['stock'],
        ]);
    }

    public function find(int $id): array|false {
        $sql = 'SELECT id, code, title, author, published_year, stock
                FROM books
                WHERE id = ? AND deleted_at IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function destroy(int $id): bool {
        return $this->softDelete($id);
    }
}

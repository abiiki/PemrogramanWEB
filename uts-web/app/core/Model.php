<?php

class Model {
    protected PDO $db;
    protected string $table = '';

    public function __construct() {
        $this->db = Database::getInstance()->pdo();
    }

    public function find(int $id): array|false {
        if ($this->table === '') {
            throw new LogicException('Model table is not configured.');
        }

        $statement = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE id = ?");
        $statement->execute([$id]);
        return $statement->fetch();
    }
}

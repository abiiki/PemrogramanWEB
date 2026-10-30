<?php

class User extends Model {
    protected string $table = 'users';

    public function all(): array {
        return $this->db->query(
            'SELECT id, username, full_name, role, created_at FROM users ORDER BY id ASC'
        )->fetchAll();
    }

    public function login(string $username, string $password): array|false {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        unset($user['password']);
        return $user;
    }
}

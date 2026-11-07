<?php

class User extends Model {
    protected string $table = 'users';

    public function findByUsername(string $username): array|false {
        $stmt = $this->db->prepare(
            'SELECT id, username, password, name FROM users WHERE username = ?'
        );
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function updatePasswordHash(int $id, string $passwordHash): bool {
        $stmt = $this->db->prepare('UPDATE users SET password = ? WHERE id = ?');
        return $stmt->execute([$passwordHash, $id]);
    }
}

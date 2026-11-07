<?php

trait SoftDeletes {
    public function softDelete(int $id): bool {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET deleted_at = NOW() WHERE id = ? AND deleted_at IS NULL"
        );
        return $stmt->execute([$id]) && $stmt->rowCount() > 0;
    }

    public function restore(int $id): bool {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET deleted_at = NULL WHERE id = ? AND deleted_at IS NOT NULL"
        );
        return $stmt->execute([$id]) && $stmt->rowCount() > 0;
    }
}

<?php

class ProductImageModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getByProductId(int $productId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC, id ASC');
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function create(int $productId, string $filename, int $sortOrder = 0): int
    {
        $stmt = $this->db->prepare('INSERT INTO product_images (product_id, filename, sort_order) VALUES (?, ?, ?)');
        $stmt->execute([$productId, $filename, $sortOrder]);
        return (int) $this->db->lastInsertId();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM product_images WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM product_images WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function deleteByProductId(int $productId): void
    {
        $stmt = $this->db->prepare('DELETE FROM product_images WHERE product_id = ?');
        $stmt->execute([$productId]);
    }
}

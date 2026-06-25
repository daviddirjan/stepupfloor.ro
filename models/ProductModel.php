<?php

class ProductModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getFeatured(): array
    {
        $stmt = $this->db->query('SELECT * FROM products WHERE is_featured = 1 ORDER BY sort_order ASC LIMIT 1');
        return $stmt->fetch() ?: [];
    }

    public function getGrid(int $limit = 3): array
    {
        $stmt = $this->db->prepare('SELECT * FROM products ORDER BY sort_order ASC LIMIT ?');
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM products ORDER BY sort_order ASC');
        return $stmt->fetchAll();
    }
}

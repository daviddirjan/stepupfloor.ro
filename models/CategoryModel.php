<?php

class CategoryModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getAll(): array
    {
        return $this->db->query('SELECT * FROM categories ORDER BY sort_order ASC, name ASC')->fetchAll();
    }

    public function getAllWithProductCount(): array
    {
        return $this->db->query(
            'SELECT c.*, COUNT(p.id) AS product_count
             FROM categories c
             LEFT JOIN products p ON p.category_id = c.id
             GROUP BY c.id
             ORDER BY c.sort_order ASC, c.name ASC'
        )->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findBySlug(string $slug): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE slug = ?');
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function slugExists(string $slug, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM categories WHERE slug = ? AND id != ?');
        $stmt->execute([$slug, $excludeId]);
        return (bool) $stmt->fetch();
    }

    public function create(string $name, string $slug, int $sortOrder): int
    {
        $stmt = $this->db->prepare('INSERT INTO categories (name, slug, sort_order) VALUES (?, ?, ?)');
        $stmt->execute([$name, $slug, $sortOrder]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, string $name, string $slug, int $sortOrder): bool
    {
        $stmt = $this->db->prepare('UPDATE categories SET name = ?, slug = ?, sort_order = ? WHERE id = ?');
        return $stmt->execute([$name, $slug, $sortOrder, $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM categories WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function makeSlug(string $text): string
    {
        $map = ['ă'=>'a','â'=>'a','î'=>'i','ș'=>'s','ț'=>'t','Ă'=>'a','Â'=>'a','Î'=>'i','Ș'=>'s','Ț'=>'t'];
        $text = strtr($text, $map);
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}

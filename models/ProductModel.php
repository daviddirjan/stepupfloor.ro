<?php

class ProductModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getGrid(int $limit = 4): array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE is_featured = 1 ORDER BY sort_order ASC LIMIT ?');
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM products ORDER BY sort_order ASC');
        return $stmt->fetchAll();
    }

    public function getAllWithCategory(): array
    {
        return $this->db->query(
            'SELECT p.*, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             ORDER BY p.sort_order ASC'
        )->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findBySlug(string $slug): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE slug = ?');
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function getAllForShop(array $filters = []): array
    {
        $where  = [];
        $params = [];

        if (!empty($filters['thickness'])) {
            $placeholders = implode(',', array_fill(0, count($filters['thickness']), '?'));
            $where[]  = 'thickness IN (' . $placeholders . ')';
            $params   = array_merge($params, $filters['thickness']);
        }
        if (!empty($filters['color'])) {
            $placeholders = implode(',', array_fill(0, count($filters['color']), '?'));
            $where[]  = 'color IN (' . $placeholders . ')';
            $params   = array_merge($params, $filters['color']);
        }
        if (!empty($filters['price_min'])) {
            $where[]  = 'price_per_m2 >= ?';
            $params[] = (float)$filters['price_min'];
        }
        if (!empty($filters['price_max'])) {
            $where[]  = 'price_per_m2 <= ?';
            $params[] = (float)$filters['price_max'];
        }

        $sql = 'SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id = p.category_id';
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY p.sort_order ASC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getByCategory(int $categoryId, array $filters = []): array
    {
        $where  = ['p.category_id = ?'];
        $params = [$categoryId];

        if (!empty($filters['thickness'])) {
            $placeholders = implode(',', array_fill(0, count($filters['thickness']), '?'));
            $where[]  = 'p.thickness IN (' . $placeholders . ')';
            $params   = array_merge($params, $filters['thickness']);
        }
        if (!empty($filters['color'])) {
            $placeholders = implode(',', array_fill(0, count($filters['color']), '?'));
            $where[]  = 'p.color IN (' . $placeholders . ')';
            $params   = array_merge($params, $filters['color']);
        }
        if (!empty($filters['price_min'])) {
            $where[]  = 'p.price_per_m2 >= ?';
            $params[] = (float)$filters['price_min'];
        }
        if (!empty($filters['price_max'])) {
            $where[]  = 'p.price_per_m2 <= ?';
            $params[] = (float)$filters['price_max'];
        }

        $sql = 'SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id = p.category_id
                WHERE ' . implode(' AND ', $where) . ' ORDER BY p.sort_order ASC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getDistinctThicknesses(int $categoryId): array
    {
        $stmt = $this->db->prepare(
            "SELECT DISTINCT thickness FROM products WHERE category_id = ? AND thickness != '' ORDER BY thickness ASC"
        );
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getDistinctColors(int $categoryId): array
    {
        $stmt = $this->db->prepare(
            "SELECT DISTINCT color FROM products WHERE category_id = ? AND color != '' ORDER BY color ASC"
        );
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function create(array $d): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO products (slug, name, category, category_id, price_label, heading, description, badge, image,
             is_featured, is_variable, sort_order, thickness, color, weight_per_m2, price_per_m2,
             usage_class, warranty, rating, reviews_count, discount_label)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $d['slug'], $d['name'], $d['category'] ?? '', $d['category_id'] ?: null,
            $d['price_label'], $d['heading'], $d['description'],
            $d['badge'], $d['image'], (int)($d['is_featured'] ?? 0), (int)($d['is_variable'] ?? 0), (int)($d['sort_order'] ?? 0),
            $d['thickness'] ?? '', $d['color'] ?? '',
            $d['weight_per_m2'] !== '' && $d['weight_per_m2'] !== null ? (float)$d['weight_per_m2'] : null,
            $d['price_per_m2'] !== '' && $d['price_per_m2'] !== null ? (float)$d['price_per_m2'] : null,
            $d['usage_class'] ?? '', $d['warranty'] ?? '',
            isset($d['rating']) && $d['rating'] !== '' && $d['rating'] !== null ? (float)$d['rating'] : null,
            (int)($d['reviews_count'] ?? 0), $d['discount_label'] ?? '',
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $d): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE products SET slug=?, name=?, category=?, category_id=?, price_label=?, heading=?,
             description=?, badge=?, image=?, is_featured=?, is_variable=?, sort_order=?,
             thickness=?, color=?, weight_per_m2=?, price_per_m2=?,
             usage_class=?, warranty=?, rating=?, reviews_count=?, discount_label=? WHERE id=?'
        );
        return $stmt->execute([
            $d['slug'], $d['name'], $d['category'] ?? '', $d['category_id'] ?: null,
            $d['price_label'], $d['heading'], $d['description'],
            $d['badge'], $d['image'], (int)($d['is_featured'] ?? 0), (int)($d['is_variable'] ?? 0), (int)($d['sort_order'] ?? 0),
            $d['thickness'] ?? '', $d['color'] ?? '',
            $d['weight_per_m2'] !== '' && $d['weight_per_m2'] !== null ? (float)$d['weight_per_m2'] : null,
            $d['price_per_m2'] !== '' && $d['price_per_m2'] !== null ? (float)$d['price_per_m2'] : null,
            $d['usage_class'] ?? '', $d['warranty'] ?? '',
            isset($d['rating']) && $d['rating'] !== '' && $d['rating'] !== null ? (float)$d['rating'] : null,
            (int)($d['reviews_count'] ?? 0), $d['discount_label'] ?? '',
            $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = ?');
        return $stmt->execute([$id]);
    }
}

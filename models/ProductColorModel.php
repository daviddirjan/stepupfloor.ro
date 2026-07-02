<?php

class ProductColorModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getByProductId(int $productId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM product_colors WHERE product_id = ? ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM product_colors WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(
        int $productId, string $name, string $code, string $hexColor,
        string $image, string $image2, string $image3, string $image4,
        int $sortOrder
    ): int {
        $stmt = $this->db->prepare(
            'INSERT INTO product_colors
             (product_id, name, code, hex_color, image, image2, image3, image4, sort_order)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$productId, $name, $code, $hexColor, $image, $image2, $image3, $image4, $sortOrder]);
        return (int) $this->db->lastInsertId();
    }

    public function update(
        int $id, string $name, string $code, string $hexColor,
        string $image, string $image2, string $image3, string $image4,
        int $sortOrder
    ): bool {
        $stmt = $this->db->prepare(
            'UPDATE product_colors
             SET name=?, code=?, hex_color=?, image=?, image2=?, image3=?, image4=?, sort_order=?
             WHERE id=?'
        );
        return $stmt->execute([$name, $code, $hexColor, $image, $image2, $image3, $image4, $sortOrder, $id]);
    }

    public function updateImage(int $id, string $image, int $slot = 1): bool
    {
        $col  = $slot > 1 ? 'image' . $slot : 'image';
        $stmt = $this->db->prepare("UPDATE product_colors SET {$col}=? WHERE id=?");
        return $stmt->execute([$image, $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM product_colors WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function deleteByProductId(int $productId): void
    {
        $stmt = $this->db->prepare('DELETE FROM product_colors WHERE product_id = ?');
        $stmt->execute([$productId]);
    }
}

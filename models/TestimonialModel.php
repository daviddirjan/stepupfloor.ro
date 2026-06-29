<?php

class TestimonialModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM testimonials ORDER BY sort_order ASC');
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM testimonials WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $d): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO testimonials (name, location, review_text, rating, sort_order) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$d['name'], $d['location'], $d['review_text'], (int)$d['rating'], (int)$d['sort_order']]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $d): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE testimonials SET name=?, location=?, review_text=?, rating=?, sort_order=? WHERE id=?'
        );
        return $stmt->execute([$d['name'], $d['location'], $d['review_text'], (int)$d['rating'], (int)$d['sort_order'], $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM testimonials WHERE id = ?');
        return $stmt->execute([$id]);
    }
}

<?php

class BlogPostModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getAll(): array
    {
        return $this->db->query('SELECT * FROM blog_posts ORDER BY created_at DESC')->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM blog_posts WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function slugExists(string $slug, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM blog_posts WHERE slug = ? AND id != ?');
        $stmt->execute([$slug, $excludeId]);
        return (bool) $stmt->fetch();
    }

    public function create(array $d): int
    {
        $publishedAt = ($d['is_published'] && !$d['published_at']) ? date('Y-m-d H:i:s') : ($d['published_at'] ?: null);

        $stmt = $this->db->prepare(
            'INSERT INTO blog_posts (title, slug, excerpt, body, image, is_published, published_at)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$d['title'], $d['slug'], $d['excerpt'], $d['body'], $d['image'], (int)$d['is_published'], $publishedAt]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $d): bool
    {
        $existing    = $this->findById($id);
        $publishedAt = $existing['published_at'];
        if ($d['is_published'] && !$publishedAt) {
            $publishedAt = date('Y-m-d H:i:s');
        }

        $stmt = $this->db->prepare(
            'UPDATE blog_posts SET title=?, slug=?, excerpt=?, body=?, image=?, is_published=?, published_at=? WHERE id=?'
        );
        return $stmt->execute([$d['title'], $d['slug'], $d['excerpt'], $d['body'], $d['image'], (int)$d['is_published'], $publishedAt, $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM blog_posts WHERE id = ?');
        return $stmt->execute([$id]);
    }
}

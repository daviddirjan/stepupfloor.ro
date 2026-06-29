<?php

class ProjectModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getAllPublished(): array
    {
        $rows = $this->db->query(
            'SELECT * FROM projects WHERE is_published = 1 ORDER BY year DESC, created_at DESC'
        )->fetchAll();

        return array_map([$this, 'decodeTags'], $rows);
    }

    public function getAll(): array
    {
        $rows = $this->db->query('SELECT * FROM projects ORDER BY created_at DESC')->fetchAll();
        return array_map([$this, 'decodeTags'], $rows);
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM projects WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $this->decodeTags($row) : false;
    }

    public function slugExists(string $slug, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM projects WHERE slug = ? AND id != ?');
        $stmt->execute([$slug, $excludeId]);
        return (bool) $stmt->fetch();
    }

    public function create(array $d): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO projects (title, slug, client, location, surface, year, image, tags, description, is_published)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $d['title'], $d['slug'], $d['client'], $d['location'],
            (int)$d['surface'], (int)$d['year'], $d['image'],
            json_encode($d['tags'], JSON_UNESCAPED_UNICODE),
            $d['description'], (int)$d['is_published'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $d): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE projects SET title=?, slug=?, client=?, location=?, surface=?, year=?, image=?, tags=?, description=?, is_published=? WHERE id=?'
        );
        return $stmt->execute([
            $d['title'], $d['slug'], $d['client'], $d['location'],
            (int)$d['surface'], (int)$d['year'], $d['image'],
            json_encode($d['tags'], JSON_UNESCAPED_UNICODE),
            $d['description'], (int)$d['is_published'], $id,
        ]);
    }

    public function getHeroStats(): array
    {
        $row = $this->db->query(
            'SELECT COUNT(*) AS total,
                    COUNT(DISTINCT location) AS locations,
                    COALESCE(SUM(surface), 0) AS total_surface
             FROM projects WHERE is_published = 1'
        )->fetch();

        return [
            'total'    => (int)$row['total'],
            'locations'=> (int)$row['locations'],
            'surface'  => (int)$row['total_surface'],
        ];
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM projects WHERE id = ?');
        return $stmt->execute([$id]);
    }

    private function decodeTags(array $row): array
    {
        $row['tags'] = json_decode($row['tags'] ?? '[]', true) ?: [];
        return $row;
    }
}

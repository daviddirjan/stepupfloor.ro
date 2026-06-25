<?php

class ServiceModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM services ORDER BY sort_order ASC');
        return $stmt->fetchAll();
    }

    public function getBySlug(string $slug): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM services WHERE slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
}

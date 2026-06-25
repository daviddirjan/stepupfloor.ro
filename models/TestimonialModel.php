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
}

<?php

class ContactModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function save(string $name, string $phone, string $email, string $message): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO contact_submissions (name, phone, email, message) VALUES (?, ?, ?, ?)'
        );
        return $stmt->execute([$name, $phone, $email, $message]);
    }

    public function getAll(): array
    {
        return $this->db->query(
            'SELECT * FROM contact_submissions ORDER BY created_at DESC'
        )->fetchAll();
    }

    public function markRead(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE contact_submissions SET is_read = 1 WHERE id = ?');
        return $stmt->execute([$id]);
    }
}

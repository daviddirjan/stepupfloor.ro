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
}

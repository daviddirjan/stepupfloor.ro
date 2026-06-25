<?php

class StatModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT stat_key, stat_value, label FROM stats ORDER BY sort_order ASC');
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[$row['stat_key']] = $row;
        }
        return $result;
    }
}

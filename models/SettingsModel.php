<?php

class SettingsModel
{
    private static array $cache = [];
    private static bool  $loaded = false;

    private static function loadAll(): void
    {
        if (self::$loaded) return;
        try {
            $rows = Database::connection()
                ->query('SELECT `key`, value FROM settings')
                ->fetchAll(PDO::FETCH_KEY_PAIR);
            self::$cache  = $rows ?: [];
            self::$loaded = true;
        } catch (Exception) {
            self::$loaded = true;
        }
    }

    public static function get(string $key, string $default = ''): string
    {
        self::loadAll();
        $val = self::$cache[$key] ?? $default;
        return ($val !== '') ? $val : $default;
    }

    public static function set(string $key, string $value): void
    {
        Database::connection()->prepare(
            'INSERT INTO settings (`key`, value) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE value = VALUES(value)'
        )->execute([$key, $value]);

        self::$cache[$key] = $value;
    }

    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            self::set($key, $value);
        }
    }

    public static function getAll(): array
    {
        self::loadAll();
        return self::$cache;
    }
}

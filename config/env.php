<?php

/**
 * Încarcă perechile CHEIE=valoare dintr-un fișier .env în $_ENV / getenv().
 * Parser minimal, fără dependențe (Composer nu este folosit în acest proiect).
 * Liniile goale și cele care încep cu # sunt ignorate. Ghilimelele din jurul
 * valorii sunt eliminate.
 */
function load_env(string $path): void
{
    if (!is_readable($path)) {
        return;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim($value);

        if ((str_starts_with($value, '"') && str_ends_with($value, '"'))
            || (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
            $value = substr($value, 1, -1);
        }

        if ($key === '' || array_key_exists($key, $_ENV)) {
            continue;
        }

        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

/**
 * Citește o variabilă de mediu cu fallback opțional.
 */
function env(string $key, ?string $default = null): ?string
{
    $value = $_ENV[$key] ?? getenv($key);
    return ($value === false || $value === null || $value === '') ? $default : $value;
}

load_env(BASE_PATH . '/.env');

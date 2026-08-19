<?php

declare(strict_types=1);

/**
 * Loads a simple .env file if it exists.
 * This is intentionally dependency-free for the Core PHP version.
 */
function loadEnv(string $path): array
{
    if (!is_file($path)) {
        return [];
    }

    $values = [];

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $value = trim($value, "\"'");

        $values[$key] = $value;
    }

    return $values;
}

$env = loadEnv(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');

$config = [
    'host' => $env['DB_HOST'] ?? '127.0.0.1',
    'port' => $env['DB_PORT'] ?? '3306',
    'database' => $env['DB_DATABASE'] ?? 'api_database_core',
    'username' => $env['DB_USERNAME'] ?? 'root',
    'password' => $env['DB_PASSWORD'] ?? '',
    'charset' => $env['DB_CHARSET'] ?? 'utf8mb4',
];

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
    $config['host'],
    $config['port'],
    $config['database'],
    $config['charset']
);

try {
    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die('Database connection failed. Check .env and make sure MySQL is running.');
}

return $pdo;

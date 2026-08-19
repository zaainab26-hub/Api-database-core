<?php

declare(strict_types=1);

$pdo = require dirname(__DIR__) . '/config/database.php';

$migrations = [
    __DIR__ . '/migrations/001_create_contacts.php',
    __DIR__ . '/migrations/002_create_pipelines.php',
    __DIR__ . '/migrations/003_create_leads.php',
    __DIR__ . '/migrations/004_create_activity_logs.php',
];

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS migrations (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL UNIQUE,
        executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
);

foreach ($migrations as $file) {
    $migration = require $file;
    $name = basename($file, '.php');

    $check = $pdo->prepare('SELECT COUNT(*) FROM migrations WHERE migration = ?');
    $check->execute([$name]);

    if ((int) $check->fetchColumn() > 0) {
        echo "SKIPPED: {$name}\n";
        continue;
    }

    try {
        $pdo->beginTransaction();
        $migration($pdo);
        $insert = $pdo->prepare('INSERT INTO migrations (migration) VALUES (?)');
        $insert->execute([$name]);
        $pdo->commit();
        echo "OK: {$name}\n";
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        echo "FAILED: {$name} - {$e->getMessage()}\n";
        exit(1);
    }
}

echo "All migrations completed successfully.\n";

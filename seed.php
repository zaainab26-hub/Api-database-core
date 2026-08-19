<?php

declare(strict_types=1);

$pdo = require dirname(__DIR__) . '/config/database.php';
$seeder = require __DIR__ . '/seeders/DatabaseSeeder.php';

try {
    $pdo->beginTransaction();
    $seeder($pdo);
    $pdo->commit();
    echo "Database seeded successfully.\n";
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "SEED FAILED: {$e->getMessage()}\n";
    exit(1);
}

<?php

declare(strict_types=1);

$required = [
    'config/database.php',
    'public/index.php',
    'database/migrate.php',
    'database/seed.php',
    'database/migrations/001_create_contacts.php',
    'database/migrations/002_create_pipelines.php',
    'database/migrations/003_create_leads.php',
    'database/migrations/004_create_activity_logs.php',
    'database/seeders/DatabaseSeeder.php',
    'docs/ERD.md',
    'docs/erd.svg',
];

$missing = array_values(array_filter($required, fn ($file) => !is_file(__DIR__ . '/' . $file)));

if ($missing) {
    echo "Missing files:\n" . implode("\n", $missing) . "\n";
    exit(1);
}

echo "Project structure check: PASS\n";
echo "Required schema/migration/seed files are present.\n";
echo "For a full database verification, configure .env and run:\n";
echo "  php database/migrate.php\n";
echo "  php database/seed.php\n";

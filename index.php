<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'success' => true,
    'message' => 'API & Database Core is running.',
    'framework' => 'Core PHP',
    'php_version' => PHP_VERSION,
    'timestamp' => date(DATE_ATOM),
], JSON_PRETTY_PRINT);

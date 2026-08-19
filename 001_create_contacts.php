<?php

declare(strict_types=1);

return function (PDO $pdo): void {
    $pdo->exec(
        'CREATE TABLE contacts (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            email VARCHAR(190) NOT NULL,
            phone VARCHAR(30) NULL,
            company VARCHAR(150) NULL,
            job_title VARCHAR(120) NULL,
            notes TEXT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY uq_contacts_email (email),
            INDEX idx_contacts_company (company)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
};

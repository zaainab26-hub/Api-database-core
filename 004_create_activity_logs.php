<?php

declare(strict_types=1);

return function (PDO $pdo): void {
    $pdo->exec(
        'CREATE TABLE activity_logs (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            lead_id BIGINT UNSIGNED NOT NULL,
            activity_type ENUM("call", "email", "meeting", "note", "task", "status_change") NOT NULL,
            description TEXT NOT NULL,
            activity_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_activity_logs_lead (lead_id),
            INDEX idx_activity_logs_type (activity_type),
            INDEX idx_activity_logs_activity_at (activity_at),
            CONSTRAINT fk_activity_logs_lead
                FOREIGN KEY (lead_id) REFERENCES leads(id)
                ON UPDATE CASCADE ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
};

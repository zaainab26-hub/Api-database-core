<?php

declare(strict_types=1);

return function (PDO $pdo): void {
    $pdo->exec(
        'CREATE TABLE leads (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            contact_id BIGINT UNSIGNED NOT NULL,
            pipeline_id BIGINT UNSIGNED NOT NULL,
            title VARCHAR(180) NOT NULL,
            status ENUM("new", "qualified", "proposal", "won", "lost") NOT NULL DEFAULT "new",
            stage VARCHAR(100) NOT NULL,
            source VARCHAR(100) NULL,
            estimated_value DECIMAL(12,2) NOT NULL DEFAULT 0.00,
            expected_close_date DATE NULL,
            notes TEXT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_leads_contact (contact_id),
            INDEX idx_leads_pipeline_stage (pipeline_id, stage),
            INDEX idx_leads_status (status),
            CONSTRAINT fk_leads_contact
                FOREIGN KEY (contact_id) REFERENCES contacts(id)
                ON UPDATE CASCADE ON DELETE RESTRICT,
            CONSTRAINT fk_leads_pipeline
                FOREIGN KEY (pipeline_id) REFERENCES pipelines(id)
                ON UPDATE CASCADE ON DELETE RESTRICT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
};

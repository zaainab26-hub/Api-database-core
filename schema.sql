CREATE DATABASE IF NOT EXISTS api_database_core
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE api_database_core;

CREATE TABLE contacts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    phone VARCHAR(30) NULL,
    company VARCHAR(150) NULL,
    job_title VARCHAR(120) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_contacts_company (company)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pipelines (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL UNIQUE,
    description VARCHAR(500) NULL,
    stages JSON NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_pipelines_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE leads (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contact_id BIGINT UNSIGNED NOT NULL,
    pipeline_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(180) NOT NULL,
    status ENUM('new','qualified','proposal','won','lost') NOT NULL DEFAULT 'new',
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
    CONSTRAINT fk_leads_contact FOREIGN KEY (contact_id) REFERENCES contacts(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_leads_pipeline FOREIGN KEY (pipeline_id) REFERENCES pipelines(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE activity_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lead_id BIGINT UNSIGNED NOT NULL,
    activity_type ENUM('call','email','meeting','note','task','status_change') NOT NULL,
    description TEXT NOT NULL,
    activity_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_activity_logs_lead (lead_id),
    INDEX idx_activity_logs_type (activity_type),
    INDEX idx_activity_logs_activity_at (activity_at),
    CONSTRAINT fk_activity_logs_lead FOREIGN KEY (lead_id) REFERENCES leads(id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

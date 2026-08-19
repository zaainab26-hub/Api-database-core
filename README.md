# API & Database Core — Core PHP

## Assigned Task
**Project Initialization & DB Schema**

This project is a clean Core PHP + MySQL implementation of the assigned database/schema work.

### Scope completed
1. Core PHP project boilerplate and repository-ready structure
2. Finalized ERD for Contacts, Pipelines, Leads, and Activity Logs
3. Four migration files
4. Seed data for all four entities
5. PDO database configuration
6. Simple migration and seed runners
7. Basic health-check entry point
8. Models showing the main relationships

> **Note:** The requested implementation is Core PHP, so no Laravel/framework dependency is used.

## Requirements
- PHP 8.1+ (PHP 8.2+ recommended)
- MySQL 8.0+ or MariaDB 10.4+
- PDO MySQL extension enabled
- XAMPP works well for local development

## Setup

### 1. Copy project
Put this folder in:

`C:\xampp\htdocs\api-database-core`

### 2. Create database
Open phpMyAdmin and create:

`api_database_core`

Or create it from MySQL:

```sql
CREATE DATABASE api_database_core CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Configure environment
Copy `.env.example` to `.env` and update the database values.

The included config also has safe local defaults for XAMPP (`root` with an empty password), but `.env` is preferred.

### 4. Run migrations
From the project root:

```bash
php database/migrate.php
```

This creates:
- contacts
- pipelines
- leads
- activity_logs

### 5. Seed dummy data

```bash
php database/seed.php
```

The seed script clears/repopulates the four task tables in dependency order so it can be used repeatedly during development.

### 6. Test the project
Start Apache in XAMPP and open:

`http://localhost/api-database-core/public/`

You should see a JSON health response.

## Migration order
1. contacts
2. pipelines
3. leads
4. activity_logs

This order is required because `leads` references contacts/pipelines and `activity_logs` references leads.

## Relationships
- Contact **1 : many** Leads
- Pipeline **1 : many** Leads
- Lead **1 : many** Activity Logs

## ERD
See:
- `docs/ERD.md`
- `docs/erd.svg`

The ERD is intentionally kept synchronized with the migration schema.

## Repository
Initialize Git in the project root:

```bash
git init
git add .
git commit -m "Initial Core PHP project and database schema"
```

The `.gitignore` prevents `.env` and other local/runtime files from being committed.

## Useful verification
After migration and seeding:

```sql
SELECT COUNT(*) FROM contacts;
SELECT COUNT(*) FROM pipelines;
SELECT COUNT(*) FROM leads;
SELECT COUNT(*) FROM activity_logs;
```

Expected seeded counts:
- contacts: 5
- pipelines: 2
- leads: 5
- activity_logs: 8

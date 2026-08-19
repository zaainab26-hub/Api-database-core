<?php

declare(strict_types=1);

final class Contact
{
    public function __construct(private PDO $db) {}

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM contacts WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function leads(int $contactId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM leads WHERE contact_id = ? ORDER BY id DESC');
        $stmt->execute([$contactId]);

        return $stmt->fetchAll();
    }
}

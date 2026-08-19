<?php

declare(strict_types=1);

final class Lead
{
    public function __construct(private PDO $db) {}

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT l.*, c.name AS contact_name, c.email AS contact_email, p.name AS pipeline_name
             FROM leads l
             INNER JOIN contacts c ON c.id = l.contact_id
             INNER JOIN pipelines p ON p.id = l.pipeline_id
             WHERE l.id = ?'
        );
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function activities(int $leadId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM activity_logs WHERE lead_id = ? ORDER BY activity_at DESC, id DESC'
        );
        $stmt->execute([$leadId]);

        return $stmt->fetchAll();
    }
}

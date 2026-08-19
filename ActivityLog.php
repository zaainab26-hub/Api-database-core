<?php

declare(strict_types=1);

final class ActivityLog
{
    public function __construct(private PDO $db) {}

    public function forLead(int $leadId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM activity_logs WHERE lead_id = ? ORDER BY activity_at DESC, id DESC'
        );
        $stmt->execute([$leadId]);

        return $stmt->fetchAll();
    }
}

<?php

declare(strict_types=1);

final class Pipeline
{
    public function __construct(private PDO $db) {}

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM pipelines WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function leads(int $pipelineId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM leads WHERE pipeline_id = ? ORDER BY id DESC');
        $stmt->execute([$pipelineId]);

        return $stmt->fetchAll();
    }
}

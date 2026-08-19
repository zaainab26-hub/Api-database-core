<?php

declare(strict_types=1);

final class HealthController
{
    public function index(): array
    {
        return [
            'success' => true,
            'message' => 'API & Database Core is healthy.',
        ];
    }
}

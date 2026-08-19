<?php

declare(strict_types=1);

/*
 * Route definitions for the future REST API.
 *
 * Current assigned scope is database initialization/schema only.
 * API endpoint implementation belongs to the parent API task's later work.
 */

return [
    'GET /api/health' => 'HealthController@index',
];

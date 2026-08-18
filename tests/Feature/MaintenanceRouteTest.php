<?php

namespace Tests\Feature;

use Tests\TestCase;

class MaintenanceRouteTest extends TestCase
{
    public function test_maintenance_follow_up_route_is_registered(): void
    {
        $this->assertNotNull(route('maintenance.follow_up_request'));
    }
}

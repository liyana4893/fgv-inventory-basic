<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiStabilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_unknown_api_endpoint_returns_standard_json_not_found_shape(): void
    {
        $response = $this->getJson('/api/health');

        $response->assertStatus(404)
            ->assertHeader('content-type', 'application/json')
            ->assertJsonStructure(['message']);
    }

    public function test_web_routes_default_to_html_response_type(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $this->assertStringContainsString('text/html', (string) $response->headers->get('content-type'));
    }
}

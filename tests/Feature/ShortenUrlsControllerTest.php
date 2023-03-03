<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortenUrlsControllerTest extends TestCase
{
    public function test_shorten_urls_endpoint_with_valid_token_returns_status_200()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ()',
        ])->json('POST', '/api/v1/short-urls', ['url' => 'http://www.example.com']);

        $response->assertStatus(200);
    }

    public function test_shorten_urls_endpoint_with_valid_token_but_without_url_in_the_body_returns_status_422()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ()',
        ])->json('POST', '/api/v1/short-urls', ['url' => '']);

        $statusCode = $response->decodeResponseJson()['code'];
        $this->assertEquals(422, $statusCode);
    }

    public function test_shorten_urls_endpoint_with_invalid_token_returns_status_403()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ((()',
        ])->json('POST', '/api/v1/short-urls', ['url' => 'http://www.example.com']);

        $response->assertStatus(403);
    }
}

<?php

namespace Tests\Feature\Controllers;


use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase

{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetALLFromAllProvidersWithFilterShouldReturnOnlyOneResult()
    {
        $response = $this->getJson('/api/v1/users?balanceMax=150&statusCode=decline');
        $this->assertEquals(1, count($response->getData()));
        $response->assertStatus(200);
        $response->assertJson([
            [
                "provider" => "X_DATA_PROVIDER",
                "id" => "65bda5cd0a0bf",
                "email" => "user4@example.com",
                "status" => 2,
                "created_at" => "2024-01-30",
                "currency" => "EUR",
                "balance" => 123
            ]
        ]);
    }
}

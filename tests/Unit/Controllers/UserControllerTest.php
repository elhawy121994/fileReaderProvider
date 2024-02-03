<?php

namespace Tests\Unit\Controllers;

use App\Http\Resources\XDataProviderResource;
use App\Http\Resources\YDataProviderResource;
use App\Product\DataProviders\XFileDataProvider;
use App\Product\DataProviders\YFileDataProvider;
use App\Product\Interfaces\DataProviderInterface;
use App\Services\Interfaces\UsersServiceInterface;
use App\Services\UsersService;
use InvalidArgumentException;
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

    public function testGetXDDataRequestValidationFail()
    {
        $productServiceMock = Mockery::mock(UsersServiceInterface::class);

        $productServiceMock->shouldNotHaveReceived('list');
        $this->app->instance(UsersService::class, $productServiceMock);

        $response = $this->getJson('api/v1/users?statusCode=blabla');
        $response->assertUnprocessable();
        $this->assertJson('{"message":"The given data was invalid.","errors":{"statusCode":["The selected status code is invalid."],"provider":["The selected provider is invalid."]}}');
    }

    public function testGetXDataProductMappedResponseSuccessfully()
    {
        $collection = XDataProviderResource::collection(json_decode(json_encode([
            [
                "parentAmount" => 200,
                "Currency" => "USD",
                "parentEmail" => "parent1@parent.eu",
                "statusCode" => 1,
                "registerationDate" => "2018-11-30",
                "parentIdentification" => "d3d29d70-1d25-11e3-8591-034165a3a613"
            ],
            [
                "parentAmount" => 779,
                "Currency" => "EUR",
                "parentEmail" => "user0@example.com",
                "statusCode" => 3,
                "registerationDate" => "2024-02-03",
                "parentIdentification" => "65bda5cd0a0b6"
            ],
        ])));

        $dataProviderX = Mockery::mock(DataProviderInterface::class);

        $dataProviderX->shouldReceive('getData')
            ->once()
            ->andReturn($collection);

        $this->app->instance(XFileDataProvider::class, $dataProviderX);


        $response = $this->getJson('/api/v1/users/?provider=DataProviderX');
        $response->assertStatus(200);

        $response->assertJson([
            [
                "provider" => "X_DATA_PROVIDER",
                "id" => "d3d29d70-1d25-11e3-8591-034165a3a613",
                "email" => "parent1@parent.eu",
                "status" => 1,
                "created_at" => "2018-11-30",
                "currency" => "USD",
                "balance" => 200
            ],
            [
                "provider" => "X_DATA_PROVIDER",
                "id" => "65bda5cd0a0b6",
                "email" => "user0@example.com",
                "status" => 3,
                "created_at" => "2024-02-03",
                "currency" => "EUR",
                "balance" => 779
            ],
        ]);
    }

    public function testGetYDataProductMappedResponseSuccessfully()
    {
        $collection = YDataProviderResource::collection(json_decode(json_encode([
            [
                "balance" => 300,
                "currency" => "AED",
                "email" => "parent2@parent.eu",
                "status" => 100,
                "created_at" => "22/12/2018",
                "id" => "4fc2-a8d1"
            ],
            [
                "balance" => 681,
                "currency" => "USD",
                "email" => "user0@example.com",
                "status" => 90,
                "created_at" => "03/02/2024",
                "id" => "65bda4e38ce61"
            ]
        ])));

        $dataProviderY = Mockery::mock(DataProviderInterface::class);

        $dataProviderY->shouldReceive('getData')
            ->once()
            ->andReturn($collection);

        $this->app->instance(YFileDataProvider::class, $dataProviderY);

        $response = $this->getJson('/api/v1/users/?provider=DataProviderY');
        $response->assertStatus(200);

        $response->assertJson([
            [
                "provider" => "Y_DATA_PROVIDER",
                "id" => "4fc2-a8d1",
                "email" => "parent2@parent.eu",
                "status" => 100,
                "created_at" => "2018-12-22",
                "currency" => "AED",
                "balance" => 300
            ],
            [
                "provider" => "Y_DATA_PROVIDER",
                "id" => "65bda4e38ce61",
                "email" => "user0@example.com",
                "status" => 90,
                "created_at" => "2024-02-03",
                "currency" => "USD",
                "balance" => 681
            ]
        ]);
    }
}

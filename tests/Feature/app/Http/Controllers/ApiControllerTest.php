<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;
use app\Services\ApiService;

class ApiControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_login() {
        $mock = Mockery::mock(ApiService::class);
        $mock->shouldReceive('getTokenRequest')
            //->with(Mockery::type('int'), Mockery::any())
            ->andReturn('success');

        $this->app->instance(\App\Services\ApiService::class, $mock);
        $params = [
            'username' => 'testDemo',
            'password' => '1234'
        ];
        $response = $this->post('/login-api', $params);

        $response->assertStatus(200);

    }

    public function test_get_rates()
    {

        $paramArray = [
            "originCity" => "KEY LARGO",
            "originState" => "FL",
            "originZipcode" => "33037",
            "originCountry" => "US",
            "destinationCity" => "LOS ANGELES",
            "destinationState" => "CA",
            "destinationZipcode" => "90001",
            "destinationCountry" => "US",
            "UOM" => "US",
            "vendorid" => 1901539643,
            "freightInfo" => '[{"qty":1,"weight":100,"weightType":"each","length":40,"width":40,"height":40,"class":100,"hazmat":0,"commodity":"","dimType":"PLT","stack":false}]'
        ];
        

        $mock = Mockery::mock(ApiService::class);
        $mock->shouldReceive('getRates')
            //->with(Mockery::type('int'), Mockery::any())
            ->andReturn([
                'data' => [
                    '*' => []
                ]
            ]);

        $this->app->instance(\App\Services\ApiService::class, $mock);

        $response = $this->post('/get-rates', $paramArray);

        $response->assertStatus(200);

    }

    public function test_get_rates_not_data_found()
    {
               
        $mock = Mockery::mock(ApiService::class);
        $mock->shouldReceive('getRates')
            ->andReturn([
                'data' => []
            ]);

        $this->app->instance(\App\Services\ApiService::class, $mock);

        $response = $this->post('/get-rates');

        $response->assertStatus(204);

    }



}

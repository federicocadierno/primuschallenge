<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ApiService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => "https://sandbox-api.shipprimus.com/api/v1/", 
            'timeout'  => 5.0,
        ]);
    }

    public function getRates($vendorID, $data)
    {
        $url = "database/vendor/contract/{$vendorID}/rate";
        $token = Cache::get('access_token');

        try {
            $response = $this->client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ],
                'query' => $data
            ]);

            Log::error("after api call". print_r($response, true));

            $responseBody = [
                "response" => json_decode($response->getBody()->getContents(), true),
                "status_code" => $response->getStatusCode()
            ];

            return $responseBody;

        } catch (ClientException $e) {
            // Handle 4xx client errors
            $response = $e->getResponse();
            if($response->getStatusCode() == 401) {
                Log::error('token expired... ');
                $this->refreshTokenRequest();
                $this->getRates($vendorID, $data);
            } else {
                $responseBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            }
        } catch (ServerException $e) {
            // Handle 5xx server errors
            $response = $e->getResponse();
            $responseMessage = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            $responseBody = [
                "response" => $responseMessage,
                "status_code" => $response->getStatusCode()
            ];
        } 
    }

    public function getTokenRequest($data)
    {

        try {
            $response = $this->client->request('POST', 'login',[
                'form_params' => [
                    'username' => $data['username'],
                    'password' => $data['password'],
                ],
            ]);
            // Process successful response
            $responseBody = $response->getBody()->getContents();
            $res = json_decode($responseBody, true);
            Cache::put('access_token',$res['data']['accessToken'],$res['data']['exp']);
        } catch (ClientException $e) {
            // Handle 4xx client errors
            $response = $e->getResponse();
            $responseMessage = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            $responseBody = [
                "response" => $responseMessage,
                "status_code" => $response->getStatusCode()
            ];
        } catch (ServerException $e) {
            // Handle 5xx server errors
            $response = $e->getResponse();
            $responseMessage = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            $responseBody = [
                "response" => $responseMessage,
                "status_code" => $response->getStatusCode()
            ];
        } 

        return $responseBody;
    }

    public function refreshTokenRequest()
    {

        try {
            $response = $this->client->request('POST', 'refreshtoken',[
                'form_params' => [
                    'token' => Cache::get('access_token')
                ],
            ]);
            // Process successful response
            $responseBody = $response->getBody()->getContents();
            $res = json_decode($responseBody, true);
            Cache::put('access_token',$res['data']['accessToken']);
        } catch (ClientException $e) {
            // Handle 4xx client errors
            $response = $e->getResponse();
            $responseMessage = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            $responseBody = [
                "response" => $responseMessage,
                "status_code" => $response->getStatusCode()
            ];
        } catch (ServerException $e) {
            // Handle 5xx server errors
            $response = $e->getResponse();
            $responseMessage = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            $responseBody = [
                "response" => $responseMessage,
                "status_code" => $response->getStatusCode()
            ];
        } 

        return $responseBody;
    }

}

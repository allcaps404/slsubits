<?php

namespace App\Services;

use GuzzleHttp\Client;

class JobStreetApiService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getJobListings($queryParams = [])
    {
        $url = 'https://api.jobstreet.com/v1/job-listings';

        try {
            $response = $this->client->get($url, [
                'query' => $queryParams, 
                'headers' => [
                    'Authorization' => 'Bearer ' . env('JOBSTREET_API_KEY'), 
                    'Accept' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody(), true); 
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}

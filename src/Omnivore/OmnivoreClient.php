<?php

namespace Omnivore;

use GuzzleHttp\Client;
use Omnivore\Response;

class OmnivoreClient
{
    protected $baseUrl;
    protected $apiKey;
    public $response;

    public function __construct()
    {
        $this->baseUrl = getenv('OMNIVORE_API_BASE_URL');
        $this->apiKey = getenv('OMNIVORE_API_KEY');
        
        // @TODO validate params
        //$this->params = $params;
        $this->client = new Client([
          'base_uri' => $this->baseUrl,
          'headers' => ['Api-Key' => $this->apiKey]
        ]);
    }

    public function buildUrl($endpoint)
    {
        return $this->baseUrl . $endpoint;
    }

    public function get($url)
    {
        $res = $this->client->request('GET', $url);

        $apiResponse = json_decode($res->getBody(), true);
        $this->response = new Response($apiResponse);
        return $this->response;
    }

    public function post($url, $data)
    {
        $data = json_encode($data, true);

        $apiResponse = $this->client->post(
            $url,
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => $data
            ]
        );

        $responseCode = $apiResponse->getStatusCode();
        $responseData = json_decode($apiResponse->getBody(), true);

        if ($responseCode > 201) {
            $description  = isset($responseData['description']) ? $responseData['description'] : '';
            $error        = isset($responseData['error']) ? $responseData['error'] : '';

            throw new \Exception("{$responseCode} - {$description} - {$error}");
        }

        $this->response = new Response($responseData);
        $this->response->setResponseCode($responseCode);

        return $this->response;
    }

    // getLocation(locationId)
    public function getLocation($locationId)
    {
        // set URL here

    }
}

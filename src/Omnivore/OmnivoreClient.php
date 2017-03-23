<?php

namespace Omnivore;

use \GuzzleHttp\Client;
use Omnivore\Response;

class OmnivoreClient
{
    const API_BASE_URL  = 'https://api.omnivore.io/1.0/';
    public $response    = null;

    public function __construct()
    {
        // @TODO validate params
        //$this->params = $params;
        $this->client = new \GuzzleHttp\Client([
          'base_uri' => self::API_BASE_URL,
          'headers' => ['Api-Key' => '73b0659910fa4b88a56919596871a798']
        ]);
    }

    public function buildUrl($endpoint)
    {
        return self::API_BASE_URL . $endpoint;
    }

    public function get($url)
    {
        $res = $this->client->request('GET', $url);

        $apiResponse = json_decode($res->getBody(), true);
        $this->response = new Response($apiResponse);
        return $this->response;
    }

    // getLocation(locationId)
    public function getLocation($locationId)
    {
        // set URL here

    }
}

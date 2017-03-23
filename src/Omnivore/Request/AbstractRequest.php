<?php

namespace Omnivore\Request;

use \GuzzleHttp\Client;

class AbstractRequest {

    const API_BASE_URL = 'https://api.omnivore.io/1.0/locations/';

    protected $methodName = null;
    public $locationId    = null;

    protected $params = null;
    protected $paramsValidation = [];

    public function __construct($params)
    {
        // @TODO validate params
        $this->params = $params;
        $this->client = new \GuzzleHttp\Client([
          'base_uri' => self::API_BASE_URL,
          'headers' => ['Api-Key' => '73b0659910fa4b88a56919596871a798']]);
    }

    public function getLocationId()
    {
        return $this->locationId;
    }

    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
        return $this;
    }

    public function makeRequest()
    {
        /*if (is_null($methodName)) {
            throw new \Exception('No method name set');
        }*/


        $res = $this->client->request('GET', $this->generateRequestUrl());

        // check for response code

        // parse the data based on type

        return json_decode($res->getBody(), true);
    }

}

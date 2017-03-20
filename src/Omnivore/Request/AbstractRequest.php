<?php

namespace Omnivore\Request;

use \GuzzleHttp\Client;

class AbstractRequest {

    const API_BASE_URL = 'https://api.omnivore.io/1.0/';

    protected $methodName = null;
    public $locationId    = null;

    protected $params = null;
    protected $paramsValidation = [];

    public function __construct($params)
    {
        // @TODO validate params
        $this->params = $params;
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

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $this->generateRequestUrl());
        echo $res->getStatusCode();
        // "200"
        echo $res->getHeader('content-type');
        // 'application/json; charset=utf8'
        echo $res->getBody();
    }

}

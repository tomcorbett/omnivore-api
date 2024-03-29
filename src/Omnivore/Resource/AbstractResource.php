<?php

namespace Omnivore\Resource;

use Omnivore\OmnivoreClient;

class AbstractResource
{
    protected $params       = [];
    protected $validation   = [];
    public $locationId      = null;

    const RESOURCE_URL      = null;

    protected $client       = null;

    public function __construct($locationId)
    {
        $this->locationId = $locationId;
        $this->client = new OmnivoreClient();

        //$this->validateParams($params);
        //$this->setParams($params);
    }

    /*public function validateParams($params)
    {
        foreach($this->params as $paramName => $paramType) {
            // check that the param exists in validation
            // @TODO - validate type also
            if (!isset($this->validation[$paramName])) {
                throw new \Exception("Invalid param {$paramName}");
            }
        }
    }*/

    public function getUrl()
    {
        return "locations/" . $this->locationId . "/" . self::RESOURCE_URL;
    }

    public function get($url)
    {
        $res = $this->client->get($url);

        // check for response code

        // parse the data based on type

        return $res;
    }

    public function post($url, $data)
    {
        $res = $this->client->post($url, $data);

        // check for response code

        // parse the data based on type

        return $res;
    }

    public function getAll()
    {

    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /*public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }*/
}

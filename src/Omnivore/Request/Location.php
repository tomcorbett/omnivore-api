<?php

namespace Omnivore\Request;

use Omnivore\Request\AbstractRequest;

class Location extends AbstractRequest {

    protected $methodName = 'locations';

    protected $paramsValidation = [
        'locationId' => 'string'
    ];

    public function generateRequestUrl()
    {
        return self::API_BASE_URL . 'locations/' . $this->params['locationId'];
    }
}

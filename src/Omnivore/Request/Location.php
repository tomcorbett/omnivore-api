<?php

namespace Omnivore\Request;

use Omnivore\Request\AbstractRequest;

class Location extends AbstractRequest {

    protected $paramsValidation = [
        'locationId' => 'string'
    ];

    public function generateRequestUrl()
    {
        return $this->params['locationId'];
    }
}

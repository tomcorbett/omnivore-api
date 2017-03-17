<?php

namespace Tomcorbett\Omnivore;

class Omnivore
{
    protected $apiKey;
    protected $apiSecret;

    public static const ID_BOOM = "GET FROM HERE";

    public function __construct($configKey, $configSecret)
    {
        //var_dump("constructor!!");
        $this->apiKey     = $configKey;
        $this->apiSecret  = $configSecret;
    }

    public function boom()
    {
        echo "YEAH!";
        echo $this->apiSecret;
        echo $this->apiKey;
    }
}

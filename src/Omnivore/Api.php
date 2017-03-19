<?php

namespace Omnivore;

class Api
{
    protected $apiKey;

    public function __construct($configKey)
    {
        $this->apiKey = $configKey;
    }

    public function makeRequest($method, $params)
    {
        $class    = "Omnivore\\Request\\".$method;

        $this->register($class);

        $instance = new $class($params);
        return $instance->makeRequest();
    }

    protected function register($classPath)
    {
        if(!file_exists($classPath)) return false;

        require_once($classPath);

        //if(!class_exists($className)) return false;

        //$classInstance = new $className;

        //if(!method_exists($classInstance, $methodName)) return false;

        //$classInstance->$methodName($args);*/
    }
}

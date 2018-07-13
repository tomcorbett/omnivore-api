<?php
namespace Omnivore;

class Response
{
    protected $data;
    protected $count;
    protected $limit;

    public function __construct($data)
    {
        $this->data = $data;

        if (isset($data['count'])) {
            $this->count = $data['count'];
        }

        if (isset($data['limit'])) {
            $this->limit = $data['limit'];
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function getDataByKey($key)
    {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }

    public function getEmbeddedData()
    {
        if (isset($this->data['_embedded'])) {
            return $this->data['_embedded'];
        } else {
            throw new \Exception('No _embedded returned');
        }
    }

    public function embeddedDataByKeyExists($key)
    {
        $embeddedData = $this->getEmbeddedData();
        return isset($embeddedData[$key]);
    }
    
    public function getEmbeddedDataByKey($key)
    {
        $embeddedData = $this->getEmbeddedData();
        return (isset($embeddedData[$key]) ? $embeddedData[$key] : null);
    }

    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
        return $this;
    }
}

<?php
namespace Omnivore;

class DataObject
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
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
            return null;
        }
    }

    public function getEmbeddedDataByKey($key)
    {
        $embeddedData = $this->getEmbeddedData();
        return (isset($embeddedData[$key]) ? $embeddedData[$key] : null);
    }
}

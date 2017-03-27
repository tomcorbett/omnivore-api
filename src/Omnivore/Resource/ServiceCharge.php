<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class ServiceCharge extends AbstractResource
{
    const RESOURCE_URL = 'service_charges';

    public $id      = null;
    public $name    = null;
    public $comment = null;
    public $price   = null;

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id       = $dataObject->getDataByKey('id');
        $this->name     = $dataObject->getDataByKey('name');
        $this->comment  = $dataObject->getDataByKey('comment');
        $this->price    = $dataObject->getDataByKey('price');
    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

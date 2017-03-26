<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class OrderType extends AbstractResource
{
    const RESOURCE_URL = 'order_types/';

    public $id        = null;
    public $name      = null;
    public $available = null;
    public $posId     = null;

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id         = $dataObject->getDataByKey('id');
        $this->name       = $dataObject->getDataByKey('name');
        $this->available  = $dataObject->getDataByKey('available');
        $this->posId      = $dataObject->getDataByKey('pos_id');
    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class PriceLevel extends AbstractResource
{
    const RESOURCE_URL = 'price_levels/';

    public $id            = null;
    public $name          = null;
    public $pricePerUnit  = null;

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id           = $dataObject->getDataByKey('id');
        $this->name         = $dataObject->getDataByKey('name');
        $this->pricePerUnit = $dataObject->getDataByKey('price_per_unit');
    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

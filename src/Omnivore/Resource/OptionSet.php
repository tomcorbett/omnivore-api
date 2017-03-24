<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class OptionSet extends AbstractResource
{
    const RESOURCE_URL = 'option_sets/';

    public $name      = null;
    public $id        = null;
    public $maximum   = null;
    public $minimum   = null;
    public $required  = null;

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id       = $dataObject->getDataByKey('id');
        $this->maximum  = $dataObject->getDataByKey('maximum');
        $this->minimum  = $dataObject->getDataByKey('minimum');
        $this->required = $dataObject->getDataByKey('required');
    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

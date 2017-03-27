<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class Category extends AbstractResource
{
    const RESOURCE_URL = 'categories';

    public $name  = null;
    public $id    = null;
    public $level = null;
    public $posId = null;

    public function __construct($locationId, DataObject $data)
    {
        parent::__construct($locationId);

        $this->id     = $data->getDataByKey('id');
        $this->name   = $data->getDataByKey('name');
        $this->posId  = $data->getDataByKey('pos_id');
        $this->level  = $data->getDataByKey('level');
    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/{$this->id}";
    }
}

<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;

class Category extends AbstractResource
{
    const RESOURCE_URL = 'categories/';

    public $name  = null;
    public $id    = null;
    public $level = null;
    public $posId = null;

    public function __construct($locationId, $id, $name)
    {
        $this->id   = $id;
        $this->name = $name;
        parent::__construct($locationId);
    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

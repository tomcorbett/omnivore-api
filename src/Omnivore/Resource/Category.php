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
    public $parentCategory = null;

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
    
    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getLevel() {
        return $this->level;
    }

    public function getPosId() {
        return $this->posId;
    }

    public function getParentCategory() {
        return $this->parentCategory;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    public function setPosId($posId) {
        $this->posId = $posId;
        return $this;
    }

    public function setParentCategory(Category $parentCategory) {
        $this->parentCategory = $parentCategory;
        return $this;
    }
}

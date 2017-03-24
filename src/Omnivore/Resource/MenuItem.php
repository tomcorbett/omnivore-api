<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class MenuItem extends AbstractResource
{
    const RESOURCE_URL = 'items/';

    public $name          = null;
    public $id            = null;
    public $inStock       = null;
    public $posId         = null;
    public $open          = null;
    public $pricePerUnit  = null;
    public $optionSets    = [];
    public $priceLevels   = [];

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id           = $dataObject->getDataByKey('id');
        $this->name         = $dataObject->getDataByKey('name');
        $this->inStock      = $dataObject->getDataByKey('in_stock');
        $this->posId        = $dataObject->getDataByKey('pos_id');
        $this->open         = $dataObject->getDataByKey('open');
        $this->pricePerUnit = $dataObject->getDataByKey('price_per_unit');

        $categories = $dataObject->getEmbeddedDataByKey('menu_categories');

        if (!is_null($categories)) {

            foreach ($categories as $category) {
                $this->categories[$category['id']] = new Category($this->locationId, new DataObject($category));
            }
        }

        $optionSets = $dataObject->getEmbeddedDataByKey('option_sets');

        if (!is_null($optionSets)) {

            foreach ($optionSets as $optionSet) {
                $this->optionSets[$optionSet['id']] = new OptionSet($this->locationId, new DataObject($optionSet));
            }
        }

        $priceLevels = $dataObject->getEmbeddedDataByKey('price_levels');

        if (!is_null($priceLevels)) {

            foreach ($priceLevels as $priceLevel) {
                $this->priceLevels[$priceLevel['id']] = new PriceLevel($this->locationId, new DataObject($priceLevel));
            }
        }
    }

    public function getCategories()
    {
        if (!empty($this->categories)) {
            return $this->categories;
        }

        $categories = $this->get($this->getUrl().Category::RESOURCE_URL)->getEmbeddedDataByKey('categories');

        if (!is_null($categories)) {

            foreach ($categories as $category) {
                $this->categories[$category['id']] = new Category($this->locationId, new DataObject($category));
            }
        }

        return $this->categories;
    }

    public function getOptionSets()
    {
        if (!empty($this->optionSets)) {
            return $this->optionSets;
        }

        $optionSets = $this->get($this->getUrl().OptionSet::RESOURCE_URL)->getEmbeddedDataByKey('option_sets');

        if (!is_null($optionSets)) {

            foreach ($optionSets as $optionSet) {
                $this->optionSets[$optionSets['id']] = new OptionSet($this->locationId, new DataObject($optionSet));
            }
        }

        return $this->optionSets;
    }

    public function getPriceLevels()
    {
        if (!empty($this->priceLevels)) {
            return $this->priceLevels;
        }

        $priceLevels = $this->get($this->getUrl().PriceLevel::RESOURCE_URL)->getEmbeddedDataByKey('price_levels');

        if (!is_null($priceLevels)) {

            foreach ($priceLevels as $priceLevel) {
                $this->priceLevels[$priceLevel['id']] = new PriceLevel($this->locationId, new DataObject($priceLevel));
            }
        }

        return $this->priceLevels;
    }


    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

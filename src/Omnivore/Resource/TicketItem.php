<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class TicketItem extends AbstractResource
{
    const RESOURCE_URL = 'items';

    public $id        = null;
    public $comment   = null;
    public $name      = null;
    public $price     = null;
    public $quantity  = null;
    public $sent      = null;
    public $sentAt    = null;
    public $split     = null;
    public $discounts = [];
    public $menuItem  = [];
    public $modifiers = [];

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id       = $dataObject->getDataByKey('id');
        $this->comment  = $dataObject->getDataByKey('comment');
        $this->name     = $dataObject->getDataByKey('name');
        $this->price    = $dataObject->getDataByKey('price');
        $this->quantity = $dataObject->getDataByKey('quantity');
        $this->sent     = $dataObject->getDataByKey('sent');
        $this->sentAt   = $dataObject->getDataByKey('sent_at');
        $this->split    = $dataObject->getDataByKey('split');

        $discounts = $dataObject->getEmbeddedDataByKey('discounts');

        if (!is_null($discounts)) {

            foreach ($discounts as $discount) {
                $this->discounts[$discount['id']] = new Discount($this->locationId, new DataObject($discount));
            }
        }

        $this->menuItem   = new MenuItem($this->locationId, new DataObject($dataObject->getEmbeddedDataByKey('menu_item')));

        $modifiers  = $dataObject->getEmbeddedDataByKey('modifiers');

        if (!is_null($modifiers)) {

            foreach ($modifiers as $modifier) {
                $this->modifiers[$modifier['id']] = new Discount($this->locationId, new DataObject($modifier));
            }
        }
    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

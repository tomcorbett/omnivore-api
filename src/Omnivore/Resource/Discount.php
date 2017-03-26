<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class Discount extends AbstractResource
{
    const RESOURCE_URL = 'discounts/';

    public $id = null;
    public $appliesToItem   = null;
    public $appliesToTicket = null;
    public $available       = null;
    public $maxAmount       = null;
    public $minAmount       = null;
    public $minPercent      = null;
    public $minTicketTotal  = null;
    public $name            = null;
    public $open            = null;
    public $posId           = null;
    public $type            = null;
    public $value           = null;

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id               = $dataObject->getDataByKey('id');
        $this->appliesToItem    = $dataObject->getDataByKey('applies_to')['item'];
        $this->appliesToTicket  = $dataObject->getDataByKey('applies_to')['ticket'];
        $this->available        = $dataObject->getDataByKey('available');
        $this->maxAmount        = $dataObject->getDataByKey('max_amount');
        $this->minAmount        = $dataObject->getDataByKey('min_amount');
        $this->minPercent       = $dataObject->getDataByKey('min_percent');
        $this->minTicketTotal   = $dataObject->getDataByKey('min_ticket_total');
        $this->name             = $dataObject->getDataByKey('name');
        $this->open             = $dataObject->getDataByKey('open');
        $this->posId            = $dataObject->getDataByKey('pos_id');
        $this->type             = $dataObject->getDataByKey('type');
        $this->value            = $dataObject->getDataByKey('value');
        $this->amount           = $dataObject->getDataByKey('amount');

    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

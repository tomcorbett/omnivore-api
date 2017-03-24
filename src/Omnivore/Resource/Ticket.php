<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class Ticket extends AbstractResource
{
    const RESOURCE_URL    = 'tickets/';

    public $id            = null;
    public $name          = null;
    public $autoSend      = null;
    public $closedAt      = null;
    public $guestCount    = null;
    public $open          = null;
    public $openedAt      = null;
    public $ticketNumber  = null;
    public $void          = null;
    public $totals        = [];

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId, $dataObject);

        $this->id           = $dataObject->getDataByKey('id');
        $this->name         = $dataObject->getDataByKey('name');
        $this->autoSend     = $dataObject->getDataByKey('auto_send');
        $this->closedAt     = $dataObject->getDataByKey('closed_at');
        $this->guestCount   = $dataObject->getDataByKey('guest_count');
        $this->open         = $dataObject->getDataByKey('open');
        $this->openedAt     = $dataObject->getDataByKey('opened_at');
        $this->ticketNumber = $dataObject->getDataByKey('ticket_number');
        $this->void         = $dataObject->getDataByKey('void');
        $this->totals       = $dataObject->getDataByKey('totals');
        /*
        $totals = [
          "discounts" => $dataObject->getDataByKey('void'),
          "due" => $dataObject->getDataByKey('void'),
          "items" => $dataObject->getDataByKey('void'),
          "other_charges" => $dataObject->getDataByKey('void'),
          "paid" => $dataObject->getDataByKey('void'),
          "service_charges" => $dataObject->getDataByKey('void'),
          "sub_total" => $dataObject->getDataByKey('void'),
          "tax" => $dataObject->getDataByKey('void'),
          "tips" => $dataObject->getDataByKey('void'),
          "total" => $dataObject->getDataByKey('void')
        ];
        */
    }
}

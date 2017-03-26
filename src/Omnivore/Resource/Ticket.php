<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\Resource\Discount;
use Omnivore\DataObject;

class Ticket extends AbstractResource
{
    const RESOURCE_URL    = 'tickets/';

    public $id              = null;
    public $name            = null;
    public $autoSend        = null;
    public $closedAt        = null;
    public $guestCount      = null;
    public $open            = null;
    public $openedAt        = null;
    public $ticketNumber    = null;
    public $void            = null;
    public $totals          = [];
    public $discounts       = [];
    public $employee        = null;
    public $items           = [];
    public $orderType       = null;
    public $payments        = [];
    public $revenueCenter   = null;
    public $serviceCharges  = [];
    public $voidedItems     = [];

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId, $dataObject);

        $this->id           = $dataObject->getDataByKey('id');
        $this->name         = $dataObject->getDataByKey('name');
        $this->autoSend     = $dataObject->getDataByKey('auto_send');
        $this->closedAt     = $dataObject->getDataByKey('closed_at');
        $this->guestCount   = $dataObject->getDataByKey('guest_count');
        $this->open         = $dataObject->getDataByKey('open');
        $this->openedAt     = new \DateTime();
        $this->openedAt     = $this->openedAt->setTimestamp($dataObject->getDataByKey('opened_at'));
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
        $discounts = $dataObject->getEmbeddedDataByKey('discounts');

        if (!is_null($discounts)) {

            foreach ($discounts as $discount) {
                $this->discounts[$discount['id']] = new Discount($this->locationId, new DataObject($discount));
            }
        }

        $this->employee = new Employee($this->locationId, new DataObject($dataObject->getEmbeddedDataByKey('employee')));

        $items = $dataObject->getEmbeddedDataByKey('items');

        if (!is_null($items)) {

            foreach ($items as $item) {
                $this->items[$item['id']] = new TicketItem($this->locationId, new DataObject($item));
            }
        }

        $this->orderType = new OrderType($this->locationId, new DataObject($dataObject->getEmbeddedDataByKey('order_type')));

        $this->revenueCenter = new RevenueCenter($this->locationId, new DataObject($dataObject->getEmbeddedDataByKey('revenue_center')));

        $serviceCharges = $dataObject->getEmbeddedDataByKey('service_charges');

        if (!is_null($serviceCharges)) {

            foreach ($serviceCharges as $serviceCharge) {
                $this->serviceCharges[$item['id']] = new ServiceCharge($this->locationId, new DataObject($serviceCharge));
            }
        }

        // @TODO implement this as object
        $this->voidedItems = $dataObject->getEmbeddedDataByKey('voided_items');
    }

    public function getDiscounts()
    {
        if (!$this->discounts) {
            return $this->discounts;
        }

        $discounts = $dataObject->getEmbeddedDataByKey('discounts');

        if (!is_null($discounts)) {

            foreach ($discounts as $discount) {
                $this->discounts[$discount['id']] = new Discount($this->locationId, new DataObject($discount));
            }
        }
    }
}

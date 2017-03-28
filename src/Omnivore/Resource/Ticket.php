<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\Resource\Discount;
use Omnivore\DataObject;

class Ticket extends AbstractResource
{
    const RESOURCE_URL    = 'tickets';

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

        if (!empty($discounts)) {

            foreach ($discounts as $discount) {
                $this->discounts[$discount['id']] = new Discount($this->locationId, new DataObject($discount));
            }
        }

        $this->employee = new Employee($this->locationId, new DataObject($dataObject->getEmbeddedDataByKey('employee')));

        $items = $dataObject->getEmbeddedDataByKey('items');

        if (!empty($items)) {

            foreach ($items as $item) {
                $this->items[$item['id']] = new TicketItem($this->locationId, new DataObject($item));
            }
        }

        $this->orderType = new OrderType($this->locationId, new DataObject($dataObject->getEmbeddedDataByKey('order_type')));

        $this->revenueCenter = new RevenueCenter($this->locationId, new DataObject($dataObject->getEmbeddedDataByKey('revenue_center')));

        $serviceCharges = $dataObject->getEmbeddedDataByKey('service_charges');

        if (!empty($serviceCharges)) {

            foreach ($serviceCharges as $serviceCharge) {
                $this->serviceCharges[$serviceCharge['id']] = new ServiceCharge($this->locationId, new DataObject($serviceCharge));
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

    public function addItem(MenuItem $item, $options)
    {
        if (!isset($options['quantity']) && !empty($options['quantity'])) {
            throw new \Exception("No quantity provided");
        }

        if (!isset($options['price_level']) && !empty($options['price_level'])) {
            throw new \Exception("No price_level provided");
        }

        if (!isset($options['comment']) && !empty($options['comment'])) {
            throw new \Exception("No comment provided");
        }

        // @TODO - implement modifiers

        $ticketData = [
            'menu_item'   => $item->id,
            'quantity'    => $options['quantity'],
            'price_level' => $options['price_level'],
            'comment'     => $options['comment'],
            'modifiers'   => []
        ];

        // note here we have to add on array not just an object (not what docs says)
        $response = $this->post($this->getUrl().'/'.$this->id."/".MenuItem::RESOURCE_URL, [$ticketData]);

        return new Ticket($this->locationId, new DataObject($response->getData()));
    }
}

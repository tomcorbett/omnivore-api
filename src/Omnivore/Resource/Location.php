<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\Resource\Category;
use Omnivore\Resource\Menu;
use Omnivore\Resource\Ticket;
use Omnivore\DataObject;

class Location extends AbstractResource
{
    protected $resourceUrl    = '';
    protected $tickets        = [];
    protected $employees      = [];
    protected $tables         = [];
    protected $priceCheck     = [];
    protected $tenderTypes    = [];
    protected $orderTypes     = [];
    protected $clockEntries   = [];
    protected $discounts      = [];

    public function getMenu()
    {
        $this->menu = new Menu($this->locationId);
        return $this->menu;
    }


    public function getTickets()
    {
        if (!empty($this->tickets)) {
            return $this->tickets;
        }

        $response = $this->get($this->getUrl().Ticket::RESOURCE_URL);
        $tickets  = $response->getEmbeddedDataByKey('tickets');

        if (!is_null($tickets)) {
            foreach ($tickets as $ticket) {
                $this->tickets[$ticket['id']] = new Ticket($this->locationId, new DataObject($ticket));
            }
        }

        return $this->tickets;
    }

    public function getEmployees()
    {
        return $this->employees;
    }

    public function getTables()
    {
        return $this->tables;
    }

    public function getRevenueCenters()
    {
        return $this->revenueCenters;
    }

    public function getPriceCheck()
    {
        return $this->priceCheck;
    }

    public function getTenderTypes()
    {
        return $this->tenderTypes;
    }

    public function getOrderTypes()
    {
        return $this->orderTypes;
    }

    public function getClockEntries()
    {
        return $this->clockEntries;
    }

    public function getDiscounts()
    {
        return $this->discounts;
    }
}

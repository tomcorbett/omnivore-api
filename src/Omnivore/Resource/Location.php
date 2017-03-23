<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\Resource\Category;
use Omnivore\Resource\Menu;

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
        return $this->tickets;
    }

    public function setTickets($tickets)
    {

    }

    public function getEmployees()
    {
        return $this->employees;
    }

    public function setEmployees($employees)
    {

    }

    public function getTables()
    {
        return $this->tables;
    }

    public function setTables($tables)
    {

    }

    public function getRevenueCenters()
    {
        return $this->revenueCenters;
    }

    public function setRevenueCenters($revenueCenters)
    {

    }

    public function getPriceCheck()
    {
        return $this->priceCheck;
    }

    public function setPriceCheck($priceCheck)
    {

    }

    public function getTenderTypes()
    {
        return $this->tenderTypes;
    }

    public function setTenderTypes($categories)
    {

    }

    public function getOrderTypes()
    {
        return $this->orderTypes;
    }

    public function setOrderTypes($orderTypes)
    {

    }

    public function getClockEntries()
    {
        return $this->clockEntries;
    }

    public function setClockEntries($clockEntries)
    {

    }

    public function getDiscounts()
    {
        return $this->discounts;
    }

    public function setDiscounts($discounts)
    {

    }
}

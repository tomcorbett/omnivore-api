<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\Resource\Category;
use Omnivore\Resource\Menu;
use Omnivore\Resource\Ticket;
use Omnivore\DataObject;

class Location extends AbstractResource
{
    protected $id;
    
    protected $resourceUrl    = '';
    protected $tickets        = [];
    protected $openTickets    = [];
    protected $employees      = [];
    protected $categories     = [];
    protected $tables         = [];
    protected $priceCheck     = [];
    protected $tenderTypes    = [];
    protected $orderTypes     = [];
    protected $clockEntries   = [];
    protected $discounts      = [];
    
    public $address = [];
    public $conceptName;
    public $created;
    public $development;
    public $displayName;
    public $googlePlaceId;
    public $health;
    public $latitude;
    public $longitude;
    public $modified;
    public $name;
    public $owner;
    public $phone;
    public $posType;
    public $status;
    public $timezone;
    public $website;

    public function __construct($locationId) {
        parent::__construct($locationId);
        
        $response = $this->get($this->getUrl());
        
        $location = new DataObject($response->getData());
        
        $this->id = $location->getDataByKey('id');
        $this->address = $location->getDataByKey('address');
        $this->conceptName = $location->getDataByKey('concept_name');
        $this->created = new \DateTime();
        $this->created->setTimestamp($location->getDataByKey('created'));
        $this->development = $location->getDataByKey('development');
        $this->displayName = $location->getDataByKey('display_name');
        $this->googlePlaceId = $location->getDataByKey('google_place_id');
        $this->health = $location->getDataByKey('health');
        $this->latitude = $location->getDataByKey('latitude');
        $this->longitude = $location->getDataByKey('longitude');
        $this->modified = new \DateTime();
        $this->modified->setTimestamp($location->getDataByKey('modified'));
        $this->name = $location->getDataByKey('name');
        $this->owner = $location->getDataByKey('owner');
        $this->phone = $location->getDataByKey('phone');
        $this->posType = $location->getDataByKey('pos_type');
        $this->status = $location->getDataByKey('status');
        $this->timezone = $location->getDataByKey('timezone');
        $this->website = $location->getDataByKey('website');
    }
    
    public function getMenu()
    {
        $this->menu = new Menu($this->locationId);
        return $this->menu;
    }

    public function getTickets($start = 0, $limit = 100, array $options = [])
    {
        if (!empty($this->tickets)) {
            return $this->tickets;
        }
        
        $url = $this->getUrl().Ticket::RESOURCE_URL.'?start='.$start.'&limit='.$limit;
        
        if (isset($options['after']) && $options['after'] instanceof \DateTime) {
            $url .= "and(gt(closed_at,{$options['after']->format('U')},eq(open,false)";
        }
        
        $response = $this->get($url);
        $tickets  = $response->getEmbeddedDataByKey('tickets');

        if (!is_null($tickets)) {
            foreach ($tickets as $ticket) {
                $this->tickets[$ticket['id']] = new Ticket($this->locationId, new DataObject($ticket));
            }
        }

        return $this->tickets;
    }

    public function getOpenTickets()
    {
        if (!empty($this->openTickets)) {
            return $this->openTickets;
        }

        $response = $this->get($this->getUrl().Ticket::RESOURCE_URL.'?where=eq(open,true)');
        $openTickets  = $response->getEmbeddedDataByKey('tickets');

        if (!empty($openTickets)) {
            foreach ($openTickets as $ticket) {
                $this->openTickets[$ticket['id']] = new Ticket($this->locationId, new DataObject($ticket));
            }
        }

        // @TODO - merge into $this->tickets

        return $this->openTickets;
    }

    public function getTicketById($id)
    {
        if (isset($this->tickets[$id]) && !empty($this->tickets[$id])) {
            return $this->tickets[$id];
        }

        $response = $this->get($this->getUrl().Ticket::RESOURCE_URL.'/'.$id);
        $ticket   = $response->getData();

        if (!empty($ticket)) {
            $this->tickets[$id] = new Ticket($this->locationId, new DataObject($ticket));
        }

        return $this->tickets[$id];
    }

    public function getEmployees()
    {
        if (!empty($this->employees)) {
            return $this->employees;
        }

        $response   = $this->get($this->getUrl().'/'.Employee::RESOURCE_URL);
        $employees  = $response->getEmbeddedDataByKey('employees');

        if (!is_null($employees)) {
            foreach ($employees as $employee) {
                $this->employees[$employee['id']] = new Employee($this->locationId, new DataObject($employee));
            }
        }

        return $this->employees;
    }
    
    public function getCategories()
    {
        if (!empty($this->categories)) {
            return $this->categories;
        }

        $response   = $this->get($this->getUrl().'/'.Category::RESOURCE_URL);
        $categories  = $response->getEmbeddedDataByKey('categories');

        if (!is_null($categories)) {
            foreach ($categories as $category) {
                $this->categories[$category['id']] = new Category($this->locationId, new DataObject($category));
            }
        }

        return $this->employees;
    }
    
    public function getCategory($categoryId)
    {
        if (!empty($this->categories[$categoryId])) {
            return $this->categories[$categoryId];
        }

        $response = $this->get($this->getUrl().'/menu/'.Category::RESOURCE_URL.'/'.$categoryId);
        $category = $response->getData();
        $categoryObject = new Category($this->locationId, new DataObject($category));
        
        // check if it has a parent category
        if ($response->embeddedDataByKeyExists('parent_category')) {
            $parent = $response->getEmbeddedDataByKey('parent_category');
            $categoryObject->setParentCategory(new Category($this->locationId, new DataObject($parent)));
        }

        $this->categories[$categoryId] = $categoryObject;
        
        return $this->categories[$categoryId];
    }

    public function getTables()
    {
        if (!empty($this->tables)) {
            return $this->tables;
        }

        $response = $this->get($this->getUrl().'/'.Table::RESOURCE_URL);
        $tables   = $response->getEmbeddedDataByKey('tables');

        if (!is_null($tables)) {
            foreach ($tables as $table) {
                $this->tables[$table['id']] = new Table($this->locationId, new DataObject($table));
            }
        }

        return $this->tables;
    }

    public function getRevenueCenters()
    {
        if (!empty($this->revenueCenters)) {
            return $this->revenueCenters;
        }

        $response       = $this->get($this->getUrl().'/'.RevenueCenter::RESOURCE_URL);
        $revenueCenters = $response->getEmbeddedDataByKey('revenue_centers');

        if (!is_null($revenueCenters)) {

            foreach ($revenueCenters as $revenueCenter) {
                $this->revenueCenters[$revenueCenter['id']] = new RevenueCenter($this->locationId, new DataObject($revenueCenter));
            }
        }

        return $this->revenueCenters;
    }

    public function getPriceCheck()
    {
        return $this->priceCheck;
    }

    public function getTenderTypes()
    {
        if (!empty($this->tenderTypes)) {
            return $this->tenderTypes;
        }

        $response    = $this->get($this->getUrl().'/'.TenderType::RESOURCE_URL);
        $tenderTypes = $response->getEmbeddedDataByKey('tender_types');

        if (!is_null($tenderTypes)) {

            foreach ($tenderTypes as $tenderType) {
                $this->tenderTypes[$tenderType['id']] = new TenderType($this->locationId, new DataObject($tenderType));
            }
        }

        return $this->tenderTypes;
    }

    public function getOrderTypes()
    {
        if (!empty($this->orderTypes)) {
            return $this->orderTypes;
        }

        $response   = $this->get($this->getUrl().'/'.OrderType::RESOURCE_URL);
        $orderTypes = $response->getEmbeddedDataByKey('order_types');

        if (!is_null($orderTypes)) {

            foreach ($orderTypes as $orderType) {
                $this->orderTypes[$orderType['id']] = new OrderType($this->locationId, new DataObject($orderType));
            }
        }

        return $this->orderTypes;
    }

    public function getClockEntries()
    {
        if (!empty($this->clockEntries)) {
            return $this->clockEntries;
        }

        $response     = $this->get($this->getUrl().'/'.ClockEntry::RESOURCE_URL);
        $clockEntries = $response->getEmbeddedDataByKey('clock_entries');

        if (!is_null($clockEntries)) {

            foreach ($clockEntries as $clockEntry) {
                $this->clockEntries[$clockEntry['id']] = new ClockEntry($this->locationId, new DataObject($clockEntry));
            }
        }

        return $this->clockEntries;
    }

    public function getDiscounts()
    {
        if (!empty($this->discounts)) {
            return $this->discounts;
        }

        $response   = $this->get($this->getUrl().'/'.Discount::RESOURCE_URL);
        $discounts  = $response->getEmbeddedDataByKey('discounts');

        if (!is_null($discounts)) {

            foreach ($discounts as $discount) {
                $this->discounts[$discount['id']] = new Discount($this->locationId, new DataObject($discount));
            }
        }

        return $this->discounts;
    }

    public function addTicket(Array $ticketData)
    {
        if (!isset($ticketData['employee'])) {
            throw new \Exception('No valid employee given');
        }

        if (!isset($ticketData['order_type'])) {
            throw new \Exception('No valid order_type given');
        }

        if (!isset($ticketData['revenue_center'])) {
            throw new \Exception('No valid revenue_center given');
        }

        if (!isset($ticketData['table'])) {
            throw new \Exception('No valid table given');
        }

        if (!isset($ticketData['guest_count'])) {
            throw new \Exception('No valid guest_count given');
        }

        if (!isset($ticketData['name'])) {
            throw new \Exception('No valid name given');
        }

        if (!isset($ticketData['auto_send'])) {
            throw new \Exception('No valid auto_send given');
        }

        $response = $this->post($this->getUrl().'/'.Ticket::RESOURCE_URL, $ticketData);
        return new Ticket($this->locationId, new DataObject($response->getData()));
    }
    
    public function getId() {
        return $this->id;
    }
}

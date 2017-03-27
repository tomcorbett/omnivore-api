<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class  Employee extends AbstractResource
{
    const RESOURCE_URL = 'employees';

    public $id            = null;
    public $firstName     = null;
    public $lastName      = null;
    public $checkName     = null;
    public $login         = null;
    public $posId         = null;
    public $clockEntries  = [];
    public $openTickets   = [];

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id         = $dataObject->getDataByKey('id');
        $this->firstName  = $dataObject->getDataByKey('first_name');
        $this->lastName   = $dataObject->getDataByKey('last_name');
        $this->checkName  = $dataObject->getDataByKey('check_name');
        $this->login      = $dataObject->getDataByKey('login');
        $this->posId      = $dataObject->getDataByKey('pos_id');
    }

    public function getClockEntries()
    {
        if (!empty($this->clockEntries)) {
            return $this->clockEntries;
        }

        $clockEntries = $this->get($this->getUrl().'/'.ClockEntry::RESOURCE_URL."?where=eq(@employee.id,'{$this->id}')")->getEmbeddedDataByKey('clock_entries');

        if (!is_null($clockEntries)) {

            foreach ($clockEntries as $clockEntry) {
                $this->categories[$clockEntry['id']] = new ClockEntry($this->locationId, new DataObject($clockEntry));
            }
        }

        return $this->clockEntries;
    }

    public function getOpenTickets()
    {

    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

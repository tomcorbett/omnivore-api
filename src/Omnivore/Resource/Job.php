<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\Resource\ClockEntry;
use Omnivore\DataObject;

class Job extends AbstractResource
{
    const RESOURCE_URL = 'clock_entries/';

    public $id            = null;
    public $name          = null;
    public $posId         = null;
    public $clockEntries  = [];

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id     = $dataObject->getDataByKey('id');
        $this->name   = $dataObject->getDataByKey('name');
        $this->posId  = $dataObject->getDataByKey('pos_id');
    }

    public function getClockEntries()
    {
        if (!empty($this->clockEntries)) {
            return $this->clockEntries;
        }

        $clockEntries = $this->get($this->getUrl().ClockEntry::RESOURCE_URL."?where=eq(@employee.id,'{$this->id}')")->getEmbeddedDataByKey('clock_entries');

        if (!is_null($clockEntries)) {

            foreach ($clockEntries as $clockEntry) {
                $this->categories[$clockEntry['id']] = new ClockEntry($this->locationId, new DataObject($clockEntry));
            }
        }

        return $this->clockEntries;
    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

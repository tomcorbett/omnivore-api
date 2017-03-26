<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class ClockEntry extends AbstractResource
{
    const RESOURCE_URL = 'clock_entries/';

    public $id        = null;
    public $clockIn   = null;
    public $clockOut  = null;
    public $employee  = null;
    public $job       = null;

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id       = $dataObject->getDataByKey('id');
        $this->clockIn  = $dataObject->getDataByKey('clock_in');
        $this->clockOut = $dataObject->getDataByKey('clock_out');
        $this->employee = new Employee($this->locationId, $dataObject->getEmbeddedDataByKey('employee'));
        $this->job      = new Job($this->locationId, $dataObject->getEmbeddedDataByKey('job'));
    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

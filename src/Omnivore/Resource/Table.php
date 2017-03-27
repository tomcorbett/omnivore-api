<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class Table extends AbstractResource
{
    const RESOURCE_URL = 'tables';

    public $id            = null;
    public $name          = null;
    public $number        = null;
    public $available     = null;
    public $seats         = null;
    public $posId         = null;
    public $openTickets   = [];
    public $revenueCenter = null;

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id         = $dataObject->getDataByKey('id');
        $this->name       = $dataObject->getDataByKey('name');
        $this->available  = $dataObject->getDataByKey('available');
        $this->posId      = $dataObject->getDataByKey('pos_id');

        $this->revenueCenter = new RevenueCenter($this->locationId, new DataObject($dataObject->getEmbeddedDataByKey('revenue_center')));
    }

    public function getOpenTickets()
    {
        if (!$this->openTickets) {
            return $this->openTickets;
        }

        $openTickets = $dataObject->getEmbeddedDataByKey('tickets');

        if (!is_null($openTickets)) {

            foreach ($openTickets as $openTicket) {
                $this->openTickets[$openTicket['id']] = new Ticket($this->locationId, new DataObject($openTicket));
            }
        }
    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

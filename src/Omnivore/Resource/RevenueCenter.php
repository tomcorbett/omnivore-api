<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class RevenueCenter extends AbstractResource
{
    const RESOURCE_URL = 'revenue_centers';

    public $id          = null;
    public $name        = null;
    public $default     = null;
    public $posId       = null;
    public $openTickets = [];

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id       = $dataObject->getDataByKey('id');
        $this->name     = $dataObject->getDataByKey('name');
        $this->default  = $dataObject->getDataByKey('default');
        $this->posId    = $dataObject->getDataByKey('pos_id');
    }

    public function getOpenTickets()
    {
        if (!empty($this->openTickets)) {
            return $this->openTickets;
        }

        $response     = $this->get($this->getUrl().'/'.Ticket::RESOURCE_URL."?where=and(eq(open,true),eq(@revenue_center.id,'{$this->id}'))");
        $openTickets  = $response->getEmbeddedDataByKey('tickets');

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

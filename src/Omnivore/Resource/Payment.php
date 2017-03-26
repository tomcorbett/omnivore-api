<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class Payment extends AbstractResource
{
    const RESOURCE_URL = 'payments/';

    public $id          = null;
    public $amount      = null;
    public $change      = null;
    public $comment     = null;
    public $last4       = null;
    public $tip         = null;
    public $type        = null;
    public $tenderTypes = [];

    public function __construct($locationId, DataObject $dataObject)
    {
        parent::__construct($locationId);

        $this->id       = $dataObject->getDataByKey('id');
        $this->amount   = $dataObject->getDataByKey('amount');
        $this->change   = $dataObject->getDataByKey('change');
        $this->comment  = $dataObject->getDataByKey('comment');
        $this->last4    = $dataObject->getDataByKey('last4');
        $this->tip      = $dataObject->getDataByKey('tip');
        $this->type     = $dataObject->getDataByKey('type');

        $tenderTypes    = $dataObject->getEmbeddedDataByKey('tender_types');

        if (!is_null($tenderTypes)) {

            foreach ($tenderTypes as $tenderType) {
                $this->tenderTypes[$tenderType['id']] = new Discount($this->locationId, new DataObject($tenderType));
            }
        }
    }

    public function getTenderTypes()
    {
        if (!empty($this->tenderTypes)) {
            return $this->tenderTypes;
        }

        $response     = $this->get($this->getUrl().MenuItem::RESOURCE_URL);
        $tenderTypes  = $response->getEmbeddedDataByKey('tender_types');

        if (!is_null($tenderTypes)) {

            foreach ($tenderTypes as $tenderType) {
                $this->tenderTypes[$tenderType['id']] = new TenderType($this->locationId, new DataObject($tenderType));
            }
        }
    }

    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

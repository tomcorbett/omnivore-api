<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\DataObject;

class Payment extends AbstractResource
{
    const RESOURCE_URL = 'payments';

    public $id          = null;
    public $amount      = null;
    public $change      = null;
    public $comment     = null;
    public $fullName    = null;
    public $last4       = null;
    public $tip         = null;
    public $type        = null;
    public $tenderType  = null;

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
        $this->fullName = $dataObject->getDataByKey('full_name');

        $tenderType    = $dataObject->getEmbeddedDataByKey('tender_type');

        if (!is_null($tenderType)) {
            $this->tenderType = new TenderType($this->locationId, new DataObject($tenderType));
        }
    }

    public function getTenderType()
    {
        return $this->tenderType;
    }

    /**
     * NOT RIGHT
     */
    public function getUrl()
    {
        return "locations/{$this->locationId}/" . $this->id;
    }
}

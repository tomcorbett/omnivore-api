<?php
namespace Omnivore;

class Response
{
    protected $embedded;
    protected $count;
    protected $limit;

    public function __construct($data)
    {
        if (isset($data['_embedded'])) {
            $this->embedded = $data['_embedded'];
        } else {
            throw new Exception('No _embedded returned');
        }

        if (isset($data['count'])) {
            $this->count = $data['count'];
        }

        if (isset($data['limit'])) {
            $this->limit = $data['limit'];
        }
    }

    public function getData()
    {
        return $this->embedded;
    }
}

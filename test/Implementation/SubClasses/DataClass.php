<?php

namespace Downsider\Clay\Test\Implementation\SubClasses;
use Downsider\Clay\Test\Implementation\BaseClass;

/**
 * DataClass
 */
class DataClass extends BaseClass
{

    protected $data = [];

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

}
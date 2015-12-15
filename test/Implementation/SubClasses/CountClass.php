<?php

namespace Downsider\Clay\Test\Implementation\SubClasses;
use Downsider\Clay\Test\Implementation\BaseClass;

/**
 * CountClass
 */
class CountClass extends BaseClass
{

    protected $count;

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

}
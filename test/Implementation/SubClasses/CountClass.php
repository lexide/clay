<?php

namespace Lexide\Clay\Test\Implementation\SubClasses;
use Lexide\Clay\Test\Implementation\BaseClass;

/**
 * CountClass
 */
class CountClass extends BaseClass
{
    /**
     * @var mixed
     */
    protected $count;

    /**
     * @return mixed
     */
    public function getCount(): mixed
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount(mixed $count)
    {
        $this->count = $count;
    }

}

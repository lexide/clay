<?php

namespace Downsider\Clay\Test\Implementation\SubClasses;
use Downsider\Clay\Test\Implementation\BaseClass;

/**
 * NameClass
 */
class NameClass extends BaseClass
{

    protected $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}
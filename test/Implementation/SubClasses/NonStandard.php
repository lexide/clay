<?php

namespace Lexide\Clay\Test\Implementation\SubClasses;
use Lexide\Clay\Test\Implementation\BaseClass;

/**
 * NonStandard
 */
class NonStandard extends BaseClass
{

    protected $unusual;

    /**
     * @return mixed
     */
    public function getUnusual()
    {
        return $this->unusual;
    }

    /**
     * @param mixed $unusual
     */
    public function setUnusual($unusual)
    {
        $this->unusual = $unusual;
    }

}

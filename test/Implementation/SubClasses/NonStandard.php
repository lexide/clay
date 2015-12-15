<?php

namespace Downsider\Clay\Test\Implementation\SubClasses;
use Downsider\Clay\Test\Implementation\BaseClass;

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
<?php

namespace Lexide\Clay\Test\Implementation\SubClasses;
use Lexide\Clay\Test\Implementation\BaseClass;

/**
 * NonStandard
 */
class NonStandard extends BaseClass
{
    /**
     * @var mixed
     */
    protected $unusual;

    /**
     * @return mixed
     */
    public function getUnusual(): mixed
    {
        return $this->unusual;
    }

    /**
     * @param mixed $unusual
     */
    public function setUnusual(mixed $unusual)
    {
        $this->unusual = $unusual;
    }

}

<?php

namespace Lexide\Clay\Test\Implementation\SubClasses;
use Lexide\Clay\Test\Implementation\BaseClass;

/**
 * NameClass
 */
class NameClass extends BaseClass
{
    /**
     * @var mixed
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getName(): mixed
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(mixed $name): void
    {
        $this->name = $name;
    }

}

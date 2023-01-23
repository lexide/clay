<?php

namespace Lexide\Clay\Test\Implementation\SubClasses;
use Lexide\Clay\Test\Implementation\BaseClass;

/**
 * DataClass
 */
class DataClass extends BaseClass
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

}

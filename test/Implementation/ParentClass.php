<?php

namespace Lexide\Clay\Test\Implementation;

use Lexide\Clay\Exception\ModelException;
use Lexide\Clay\Model\ModelTrait;

/**
 * ParentClass
 */
class ParentClass
{
    use ModelTrait;

    /**
     * @var BaseClass
     */
    protected $single;

    /**
     * @var array
     */
    protected $multiple = [];

    /**
     * @param array $data
     * @throws ModelException
     * @throws \ReflectionException
     */
    public function __construct(array $data = [])
    {
        $this->loadData($data);
    }

    /**
     * @return mixed
     */
    public function getSingle(): mixed
    {
        return $this->single;
    }

    /**
     * @param BaseClass $single
     */
    public function setSingle(BaseClass $single)
    {
        $this->single = $single;
    }

    /**
     * @return array
     */
    public function getMultiple(): array
    {
        return $this->multiple;
    }

    /**
     * @param array $multiple
     */
    public function setMultiple(array $multiple)
    {
        $this->multiple = [];
        foreach ($multiple as $single) {
            $this->addMultiple($single);
        }
    }

    /**
     * @param BaseClass $single
     */
    public function addMultiple(BaseClass $single)
    {
        $this->multiple[] = $single;
    }



}

<?php

namespace Downsider\Clay\Test\Implementation;

use Downsider\Clay\Model\ModelTrait;

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

    public function __construct(array $data = [])
    {
        $this->loadData($data);
    }

    /**
     * @return BaseClass
     */
    public function getSingle()
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
    public function getMultiple()
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

    public function addMultiple(BaseClass $single)
    {
        $this->multiple[] = $single;
    }



}
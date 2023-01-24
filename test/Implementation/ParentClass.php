<?php

namespace Lexide\Clay\Test\Implementation;

use Lexide\Clay\Exception\ModelException;
use Lexide\Clay\Model\ModelTrait;

class ParentClass
{
    use ModelTrait;

    /**
     * @var BaseClass
     */
    protected $single;

    /**
     * @var BaseClass[]
     */
    protected $multiple = [];

    /**
     * @var ChildClass
     */
    protected $child;

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
     * @return ?BaseClass
     */
    public function getSingle(): ?BaseClass
    {
        return $this->single;
    }

    /**
     * @param BaseClass $single
     */
    public function setSingle(BaseClass $single): void
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
    public function setMultiple(array $multiple): void
    {
        $this->multiple = [];
        foreach ($multiple as $single) {
            $this->addMultiple($single);
        }
    }

    /**
     * @param BaseClass $single
     */
    public function addMultiple(BaseClass $single): void
    {
        $this->multiple[] = $single;
    }

    /**
     * @param ChildClass $child
     */
    public function setChild(ChildClass $child): void
    {
        $this->child = $child;
    }

    /**
     * @return ?ChildClass
     */
    public function getChild(): ?ChildClass
    {
        return $this->child;
    }

}

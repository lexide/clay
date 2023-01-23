<?php

namespace Lexide\Clay\Test\Implementation;

use Lexide\Clay\Exception\ModelException;
use Lexide\Clay\Model\ModelTrait;

class ChildClass
{
    use ModelTrait;

    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $description;

    /**
     * @param array $data
     * @throws ModelException
     * @throws \ReflectionException
     */
    public function __construct(array $data)
    {
        $this->loadData($data);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }


}
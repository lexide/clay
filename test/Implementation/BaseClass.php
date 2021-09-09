<?php

namespace Lexide\Clay\Test\Implementation;
use Lexide\Clay\Exception\ModelException;
use Lexide\Clay\Model\ModelTrait;

/**
 * BaseClass
 */
class BaseClass
{
    use ModelTrait;

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var mixed
     */
    protected $type;

    /**
     * @var array
     */
    protected $modelDiscriminatorMap = [
        "discriminatorField" => "type",
        "subclassNamespace" => "Lexide\\Clay\\Test\\Implementation\\SubClasses",
        "subclassSuffix" => "Class",
        "map" => [
            "name" => true,
            "data" => true,
            "count" => true,
            "sizeOf" => "CountClass",
            "weird" => "Lexide\\Clay\\Test\\Implementation\\SubClasses\\NonStandard"
        ]
    ];

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
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(mixed $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getType(): mixed
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType(mixed $type)
    {
        $this->type = $type;
    }


}

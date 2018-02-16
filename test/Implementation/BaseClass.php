<?php

namespace Lexide\Clay\Test\Implementation;
use Lexide\Clay\Model\ModelTrait;

/**
 * BaseClass
 */
class BaseClass
{
    use ModelTrait;

    protected $id;

    protected $type;

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

    public function __construct(array $data = [])
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
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}

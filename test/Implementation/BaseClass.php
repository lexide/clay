<?php

namespace Downsider\Clay\Test\Implementation;
use Downsider\Clay\Model\ModelTrait;

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
        "subclassNamespace" => "Downsider\\Clay\\Test\\Implementation\\SubClasses",
        "subclassSuffix" => "Class",
        "map" => [
            "sizeOf" => "CountClass",
            "weird" => "Downsider\\Clay\\Test\\Implementation\\SubClasses\\NonStandard"
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
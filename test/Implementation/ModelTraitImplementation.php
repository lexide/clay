<?php

namespace Lexide\Clay\Test\Implementation;

use Lexide\Clay\Exception\ModelException;
use Lexide\Clay\Model\ModelTrait;

/**
 * a "Stub" class to implement the ModelTrait class
 */
class ModelTraitImplementation 
{
    use ModelTrait;

    /**
     * @var ?string
     */
    protected $prop1;

    /**
     * @var ?string
     */
    protected $prop2;

    /**
     * @var ?string
     */
    protected $prop3;

    /**
     * @var ?string
     */
    protected $camelCaseProp1;

    /**
     * @var ?string
     */
    protected $camelCaseProp2;

    /**
     * @var ?string
     */
    protected $noSetterProp;

    /**
     * @var ?object
     */
    protected $objectProp;

    /**
     * @var ?array
     */
    protected $arrayProp;

    /**
     * @var ?array
     */
    protected $collectionProp;

    /**
     * @throws \ReflectionException
     * @throws ModelException
     */
    public function __construct(array $data)
    {
        $this->loadData($data);
    }

    /**
     * @param array $arrayProp
     */
    public function setArrayProp(array $arrayProp)
    {
        $this->arrayProp = $arrayProp;
    }

    /**
     * @return ?array
     */
    public function getArrayProp(): ?array
    {
        return $this->arrayProp;
    }

    /**
     * @param string $camelCaseProp1
     */
    public function setCamelCaseProp1(string $camelCaseProp1)
    {
        $this->camelCaseProp1 = $camelCaseProp1;
    }

    /**
     * @return ?string
     */
    public function getCamelCaseProp1(): ?string
    {
        return $this->camelCaseProp1;
    }


    /**
     * @param string $camelCaseProp2
     */
    public function setCamelCaseProp2(string $camelCaseProp2)
    {
        $this->camelCaseProp2 = $camelCaseProp2;
    }

    /**
     * @return ?string
     */
    public function getCamelCaseProp2(): ?string
    {
        return $this->camelCaseProp2;
    }
    /**
     * @param array $collectionProp
     */
    public function setCollectionProp(array $collectionProp)
    {
        $this->collectionProp = [];
        foreach ($collectionProp as $prop) {
            $this->addcollectionProp($prop);
        }
    }

    /**
     * @param ModelTraitImplementation $collectionProp
     */
    public function addCollectionProp(ModelTraitImplementation $collectionProp)
    {
        $this->collectionProp[] = $collectionProp;
    }

    /**
     * @return ?array
     */
    public function getCollectionProp(): ?array
    {
        return $this->collectionProp;
    }

    /**
     * @param ModelTraitImplementation $objectProp
     */
    public function setObjectProp(ModelTraitImplementation $objectProp)
    {
        $this->objectProp = $objectProp;
    }

    /**
     * @return ?object
     */
    public function getObjectProp(): ?object
    {
        return $this->objectProp;
    }

    /**
     * @param string $prop1
     */
    public function setProp1(string $prop1)
    {
        $this->prop1 = $prop1;
    }

    /**
     * @return ?string
     */
    public function getProp1(): ?string
    {
        return $this->prop1;
    }

    /**
     * @param string $prop2
     */
    public function setProp2(string $prop2)
    {
        $this->prop2 = $prop2;
    }

    /**
     * @return ?string
     */
    public function getProp2(): ?string
    {
        return $this->prop2;
    }

    /**
     * @param string $prop3
     */
    public function setProp3(string $prop3)
    {
        $this->prop3 = $prop3;
    }

    /**
     * @return ?string
     */
    public function getProp3(): ?string
    {
        return $this->prop3;
    }
}

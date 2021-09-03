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

    protected $prop1;

    protected $prop2;

    protected $prop3;

    protected $camelCaseProp1;

    protected $camelCaseProp2;
    
    protected $noSetterProp;

    protected $objectProp;

    protected $arrayProp;

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
     * @return mixed
     */
    public function getArrayProp(): mixed
    {
        return $this->arrayProp;
    }

    /**
     * @param mixed $camelCaseProp1
     */
    public function setCamelCaseProp1(mixed $camelCaseProp1)
    {
        $this->camelCaseProp1 = $camelCaseProp1;
    }

    /**
     * @return mixed
     */
    public function getCamelCaseProp1(): mixed
    {
        return $this->camelCaseProp1;
    }


    /**
     * @param mixed $camelCaseProp2
     */
    public function setCamelCaseProp2(mixed $camelCaseProp2)
    {
        $this->camelCaseProp2 = $camelCaseProp2;
    }

    /**
     * @return mixed
     */
    public function getCamelCaseProp2(): mixed
    {
        return $this->camelCaseProp2;
    }
    /**
     * @param mixed $collectionProp
     */
    public function setCollectionProp(array $collectionProp)
    {
        $this->collectionProp = [];
        foreach ($collectionProp as $prop) {
            $this->addcollectionProp($prop);
        }
    }

    public function addCollectionProp(ModelTraitImplementation $collectionProp)
    {
        $this->collectionProp[] = $collectionProp;
    }

    /**
     * @return mixed
     */
    public function getCollectionProp(): mixed
    {
        return $this->collectionProp;
    }

    /**
     * @param mixed $objectProp
     */
    public function setObjectProp(ModelTraitImplementation $objectProp)
    {
        $this->objectProp = $objectProp;
    }

    /**
     * @return mixed
     */
    public function getObjectProp(): mixed
    {
        return $this->objectProp;
    }

    /**
     * @param mixed $prop1
     */
    public function setProp1(mixed $prop1)
    {
        $this->prop1 = $prop1;
    }

    /**
     * @return mixed
     */
    public function getProp1(): mixed
    {
        return $this->prop1;
    }

    /**
     * @param mixed $prop2
     */
    public function setProp2(mixed $prop2)
    {
        $this->prop2 = $prop2;
    }

    /**
     * @return mixed
     */
    public function getProp2(): mixed
    {
        return $this->prop2;
    }

    /**
     * @param mixed $prop3
     */
    public function setProp3(mixed $prop3)
    {
        $this->prop3 = $prop3;
    }

    /**
     * @return mixed
     */
    public function getProp3(): mixed
    {
        return $this->prop3;
    }



}

<?php

namespace Downsider\Clay\Test\Implementation;

use Downsider\Clay\Model\ModelTrait;

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
     * @return array
     */
    public function getArrayProp()
    {
        return $this->arrayProp;
    }

    /**
     * @param mixed $camelCaseProp1
     */
    public function setCamelCaseProp1($camelCaseProp1)
    {
        $this->camelCaseProp1 = $camelCaseProp1;
    }

    /**
     * @return mixed
     */
    public function getCamelCaseProp1()
    {
        return $this->camelCaseProp1;
    }


    /**
     * @param mixed $camelCaseProp2
     */
    public function setCamelCaseProp2($camelCaseProp2)
    {
        $this->camelCaseProp2 = $camelCaseProp2;
    }

    /**
     * @return mixed
     */
    public function getCamelCaseProp2()
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
    public function getCollectionProp()
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
    public function getObjectProp()
    {
        return $this->objectProp;
    }

    /**
     * @param mixed $prop1
     */
    public function setProp1($prop1)
    {
        $this->prop1 = $prop1;
    }

    /**
     * @return mixed
     */
    public function getProp1()
    {
        return $this->prop1;
    }

    /**
     * @param mixed $prop2
     */
    public function setProp2($prop2)
    {
        $this->prop2 = $prop2;
    }

    /**
     * @return mixed
     */
    public function getProp2()
    {
        return $this->prop2;
    }

    /**
     * @param mixed $prop3
     */
    public function setProp3($prop3)
    {
        $this->prop3 = $prop3;
    }

    /**
     * @return mixed
     */
    public function getProp3()
    {
        return $this->prop3;
    }



}
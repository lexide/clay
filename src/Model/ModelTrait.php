<?php
namespace Downsider\Clay\Model;
use Downsider\Clay\Exception\ModelException;

/**
 * Used to load data into a model
 *
 * Where a field can accept a collection of subclasses, type-hinted by a base class, the discriminator map of that base
 * class identifies which subclass to instantiate for a given set of data
 *
 * [
 *     "discriminatorField" => [child class property to discriminate against] - e.g. "type"
 *     "subclassNamespace" => [namespace under which the subclasses are located] - defaults to the namespace of the base class
 *     "subclassSuffix" => [class name suffix to append to the value of the discriminator field] - e.g. ProductItem, ShippingItem, DiscountItem, etc...
 *     "map" => [
 *         [discriminator field value] => [partial class name or FQCN]
 *     ]
 * ]
 *
 * @property $modelDiscriminatorMap array
 *
 */
trait ModelTrait 
{
    use ClassDiscriminatorTrait;

    protected $modelConstructorArgs = [];

    protected $modelCanBeUpdated = true;

    protected function loadData(array $data, $update = false, $replaceCollections = false)
    {
        foreach ($data as $prop => $value) {

            if (is_null($value) && !$update) {
                // nulls can be ignored if we're not updating
                continue;
            }
            // studly caps the property name
            $prop = $this->toStudlyCaps($prop);

            // look for setter first
            $setter = "set$prop";
            if (method_exists($this, $setter)) {
                if (is_array($value)) {
                    // check to see if the method requires a class
                    $param = $this->getFirstParameter($setter);
                    $isCollection = false;

                    // if the setter's first parameter is an array, we need to check if this is a collection of objects
                    // in this case there should be an "addProperty" method on the class
                    $adder = "add$prop";
                    if ($param->isArray() && method_exists($this, $adder)) {
                        $param = $this->getFirstParameter($adder);
                        $isCollection = true;
                    }
                    $value = $this->constructClasses($param, $value, $isCollection);

                    // if we have a collection and we're updating it ...
                    if (
                        $isCollection &&
                        $update &&
                        (
                            empty($replaceCollections) ||               // don't add if we're replacing all collections
                            empty($replaceCollections[lcfirst($prop)])  // don't add if this collection has been marked for replacing
                        )
                    ) {
                        // ... add each element instead of replacing the whole set
                        foreach ($value as $element) {
                            $this->{$adder}($element);
                        }
                        continue;
                    }
                }
                $this->{$setter}($value);
            } else {
                // set the property directly
                // to camel case
                $prop = lcfirst($prop);
                if (property_exists($this, $prop)) {
                    $this->{$prop} = $value;
                }
            }

        }
    }

    public function updateData(array $data, $replaceCollections = false)
    {
        // only update if we're allowed
        if ($this->modelCanBeUpdated) {
            $this->loadData($data, true, $replaceCollections);
        }
    }

    public function toArray($propertyCase = "")
    {
        $properties = get_object_vars($this);
        $data = [];
        foreach ($properties as $prop => $blah) {
            // check for getter
            $getter = "get" . ucfirst($prop);
            if (method_exists($this, $getter)) {
                $value = $this->{$getter}();
                $prop = $this->convertPropertyCase($prop, $propertyCase);
                $data[$prop] = $this->getValueData($value, $propertyCase);
            }
        }
        return $data;
    }

    /**
     * @param string $property
     * @param string $case
     * @return string
     */
    private function convertPropertyCase($property, $case)
    {
        switch ($case) {
            case "studly caps":
                $property = $this->toStudlyCaps($property);
                break;
            case "camel":
                $property = lcfirst($this->toStudlyCaps($property));
                break;
            case "underscore":
            case "snake":
                $property = $this->toSplitCase($property);
                break;
            case "dash":
            case "hyphen":
                $property = $this->toSplitCase($property, "-");
                break;
            default:
                if (strlen($case) == 1) {
                    $property = $this->toSplitCase($property, $case);
                }
                break;
        }
        return $property;
    }

    private function getFirstParameter($method)
    {
        $ref = new \ReflectionMethod($this, $method);
        /** @var \ReflectionParameter $param */
        return $ref->getParameters()[0];
    }

    private function constructClasses(\ReflectionParameter $param, $value, $isCollection = false)
    {
        $class = $param->getClass();
        if (!empty($class)) {

            if ($isCollection) {
                foreach ($value as $i => $subValue) {
                    $value[$i] = $this->getNewInstance($class, $subValue);
                }
            } else {
                $value = $this->getNewInstance($class, $value);
            }
        }
        return $value;
    }

    private function getNewInstance(\ReflectionClass $class, $value)
    {
        if (is_array($value)) {
            $class = $this->discriminateClass($class, $value);
            $value = $class->newInstanceArgs(array_merge([$value], $this->modelConstructorArgs));
        }
        return $value;
    }

    private function getValueData($value, $propertyCase)
    {
        $data = $value;
        if (is_array($value)) {
            foreach ($value as $i => $subValue) {
                if (is_object($subValue) && method_exists($subValue, "toArray")) {
                    $subValue = $subValue->toArray($propertyCase);
                }
                $data[$i] = $subValue;
            }
        } elseif (is_object($value) && method_exists($value, "toArray")) {
            $data = $value->toArray($propertyCase);
        }

        return $data;
    }



} 
<?php
namespace Downsider\Clay\Model;

/**
 * used to load data into a model
 */
trait ModelTrait 
{
    use NameConverterTrait;

    protected function loadData(array $data)
    {
        foreach ($data as $prop => $value) {

            if (is_null($value)) {
                // skip nulls
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

    public function toArray()
    {
        $properties = get_object_vars($this);
        $data = [];
        foreach ($properties as $prop => $blah) {
            // check for getter
            $getter = "get" . ucfirst($prop);
            if (method_exists($this, $getter)) {
                $value = $this->{$getter}();
                if (!is_null($value)) {
                    $data[$prop] = $this->getValueData($value);
                }
            }
        }
        return $data;
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
                    $value[$i] = $class->newInstance($subValue);
                }
            } else {
                $value = $class->newInstance($value);
            }
        }
        return $value;
    }

    private function getValueData($value)
    {
        $data = $value;
        if (is_array($value)) {
            foreach ($value as $i => $subValue) {
                if (is_object($subValue) && method_exists($subValue, "toArray")) {
                    $subValue = $subValue->toArray();
                }
                $data[$i] = $subValue;
            }
        } elseif (is_object($value) && method_exists($value, "toArray")) {
            $data = $value->toArray();
        }

        return $data;
    }



} 
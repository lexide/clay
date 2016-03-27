<?php

namespace Downsider\Clay\Model;

use Downsider\Clay\Exception\ModelException;

trait ClassDiscriminatorTrait
{

    private function discriminateClass(\ReflectionClass $class, array $data)
    {
        $properties = $class->getDefaultProperties();
        if (!empty($properties["modelDiscriminatorMap"])) {
            $discriminator = $properties["modelDiscriminatorMap"];
            if (empty($discriminator["discriminatorField"])) {
                throw new ModelException("Cannot use the discriminator map for '{$class->getName()}'. No discriminator field was configured.");
            }
            $field = $discriminator["discriminatorField"];

            if (empty($data[$field])) {
                throw new ModelException("The discriminator field '$field' for '{$class->getName()}' was not found in the data set.");
            }

            $baseNamespace = !empty($discriminator["subclassNamespace"])? $discriminator["subclassNamespace"]: $class->getNamespaceName();
            $classNameSuffix = !empty($discriminator["subclassSuffix"])? $discriminator["subclassSuffix"]: "";
            $map = !empty($discriminator["map"])? $discriminator["map"]: [];

            // generate the class name
            $value = $data[$field];
            if (empty($map[$value])) {
                throw new ModelException("The discriminator value '$value' was not registered in the map");
            }

            $className = ($map[$value] !== true)? $map[$value]: $this->toStudlyCaps($value);

            // if this is not a valid class, try it with the base namespace
            if (!class_exists($className)) {
                $className = $baseNamespace . "\\" . $className;
                if (!class_exists($className)) {
                    $className .= $classNameSuffix;
                }
            }

            // create the reflection object. This will throw an exception if the class does not exist, as is expected.
            $class = new \ReflectionClass($className);
        }
        return $class;
    }

}
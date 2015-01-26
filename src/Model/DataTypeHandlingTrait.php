<?php
namespace Downsider\Clay\Model;
use Downsider\Clay\Exception\ModelException;

/**
 * handles specific data types so we can intelligently apply
 */
trait DataTypeHandlingTrait
{

    protected $dateFormat = "Y-m-d";

    /**
     * @param mixed $date
     * @return \DateTime
     * @throws ModelException
     */
    protected function handleSetDate($date)
    {
        if (is_string($date)) {
            return new \DateTime($date);
        } elseif ($date instanceof \DateTime) {
            return $date;
        }
        $type = gettype($date);
        if ($type == "object") {
            $type = get_class($date);
        }
        throw new ModelException("Could not set a date. The value was invalid ($type)");
    }

    protected function handleGetDate(\DateTime $date, $asString = true)
    {
        if ($asString) {
            return $date->format($this->dateFormat);
        }
        return $date;
    }

} 
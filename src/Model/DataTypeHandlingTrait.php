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
        // check case where $date is a timestamp inside a string
        if (is_string($date) && $date === (string) (int) $date) {
            $date = (int) $date;
        }

        if (is_string($date)) {
            return new \DateTime($date);
        } elseif (is_int($date)) {
            $dateTime = new \DateTime();
            $dateTime->setTimestamp($date);
            return $dateTime;
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

    protected function handleSetFile($filePath, $normalisePath = true)
    {
        if (!file_exists($filePath)) {
            throw new ModelException("Could not set file. File does not exist ($filePath)");
        }
        if ($normalisePath) {
            $filePath = realpath($filePath);
        }
        return $filePath;
    }

}
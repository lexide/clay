<?php

namespace Lexide\Clay\Model;

use Lexide\Clay\Exception\ModelException;

/**
 * handles specific data types so we can intelligently apply
 */
trait DataTypeHandlingTrait
{

    /**
     * @var string
     */
    protected $dateFormat = "Y-m-d";

    /**
     * @param mixed $date
     * @return \DateTime
     * @throws ModelException|\Exception
     */
    protected function handleSetDate(mixed $date): \DateTime
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

    /**
     * @param mixed $date
     * @param bool $asString
     * @return \DateTime|null|string
     */
    protected function handleGetDate(mixed $date, bool $asString = true): \DateTime|string|null
    {
        if (!$date instanceof \DateTime) {
            return $asString ? "" : null;
        }

        return $asString ? $date->format($this->dateFormat) : $date;
    }

    /**
     * @param string $filePath
     * @param bool $normalisePath
     * @return string
     * @throws ModelException
     */
    protected function handleSetFile(string $filePath, bool $normalisePath = true): string
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

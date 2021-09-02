<?php

namespace Lexide\Clay\Test\Implementation;

use Lexide\Clay\Exception\ModelException;
use Lexide\Clay\Model\DataTypeHandlingTrait;

/**
 *
 */
class DataTypeHandlingTraitImplementation 
{
    use DataTypeHandlingTrait;

    /**
     * @var \DateTime|array|string|null
     */
    protected $date;

    /**
     * @throws ModelException
     */
    public function setDate(mixed $date)
    {
        $this->date = $this->handleSetDate($date);
    }

    public function getDate(): \DateTime|array|string|null
    {
        return $this->handleGetDate($this->date);
    }

    public function setDateFormat($format)
    {
        $this->dateFormat = $format;
    }

} 

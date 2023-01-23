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
     * @var string|\DateTime|null
     */
    protected $date;

    /**
     * @param mixed $date
     * @throws ModelException
     */
    public function setDate(mixed $date): void
    {
        $this->date = $this->handleSetDate($date);
    }

    /**
     * @return string|\DateTime|null
     */
    public function getDate(): string|null|\DateTime
    {
        return $this->handleGetDate($this->date);
    }

    /**
     * @param string $format
     */
    public function setDateFormat(string $format): void
    {
        $this->dateFormat = $format;
    }

} 

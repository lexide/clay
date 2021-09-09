<?php

namespace Lexide\Clay\Test;

use Lexide\Clay\Exception\ModelException;
use Lexide\Clay\Test\Implementation\DataTypeHandlingTraitImplementation;
use PHPUnit\Framework\TestCase;

class DataTypeHandlingTraitTest extends TestCase
{

    /**
     * @dataProvider handleDateProvider
     *
     * @param mixed $data
     * @param string $date
     * @throws ModelException
     */
    public function testHandleDate(mixed $data, string $date)
    {
        $dataTypeTrait = new DataTypeHandlingTraitImplementation();
        $dataTypeTrait->setDate($data);

        $this->assertEquals($date, $dataTypeTrait->getDate());
    }

    /**
     * @dataProvider handleDateExceptionProvider
     *
     * @param mixed $data
     * @throws ModelException
     */
    public function testHandleDateExceptions(mixed $data)
    {
        $this->expectException(ModelException::class);

        $dataTypeTrait = new DataTypeHandlingTraitImplementation();

        $dataTypeTrait->setDate($data);
    }

    /**
     * @throws ModelException
     */
    public function testChangeDateFormat()
    {
        $dataTypeTrait = new DataTypeHandlingTraitImplementation();

        $date = new \DateTime("2015-01-26");
        $newFormat = "d-m-Y";

        $dataTypeTrait->setDateFormat($newFormat);
        $dataTypeTrait->setDate($date);
        $this->assertEquals("26-01-2015", $dataTypeTrait->getDate());
    }

    public function handleDateProvider(): array
    {
        return [
            [ #0 with a string
                "2015-01-26",
                "2015-01-26"
            ],
            [ #1 with a datetime object
                new \DateTime("2015-01-26"),
                "2015-01-26"
            ],
            [ #2 with a timestamp
                strtotime("2015-01-26"),
                "2015-01-26"
            ]
        ];
    }

    public function handleDateExceptionProvider(): array
    {
        return [
            [ #0 with an invalid value - array
                ["blah"]
            ],
            [ #1 with an invalid value - null
                null
            ]
        ];
    }
}

<?php

namespace Lexide\Clay\Test;

use Lexide\Clay\Exception\ModelException;
use Lexide\Clay\Test\Implementation\ModelTraitImplementation;
use Lexide\Clay\Test\Implementation\ParentClass;
use PHPUnit\Framework\TestCase;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class ModelTraitTest extends TestCase
{
    use ArraySubsetAsserts;

    protected $defaultProperties = [
        "prop1" => null,
        "prop2" => null,
        "prop3" => null,
        "camelCaseProp1" => null,
        "camelCaseProp2" => null,
        "objectProp" => null,
        "arrayProp" => null,
        "collectionProp" => null
    ];

    /**
     * @dataProvider setDataProvider
     *
     * @param $testData
     * @param $expectedProperties
     * @throws ModelException
     * @throws \ReflectionException
     */
    public function testSetData($testData, $expectedProperties)
    {
        $modelTrait = new ModelTraitImplementation($testData);

        // check data is as expected
        foreach ($expectedProperties as $prop => $value) {
            if ($value == "does not exist") {
                $this->assertObjectNotHasAttribute($prop, $modelTrait);
                continue;
            }

            $getter = "get" . ucfirst($prop);

            if (!empty($value["objectData"])) {
                $actualData = $modelTrait->{$getter}();
                if (!is_array($actualData)) {
                    // wrap data and values in an array so we can process them in the same way
                    $actualData = [$actualData];
                    $value["objectData"] = [$value["objectData"]];
                }
                if (!empty($value["objectData"][0])) {
                    foreach ($value["objectData"] as $i => $objData) {
                        foreach ($objData as $subProp => $subValue) {
                            $assertGetter = "get" . ucfirst($subProp);
                            $this->assertSame($subValue, $actualData[$i]->{$assertGetter}());
                        }
                    }
                }
                continue;
            }
            $this->assertSame($value, $modelTrait->{$getter}());
        }
    }

    /**
     * @depends      testSetData
     * @dataProvider toArrayData
     *
     * @param $setData
     * @param $expectedArray
     * @throws ModelException
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function testToArray($setData, $expectedArray)
    {
        $modelTrait = new ModelTraitImplementation([]);

        foreach ($setData as $setter => $value) {
            $modelTrait->{$setter}($value);
        }

        $this->assertArraySubset($expectedArray, $modelTrait->toArray());
    }

    /**
     * @dataProvider discriminationProvider
     *
     * @param $property
     * @param $propertyData
     * @throws ModelException
     * @throws \ReflectionException
     */
    public function testDiscrimination($property, $propertyData)
    {
        $data = [
            $property => $propertyData
        ];

        $parent = new ParentClass($data);

        $parent = $parent->toArray();

        $this->assertEquals($propertyData, $parent[$property]);
    }

    /**
     * @dataProvider antiDiscriminationProvider
     *
     * @param array $data
     * @param $exceptionMessagePattern
     * @throws \ReflectionException
     */
    public function testAntiDiscrimination(array $data, $exceptionMessagePattern)
    {
        $data = [
            "single" => $data
        ];

        try {
            $parent = new ParentClass($data);
            $this->fail("Should not be able to create discriminated subclasses");
        } catch (ModelException $e) {
            $this->assertMatchesRegularExpression($exceptionMessagePattern, $e->getMessage());
        }
    }

    public function setDataProvider(): array
    {
        $prop1Data = ["prop1" => "value1"];
        $prop2Data = ["prop2" => "value2"];
        $prop3Data = ["prop3" => "value3"];

        $allData = array_merge($prop1Data, $prop2Data, $prop3Data);

        return [
            [ // #0 set multiple properties
                $allData,
                $allData
            ],
            [ // #1 convert property names to camel case
                [
                    "camel_case_prop1" => "value1",
                    "camel case prop2" => "value2",
                ],
                [
                    "camelCaseProp1" => "value1",
                    "camelCaseProp2" => "value2",
                ]
            ],
            [ // #2 set properties directly (no setter method)
                [
                    "noSetterProp" => "value1"
                ],
                [
                    "noSetterProp" => "value1"
                ]
            ],
            [ // #3 do not set properties that don't exist
                [
                    "noProp" => "does not exist"
                ],
                [
                    "noProp" => "does not exist"
                ]
            ],
            [ // #4 create objects if they are type hinted
                [
                    "objectProp" => $prop1Data
                ],
                [
                    "objectProp" => ["objectData" => $prop1Data]
                ]
            ],
            [ // #5 create a collection of objects if they are type hinted
                [
                    "collectionProp" => [
                        $prop1Data,
                        $prop2Data,
                        $prop3Data
                    ]

                ],
                [
                    "collectionProp" => [
                        "objectData" => [
                            $prop1Data,
                            $prop2Data,
                            $prop3Data
                        ]
                    ]
                ]
            ],
            [ // #6 pass standard array data directly to the setter, with no object creation
                [
                    "arrayProp" => $allData
                ],
                [
                    "arrayProp" => $allData
                ]
            ]
        ];
    }

    /**
     * @throws ModelException
     * @throws \ReflectionException
     */
    public function toArrayData(): array
    {
        $subModel1 = [
            "prop1" => "value1",
            "prop2" => "value2"
        ];

        $subModel2 = [
            "prop3" => "value1",
            "camelCaseProp1" => "value2",
        ];

        return [
            [ // #1 multiple attributes
                [
                    "setProp1" => "value1",
                    "setProp2" => "value2",
                    "setProp3" => "value3"
                ],
                [
                    "prop1" => "value1",
                    "prop2" => "value2",
                    "prop3" => "value3"
                ]
            ],
            [ // #2 array attributes
                [
                    "setArrayProp" => [1, 2, 3, 4, 5]
                ],
                [
                    "arrayProp" => [1, 2, 3, 4, 5]
                ]
            ],
            [  // #3 model attributes
                [
                    "setObjectProp" => new ModelTraitImplementation($subModel1)
                ],
                [
                    "objectProp" => array_replace($this->defaultProperties, $subModel1)
                ]
            ],
            [  // #3 model collection attributes
                [
                    "setCollectionProp" => [
                        new ModelTraitImplementation($subModel2),
                        new ModelTraitImplementation($subModel1)
                    ]
                ],
                [
                    "collectionProp" => [
                        array_replace($this->defaultProperties, $subModel2),
                        array_replace($this->defaultProperties, $subModel1)
                    ]
                ]
            ]
        ];
    }

    public function discriminationProvider(): array
    {
        return [
            [ #0 simple class loading with suffix
                "single",
                ["type" => "name", "id" => 1, "name" => "test"]
            ],
            [ #1 mapped class loading with suffix
                "single",
                ["type" => "sizeOf", "id" => 1, "count" => 3]
            ],
            [ #2 mapped class loading with FQCN
                "single",
                ["type" => "weird", "id" => 1, "unusual" => "blubbery"]
            ],
            [ #3 multiple class loading of various types
                "multiple",
                [
                    ["type" => "name", "id" => 1, "name" => "test1"],
                    ["type" => "data", "id" => 1, "data" => [1, 2, 3, 4, 5]],
                    ["type" => "sizeOf", "id" => 1, "count" => 3],
                    ["type" => "weird", "id" => 1, "unusual" => "blubbery"],
                    ["type" => "name", "id" => 1, "name" => "test2"]
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function antiDiscriminationProvider(): array
    {
        return [
            [ #0 missing discriminator field value
                ["name" => "blah"],
                "/'type'/"
            ],
            [ #1 discriminator value not in map
                ["type" => "unknownValue", "name" => "blah"],
                "/'unknownValue'/"
            ]
        ];
    }
}

<?php
/**
 * Silktide Nibbler. Copyright 2013-2014 Silktide Ltd. All Rights Reserved.
 */
namespace Downsider\Clay\Test;
use Downsider\Clay\Test\Implementation\ModelTraitImplementation;

/**
 *
 */
class ModelTraitTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider setDataProvider
     *
     * @param $testData
     * @param $expectedProperties
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
            if (!empty($value["objectData"])) {
                $getter = "get" . ucfirst($prop);
                $actualData = $modelTrait->{$getter}();
                if (!is_array($actualData)) {
                    // wrap data and values in an array so we can process them in the same way
                    $actualData = [$actualData];
                    $value["objectData"] = [$value["objectData"]];
                }
                if (!empty($value["objectData"][0])) {
                    foreach ($value["objectData"] as $i => $objData) {
                        foreach ($objData as $subProp => $subValue) {
                            $this->assertAttributeEquals($subValue, $subProp, $actualData[$i]);
                        }
                    }
                }
                continue;
            }
            $this->assertAttributeEquals($value, $prop, $modelTrait);
        }
    }

    /**
     * @depends testSetData
     * @dataProvider toArrayData
     */
    public function testToArray($setData, $expectedArray)
    {
        $modelTrait = new ModelTraitImplementation([]);

        foreach ($setData as $setter => $value) {
            $modelTrait->{$setter}($value);
        }

        $this->assertEquals($expectedArray, $modelTrait->toArray());

    }

    public function setDataProvider()
    {
        $prop1Data = ["prop1" => "value1"];
        $prop2Data = ["prop2" => "value2"];
        $prop3Data = ["prop3" => "value3"];

        $allData = array_merge($prop1Data, $prop2Data, $prop3Data);

        return [
            [ // #1 set multiple properties
                $allData,
                $allData
            ],
            [ // #2 convert property names to camel case
                [
                    "camel_case_prop1" => "value1",
                    "camel case prop2" => "value2",
                ],
                [
                    "camelCaseProp1" => "value1",
                    "camelCaseProp2" => "value2",
                ]
            ],
            [ // #3 set properties directly (no setter method)
                [
                    "noSetterProp" => "value1"
                ],
                [
                    "noSetterProp" => "value1"
                ]
            ],
            [ // #4 do not set properties that don't exist
                [
                    "noProp" => "does not exist"
                ],
                [
                    "noProp" => "does not exist"
                ]
            ],
            [ // #5 create objects if they are type hinted
                [
                    "objectProp" => $prop1Data
                ],
                [
                    "objectProp" => ["objectData" => $prop1Data]
                ]
            ],
            [ // #6 create a collection of objects if they are type hinted
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
            [ // #7 pass standard array data directly to the setter, with no object creation
                [
                    "arrayProp" => $allData
                ],
                [
                    "arrayProp" => $allData
                ]
            ]
        ];
    }

    public function toArrayData()
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
                    "objectProp" => $subModel1
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
                    "collectionProp" => [$subModel2, $subModel1]
                ]
            ]
        ];
    }

}
 
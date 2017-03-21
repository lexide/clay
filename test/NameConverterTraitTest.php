<?php

namespace Downsider\Clay\Test;
use Downsider\Clay\Model\StringCases;
use Downsider\Clay\Test\Implementation\NameConverterImplementation;

/**
 * NameConverterTraitTest
 */
class NameConverterTraitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var NameConverterImplementation
     */
    protected $model;

    public function setup()
    {
        $this->model = new NameConverterImplementation();
    }

    /**
     * @dataProvider studlyCapsProvider
     *
     * @param $value
     * @param $expected
     */
    public function testToStudlyCaps($value, $expected)
    {
        $this->assertEquals($expected, $this->model->toStudlyCaps($value));
    }

    /**
     * @dataProvider splitCaseProvider
     *
     * @param $value
     * @param $expected
     * @param string $separator
     */
    public function testToSplitCase($value, $expected, $separator = "_")
    {
        $this->assertEquals($expected, $this->model->toSplitCase($value, $separator));
    }

    /**
     * @dataProvider arrayKeyProvider
     *
     * @param array $data
     * @param $case
     * @param array $expected
     */
    public function testConvertingArrayKeys(array $data, $case, array $expected)
    {
        $this->assertArraySubset($expected, $this->model->convertArrayKeys($data, $case));
    }

    public function studlyCapsProvider()
    {
        return [
            [ #0
                "single",
                "Single"
            ],
            [ #1
                "double_trouble",
                "DoubleTrouble"
            ],
            [ #2
                "StudlyCaps",
                "StudlyCaps"
            ],
            [ #3
                "with spaces",
                "WithSpaces"
            ],
            [ #4
                "with-other~characters",
                "WithOtherCharacters"
            ],
            [ #5
                "collapsing    separators",
                "CollapsingSeparators"
            ],
            [ #6
                "inc1uding_numb3rs_4_gigglez",
                "Inc1udingNumb3rs4Gigglez"
            ]
        ];
    }

    public function splitCaseProvider()
    {
        return [
            [ #0
                "oneword",
                "oneword"
            ],
            [ #1
                "twoWords",
                "two_words"
            ],
            [ #2
                "StudlyCaps",
                "studly_caps"
            ],
            [ #3
                "already_in_snake_case",
                "already_in_snake_case"
            ],
            [ #4
                "ALLCAPS",
                "a_l_l_c_a_p_s"
            ],
            [ #5
                "W1thNumb3rs",
                "w_1th_numb_3rs"
            ],
            [ #6
                "All4One",
                "all_4_one"
            ],
            [ #7
                "SpaceOutTheWords",
                "space out the words",
                " "
            ],
            [ #8
                "WithSomeOtherCharacter",
                "with~some~other~character",
                "~"
            ]
        ];
    }

    public function arrayKeyProvider()
    {
        $camel = [
            "propOne" => "value1",
            "aLongishPropName" => "value2",
            "shorty" => "value3"
        ];
        $studly = [
            "PropOne" => "value1",
            "ALongishPropName" => "value2",
            "Shorty" => "value3"
        ];
        $snake = [
            "prop_one" => "value1",
            "a_longish_prop_name" => "value2",
            "shorty" => "value3"
        ];
        $dash = [
            "prop-one" => "value1",
            "a-longish-prop-name" => "value2",
            "shorty" => "value3"
        ];

        $toTest = [
            StringCases::CAMEL_CASE => $camel,
            StringCases::STUDLY_CAPS => $studly,
            StringCases::SNAKE_CASE => $snake,
            StringCases::DASH_CASE => $dash
        ];

        foreach ($toTest as $input) {
            foreach ($toTest as $case => $output) {
                yield [$input, $case, $output];
            }
        }
    }

}

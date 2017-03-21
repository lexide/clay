<?php

namespace Downsider\Clay\Model;

trait NameConverterTrait 
{
    /**
     * @param string $string
     * @return string
     */
    private function toStudlyCaps($string)
    {
        return str_replace( // remove the spaces
            " ",
            "",
            ucwords( // uppercase the 1st letter of each word
                preg_replace( // replace underscores with spaces
                    "/[^A-Za-z0-9]/",
                    " ",
                    $string
                )
            )
        );
    }

    /**
     * @param string $string
     * @param string $separator
     * @return string
     */
    private function toSplitCase($string, $separator = "_")
    {
        return strtolower(
            preg_replace( // precede any capital letters or numbers with the separator (except when the character starts the string)
                "/(?<!^)([A-Z]|\\d+)/",
                $separator . '$1',
                preg_replace( // replace any non-word characters with the separator (e.g. for converting dash case to snake case)
                    "/[^A-Za-z0-9]/",
                    $separator,
                    $string
                )
            )
        );
    }

    /**
     * @param array $data
     * @param $case
     * @return array
     */
    private function convertArrayKeys(array $data, $case) {

        foreach ($data as $property => $value) {
            $originalProperty = $property;
            switch ($case) {
                case StringCases::STUDLY_CAPS:
                    $property = $this->toStudlyCaps($property);
                    break;
                case StringCases::CAMEL_CASE:
                    $property = lcfirst($this->toStudlyCaps($property));
                    break;
                case StringCases::SNAKE_CASE:
                    $property = $this->toSplitCase($property);
                    break;
                case StringCases::DASH_CASE:
                    $property = $this->toSplitCase($property, "-");
                    break;
                default:
                    if (strlen($case) == 1) {
                        $property = $this->toSplitCase($property, $case);
                    }
                    break;
            }
            $data[$property] = $value;
            if ($property != $originalProperty) {
                unset($data[$originalProperty]);
            }
        }

        return $data;
    }
} 
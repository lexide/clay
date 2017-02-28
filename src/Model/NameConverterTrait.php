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
                str_replace( // replace underscores with spaces
                    "_",
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
        return strtolower(preg_replace('/(?<!^)([A-Z]|\d+)/', $separator . '$1', $string));
    }
} 
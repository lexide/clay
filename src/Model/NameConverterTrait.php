<?php

namespace Downsider\Clay\Model;

trait NameConverterTrait 
{
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

    private function toSplitCase($string, $separator = "_")
    {
        return strtolower(preg_replace('/(?<!^)([A-Z]|\d+)/', $separator . '$1', $string));
    }
} 
<?php

namespace Lexide\Clay\Test\Implementation;

use Lexide\Clay\Model\NameConverterTrait;

/**
 * NameConverterImplementation
 */
class NameConverterImplementation
{
    use NameConverterTrait {
        toStudlyCaps as public;
        toSplitCase as public;
        convertArrayKeys as public;
    }
}

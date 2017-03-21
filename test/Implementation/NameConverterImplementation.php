<?php

namespace Downsider\Clay\Test\Implementation;

use Downsider\Clay\Model\NameConverterTrait;

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
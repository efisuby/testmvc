<?php

namespace App\Core\Abstracts;

/**
 * Class Creatable
 *
 * this is just helper class for classes that can be created;
 *
 * @package App\Core
 */
abstract class Creatable implements ICreatable
{
    public static function create()
    {
        return new static;
    }
}
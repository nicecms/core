<?php

namespace Nice\Core\Types;

use Nice\Core\Attribute;

abstract class BaseType
{

    abstract public function name();

    public function storable($data, $attribute = null, $item = null)
    {
        return (string)$data;
    }

}

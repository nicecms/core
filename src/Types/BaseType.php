<?php

namespace Nice\Core\Types;

use Nice\Core\Attribute;

abstract class BaseType
{

    abstract public function key();

    public function storable($data, $attribute = null, $item = null)
    {
        return (string)$data;
    }

    public function isInputFile(){
        return false;
    }

    public function prepareValue($raw, $attribute){
        return $raw;
    }

}

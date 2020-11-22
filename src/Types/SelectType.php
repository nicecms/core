<?php

namespace Nice\Core\Types;

use Nice\Core\Attribute;

class SelectType extends BaseType
{

    public function storable($data, $attribute = null, $item = null)
    {
        return (string)$data;
    }

    public function isInputFile()
    {
        return false;
    }

    public function key()
    {
        return 'select';
    }
}

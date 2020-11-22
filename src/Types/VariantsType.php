<?php

namespace Nice\Core\Types;

use Exception;
use Nice\Core\Attribute;

abstract class VariantsType extends BaseType
{

    abstract public function key();

    public function storable($data, $attribute = null, $item = null)
    {
        return (string)$data;
    }

    public function isInputFile()
    {
        return false;
    }

    /**
     * @param string $raw
     * @param Attribute $attribute
     * @return mixed|void
     * @throws Exception
     */
    public function prepareValue($raw, $attribute)
    {
        return $attribute->param('variants.' . $raw);
    }

}

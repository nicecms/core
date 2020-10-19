<?php

namespace Nice\Core\Types;

abstract class BaseType
{

    abstract public function name();

    public function storable($data)
    {
        return (string)$data;
    }

}

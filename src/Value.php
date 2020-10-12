<?php

namespace Nice\Core;

class Value
{


    /**
     * @type string
     */
    protected $value;




    public function __construct(string $key, string $value){

    }

    public function __toString()
    {
        return $this->value;
    }
}

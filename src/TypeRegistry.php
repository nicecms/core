<?php

namespace Nice\Core;

class TypeRegistry
{
    /**
     * @type array
     */
    protected $types = [];

    /**
     * @param BaseType $type
     */
    public function register(BaseType $type)
    {
        $this->types[$type->name()] = $type;
    }

    /**
     * @param $name
     * @return BaseType
     */
    public function get($name)
    {
        return $this->types[$name];
    }

    /**
     * @return array
     */
    public function registeredTypes()
    {
        return $this->types;
    }
}

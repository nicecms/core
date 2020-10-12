<?php

namespace Nice\Core;

class TypeRegistry
{
    /**
     * @type array
     */
    protected $types = [];

    /**
     * @param Type $type
     */
    public function register(Type $type)
    {
        $this->types[$type->name()] = $type;
    }

    /**
     * @param $name
     * @return Type
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

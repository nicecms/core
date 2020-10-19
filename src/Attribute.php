<?php

namespace Nice\Core;

use Illuminate\Support\Str;

class Attribute
{
    /**
     * @type string
     */
    protected $key;
    /**
     * @type array
     */
    protected $schema = [];

    /**
     * @type BaseType|null
     */
    protected $type;

    /**
     * Attribute constructor.
     * @param $key
     * @param array $schema
     */
    public function __construct($key, array $schema)
    {
        $this->key = $key;
        $this->schema = $schema;
    }

    public function key()
    {
        return $this->key;
    }

    public function typeKey()
    {
        return data_get($this->schema, 'type', 'string');
    }

    public function type()
    {

        $name = Str::ucfirst($this->typeKey());
        $class = "Nice\\Core\\Types\\{$name}Type";
        return new $class;
    }

    public function input($value = null)
    {
//        $type = $this->type();

        return view("nice::types." . $this->typeKey() . ".input", ['attribute' => $this, 'value' => $value]);
    }

    /**
     * @param string $key
     * @param null|string|array $default
     * @return string|array|mixed
     */
    public function param($key, $default = null)
    {
        $result = data_get($this->schema, $key, $default);

        return $result;
    }

}

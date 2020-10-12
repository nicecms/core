<?php

namespace Nice\Core;

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
     * @type Type|null
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
        return app('nice_type_registry')->get($this->typeKey());
    }

    public function input($value = null)
    {
        $type = $this->type();

        return view('nice-' . $type->name() . '-type::input', ['attribute' => $this, 'type' => $type, 'value' => $value]);
    }

    /**
     * @param string $key
     * @param null|string|array $default
     * @return string|array|mixed
     */
    public function param($key, $default = null)
    {
        $result = data_get($this->schema,  $key, $default);

        return $result;
    }

}

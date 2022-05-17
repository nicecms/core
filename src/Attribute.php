<?php

namespace Nice\Core;

use Illuminate\Support\Str;
use Illuminate\View\View;
use Nice\Core\Types\BaseType;

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

    /**
     * @return BaseType
     */
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

    public function name()
    {
        return $this->param('name');
    }

    public function getValue($raw)
    {
        return $this->type()->prepareValue($raw, $this);
    }

    public function showValue($raw)
    {
        $value = $this->type()->prepareValue($raw, $this);


        if (\View::exists("nice::types." . $this->typeKey() . ".show")) {
            return view("nice::types." . $this->typeKey() . ".show", ['attribute' => $this, 'value' => $value]);
        } else {
            return $value;
        }
    }

}

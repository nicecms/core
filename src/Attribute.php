<?php

namespace Nice\Core;

use Illuminate\Support\Str;
use Nice\Core\Contracts\ExternalDataProvider;
use Nice\Core\Contracts\ExternalValueProvider;
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

    public function hasProvider()
    {
        return (bool)data_get($this->schema, 'provider');
    }

    /**
     * @return ExternalValueProvider
     * @throws \Exception
     */
    public function provider()
    {

        if (!$this->hasProvider()) {
            throw new \Exception('Attribute ' . $this->key() . ' has no provider');
        }

        $class = data_get($this->schema, 'provider');

        if (!app($class)) {
            app()->singleton($class, function () use ($class) {
                return new $class;
            });
        }

        return app($class);
    }

    public function getValue($raw)
    {
        if ($this->hasProvider()) {
            return $this->provider()->value($raw);
        }

        return $this->type()->prepareValue($raw, $this);
    }


}

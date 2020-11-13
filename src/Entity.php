<?php

namespace Nice\Core;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Entity
{

    use EntityRoutes;

    /**
     * @type string
     */
    protected $key;
    /**
     * @type array
     */
    protected $schema = [];

    /**
     * Entity constructor.
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

    public function name()
    {
        return $this->param('name');
    }

    public function namePlural()
    {
        return $this->param('name_plural');
    }

    /**
     *
     *
     * @return Collection
     */

    public function attributes($only = [])
    {

        $attributes = new Collection();

        foreach (data_get($this->schema, 'attributes', []) as $key => $schema) {
            if ($only && !in_array($key, $only)) {
                continue;
            }

            $attribute = new Attribute($key, $schema);
            $attributes->push($attribute);
        }

        return $attributes;

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

    public function isMultiple()
    {
        return data_get($this->schema, 'multiple');
    }

    public function isSortable()
    {
        return data_get($this->schema, 'sortable');
    }

    public function makeItem()
    {
        return new Item(['entity' => $this->key()]);
    }



    public function children()
    {

        $entitites = app('nice_entity_service')->allEntities();

        return Arr::where($entitites, fn($item) => $item->param('parent') === $this->key());
    }

    public function parent()
    {

        return app('nice_entity_service')->find($this->param('parent'));

    }




}

<?php

namespace Nice\Core;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Nice\Core\Facades\Entities;

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

    public function isTitle($attribute)
    {
        if ($attribute instanceof Attribute) {
            $attribute = $attribute->key();
        }

        return $attribute === $this->param('title');

    }

    /**
     * @return bool
     */
    public function hasUrl()
    {
        return (bool)$this->param('url');
    }

    public function namePlural()
    {
        $plural = $this->param('name_plural');

        if (!$plural) {
            $plural = $this->name();
        }

        return $plural;
    }

    /**
     *
     *
     * @param array $only
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
     * @return array
     */
    public function attributesKeys()
    {
        return array_keys(data_get($this->schema, 'attributes', []));
    }

    public function attribute($key)
    {

        $schema = data_get($this->schema, 'attributes.' . $key, []);

        if (!$schema) {
            throw new \Exception($key.' attribute not found for '.$this->key);
        }

        return $attribute = new Attribute($key, $schema);

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

    public function singleItem($parent = null)
    {

        if ($this->isMultiple()) {

            throw new \Exception('Entity ' . $this->key() . ' is multiple');
        }

        $item = Item::where('entity', $this->key());

        if ($parent) {
            $item->where('parent_id', $parent->id);
        }

        $item = $item->first();

        return $item;

    }

    public function itemsQuery(){
        return Item::where('entity', $this->key());
    }

    public function __toString(){
        return $this->key();
    }

}

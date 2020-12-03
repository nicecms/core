<?php

namespace Nice\Core;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Nice\Core\Contracts\ExternalItemProvider;
use Nice\Core\Contracts\ExternalValueProvider;

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
    public function isExternal()
    {
        return (bool)$this->param('external');
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
        return $this->param('name_plural');
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
            return null;
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

    /**
     * Внешний атрибут - описание объекта вне CMS, привязываемого к экземпляру сущности.
     * Например Shop, привязанный через external => shop_id к news
     *
     * @return Attribute|null
     */
    public function externalAttribute()
    {
        return $this->attribute($this->externalKey());
    }

    /**
     * @return ExternalItemProvider
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

}

<?php

namespace Nice\Core;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Stringy\StaticStringy;

/**
 * Class Item
 * @package Nice\Core
 * @method whereValuesOf($data)
 */
class Item extends Model
{
    use ItemRoutes;

    /**
     * @type string
     */
    protected $table = "content_items";

    /**
     * @type array
     */
    protected $guarded = ['id', 'values'];

    /**
     * @type array
     */
    protected $casts = ['values' => 'array'];

    /**
     * @type bool
     */
    public $timestamps = true;

    /**
     * @type string
     */
    protected $fullUrl = null;

    public function parent()
    {
        return $this->belongsTo(Item::class, 'parent_id');
    }

    public function values()
    {
        return $this->values;
    }

    public function rawValue($key)
    {
        if ($key instanceof Attribute) {
            $key = $key->key();
        }

        $raw = data_get($this->values, $key);

        return $raw;
    }

    public function value($key)
    {
        $raw = $this->rawValue($key);

        return $this->entity()->attribute($key)->getValue($raw);

    }

    public function showValue($key)
    {
        $raw = $this->rawValue($key);

        return $this->entity()->attribute($key)->showValue($raw);

    }

    public function setValue($key, $value)
    {

        $values = $this->values;

        data_set($values, $key, $value);

        $this->values = $values;

    }

    /**
     * @return Entity
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function entity()
    {
        return app('nice_entity_service')->make($this->entity);
    }

    public function allChildren()
    {
        return $this->hasMany(Item::class, 'parent_id');
    }

    public function children($entity)
    {

        if ($entity instanceof Entity) {
            $entity = $entity->key();
        }

        return $this->allChildren()->where('entity', $entity);
    }

    public function parentsChain()
    {

        $parents = new Collection([$this]);

        $parent = $this->parent;

        while ($parent) {

            $parents->push($parent);

            $parent = $parent->parent;

        }

        return $parents;

    }

    public function title()
    {
        return $this->value($this->entity()->param('title'));
    }

    public function makeSlug()
    {
        return StaticStringy::slugify($this->value($this->entity()->param('title')));
    }

    public function fullUrl()
    {

        if ($this->fullUrl) {
            return $this->fullUrl;
        }

        $chain = $this->parentsChain();

        $data = $chain->pluck('url', 'entity');

        $template = $this->entity()->param('url');

        $url = $template;

        foreach ($data as $key => $value) {

            $url = str_replace("{" . $key . "}", $value, $url);

        }

        $this->fullUrl = config('app.url') . $url;

        return $url;

    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     */
    protected static function getEntityKeyFromQueryWhere($query)
    {

        $baseQuery = $query->getQuery();

        $entityWhere = Arr::first($baseQuery->wheres, function ($item) {

            return data_get($item, 'column') === 'entity';
        });

        return data_get($entityWhere, 'value');

    }

    public function scopeGivenOrder($query)
    {

        $entity = app('nice_entity_service')->make(static::getEntityKeyFromQueryWhere($query));

        if ($entity->isSortable()) {

            return $query->orderBy('position', 'asc');

        }

        #

        $key = $entity->param('editor.list_order.key');

        $direction = $entity->param('editor.list_order.direction', 'asc');

        if (!$key) {
            return $query->orderBy('created_at', 'desc');
        }

        return $query->orderBy('values->' . $key, $direction);

    }

    public function scopeWhereValueOf($query, $key, $value)
    {
        return $query->where('values->' . $key, $value);
    }

    public function scopeWhereValuesOf($query, $data)
    {

        foreach ($data as $key => $value) {
            $query->where('values->' . $key, $value);

        }

    }

    public function childSingleItem($entity)
    {
        return $this->children($entity)->first();
    }
}

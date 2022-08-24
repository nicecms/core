<?php

namespace Nice\Core;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Stringy\StaticStringy;

/**
 * Class Item
 * @package Nice\Core
 * @mixin \Eloquent
 * @method whereValuesOf($data)
 */
class Item extends Model
{
    use ItemRoutes;

//    use Macroable;

    /**
     * @type string
     */
    protected $table = "content_items";

    /**
     * @type array
     */
    protected $guarded = ['id', 'values', 'meta'];

    /**
     * @type array
     */
    protected $casts = ['values' => 'array', 'meta' => 'array'];

    /**
     * @type bool
     */
    public $timestamps = true;

    /**
     * @type string
     */
    protected $fullUrl = null;

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = StaticStringy::slugify($value);
    }

    /**
     * @param $entity
     * @param $slug
     * @param $parent
     * @return static
     */
    public static function one($entity, $slug, $parent = null)
    {
        if ($parent) {
            return $parent->allChildren()->where(['entity' => (string)$entity, 'url' => $slug])->firstOrFail();
        } else {
            return static::where(['entity' => (string)$entity, 'url' => $slug])->firstOrFail();
        }
    }

    public function parent()
    {
        return $this->belongsTo(Item::class, 'parent_id');
    }

    public function allRelated()
    {
        return $this->belongsToMany(static::class, 'content_item_relations', 'item_id', 'related_id');
    }

    public function allRelators()
    {
        return $this->belongsToMany(static::class, 'content_item_relations', 'related_id', 'item_id' );
    }

    public function relatedQuery($entity)
    {
        return $this->allRelated()
            //->join('content_items as ci', 'ci.id', '=' , 'content_item_relations.item_id')
            //->where('content_items.entity', $this->entity)
            ->where('content_items.entity', (string)$entity);
    }

    public function relatorsQuery($entity)
    {
        return $this->allRelators()
            //->join('content_items as ci', 'ci.id', '=' , 'content_item_relations.item_id')
            //->where('content_items.entity', $this->entity)
            ->where('content_items.entity', (string)$entity);
    }

    public function isRelated(Item $item)
    {
        return $this->allRelated->contains($item);
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

    public function value($key, $default = null)
    {
        $raw = $this->rawValue($key);

        if (!$raw) {
            $raw = $default;
        }

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
        $entity = \Entities::make(static::getEntityKeyFromQueryWhere($query));

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


    public function clearRelated(){
        $this->allRelated()->sync([]);
    }

    public function setRelated($entity, array $relatedIDs)
    {
        $data = [];

        foreach ($relatedIDs as $relatedID) {
            $data[$relatedID] = ['related_entity' => (string)$entity, 'item_entity' => $this->entity];
        }

        $this->relatedQuery($entity)->syncWithoutDetaching($relatedIDs);
    }

    public static function childrenOfMany(string $entity, Collection $items)
    {
        return Item::whereIn('parent_id', $items->pluck('id'))->where('entity', $entity)->get();
    }

    public function nestedChildren(array $entities)
    {
        $items = new Collection([$this]);
        $query = null;

        foreach ($entities as $entity) {
            $items = static::childrenOfMany($entity, $items);
            $query = Item::whereIn('id', $items->pluck('id'));
        }

        return $query;
    }

    public function setMeta($key, $value)
    {
        $meta = $this->meta;
        data_set($meta, $key, $value);
        $this->meta = $meta;
        return $this;

    }

    public function incrementMeta($key, $value = 1)
    {
        $meta = $this->meta;
        data_set($meta, $key, $this->getMeta($key) + $value);
        $this->meta = $meta;
        return $this;
    }

    public function getMeta($key, $default = null)
    {
        return data_get($this->meta, $key, $default);
    }


}

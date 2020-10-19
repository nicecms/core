<?php

namespace Nice\Core;

class Item extends \Illuminate\Database\Eloquent\Model
{

    /**
     * @type string
     */
    protected $table = "nice_items";

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

    public function childs()
    {
        return $this->hasMany(Item::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Item::class, 'parent_id');
    }

    public function values()
    {
        return $this->values;
    }

    public function value($key)
    {

        if($key instanceof Attribute){
            $key = $key->key();
        }

        return data_get($this->values, $key);
    }

    public function setValue($key, $value)
    {

        $values = $this->values;

        data_set($values, $key, $value);

        $this->values = $values;

    }


    public function entity(){
        return app('nice_entity_service')->make($this->entity);
    }

}

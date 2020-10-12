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
        return data_get($this->values, $key);
    }

}

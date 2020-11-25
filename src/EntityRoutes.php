<?php

namespace Nice\Core;

trait EntityRoutes
{

    public function editorIndexRoute($parent = null, $query = [])
    {

        if ($parent) {
            $query['parent_id'] = $parent->id;
        }

        $query = [$this->key()] + $query;

        return route(config('nice.route_name') . 'item.index', $query);

    }

    public function editorCreateRoute($parent = null, $query = [])
    {

        if ($parent) {
            $query['parent_id'] = $parent->id;
        }

        $query = [$this->key()] + $query;

        return route(config('nice.route_name') . 'item.create', $query);

    }

    public function editorStoreRoute()
    {

        $query = [$this->key()];

        return route(config('nice.route_name') . 'item.store', $query);

    }
}

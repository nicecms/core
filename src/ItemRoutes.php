<?php

namespace Nice\Core;

trait ItemRoutes
{

    public function editorIndexRoute()
    {

        $query = [$this->entity];



        if ($this->parent_id) {
            $query['parent_id'] = $this->parent_id;
        }

        return route(config('nice.route_name') . 'item.index', $query);

    }

    public function editorEditRoute()
    {

        $query = [$this->entity, $this->id];

        return route(config('nice.route_name') . 'item.edit', $query);

    }


    public function editorDestroyRoute()
    {

        $query = [$this->entity, $this->id];

        return route(config('nice.route_name') . 'item.destroy', $query);

    }
}

<?php

namespace Nice\Core;

trait ItemRoutes
{

    public function editorIndexRoute($query = [])
    {

        if (!$this->entity()->isMultiple()) {

            return $this->editorEditRoute();

        }

        return $this->entity()->editorIndexRoute($this->parent, $query);

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

<?php

namespace Nice\Core;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class EntityService
{

    public function make($key)
    {

        $schemas = $this->allSchemas();

        $schema = data_get($schemas, $key);

        if (!$schema) {
            throw new \Exception($key . ' - entity schema not found');
        }

        $entity = new Entity($key, $schema);

        return $entity;

    }

    public function allSchemas()
    {
        $driver = config('nice.schema_driver');

        switch ($driver) {

            case "config":

                $schemas = config(config('nice.schema_config_key'));

                break;
        }

        return $schemas;
    }

    public function allEntities()
    {
        $schemas = $this->allSchemas();

        $entitites = [];

        foreach ($schemas as $key => $schema) {
            $entitites[] = (new Entity($key, $schema));
        }

        return $entitites;

    }

    public function find($key){
        $entitites = $this->allEntities();
        return Arr::first($entitites, fn($item) => $item->key() === $key);
    }

}

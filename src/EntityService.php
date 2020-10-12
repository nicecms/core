<?php

namespace Nice\Core;

class EntityService
{

    public function make($key)
    {

        $driver = config('nice.schema_driver');



        switch ($driver) {

            case "config":

                $entities = config(config('nice.schema_config_key'));

                $schema = data_get($entities, $key);


                if (!$schema) {
                    throw new \Exception($key . ' - entity schema not found');
                }

                break;
        }

        $entity = new Entity($key, $schema);

        return $entity;

    }

}

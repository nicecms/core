<?php

namespace Nice\Core\Contracts;

interface ExternalDataProvider
{

    /**
     * @param $name
     * @return array
     */
    public function options($name);

    public function value($id);

    public function instance($id);


}

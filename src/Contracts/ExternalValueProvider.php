<?php

namespace Nice\Core\Contracts;

interface ExternalValueProvider
{

    /**
     * id => name array
     *
     * @return array
     */
    public function all();

    public function value($id);

    public function instance($id);


}

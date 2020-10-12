<?php

namespace Nice\Core\Controllers;

use Nice\Core\Entity;

class ItemController extends \Illuminate\Routing\Controller
{

    public function index()
    {

    }

    public function create($name)
    {

//        dd(app('nice_type_registry')->registeredTypes());

        $entity = app('nice_entity_service')->make($name);

        return view('nice::create', ['entity' => $entity]);

    }

    public function store()
    {

    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

}

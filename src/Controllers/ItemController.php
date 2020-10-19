<?php

namespace Nice\Core\Controllers;

use Illuminate\Http\Request;
use Nice\Core\Entity;
use Nice\Core\Item;

class ItemController extends \Illuminate\Routing\Controller
{

    public function index($name)
    {

        $entity = app('nice_entity_service')->make($name);

        $items = Item::query();

        $items->where('entity', $entity->key());

        $items->orderBy('created_at', 'desc');

        $items = $items->get();


        return view('nice::item.index', ['entity' => $entity, 'items' => $items]);

    }

    public function create($name)
    {
        $entity = app('nice_entity_service')->make($name);

        return view('nice::item.create', ['entity' => $entity]);

    }

    public function store(Request $request, $name)
    {

        $entity = app('nice_entity_service')->make($name);

        $item = $entity->makeItem();

        foreach ($entity->attributes() as $attribute) {

            $data = $request->input($attribute->key());

            $storable = $attribute->type()->storable($data);

            $item->setValue($attribute->key(), $storable);

        }

        $item->url = $request->input('url');

        $item->save();

        return redirect()->route(config('nice.route_name') . 'item.index', $entity->key());

    }

    public function show()
    {

    }

    public function edit(Request $request, $name, $id)
    {

        $item = Item::findOrFail($id);

        $entity = $item->entity();


        return view('nice::item.edit', ['entity' => $entity, 'item' => $item]);
    }

    public function update(Request $request, $name, $id)
    {
        $item = Item::findOrFail($id);

        $entity = $item->entity();

        foreach ($entity->attributes() as $attribute) {

            $data = $request->input($attribute->key());

            $storable = $attribute->type()->storable($data);

            $item->setValue($attribute->key(), $storable);

        }

        $item->url = $request->input('url');


        $item->save();

        return redirect()->route(config('nice.route_name') . 'item.index', $entity->key());

    }

    public function destroy()
    {

    }

}

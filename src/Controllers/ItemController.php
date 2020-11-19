<?php

namespace Nice\Core\Controllers;

use Illuminate\Http\Request;
use Nice\Core\Entity;
use Nice\Core\Item;

class ItemController extends \Illuminate\Routing\Controller
{

    public function index(Request $request, $name)
    {

        $entity = app('nice_entity_service')->make($name);

        $items = Item::query();

        $items->where('entity', $entity->key());

        if ($request->input('parent_id')) {

            $parent = Item::findOrFail($request->input('parent_id'));

            $items->where('parent_id', $parent->id);
        } else {
            $parent = null;
        }

        $items->orderBy('created_at', 'desc');

        $items = $items->get();

        return view('nice::item.index', ['entity' => $entity, 'items' => $items, 'parent' => $parent]);

    }

    public function create(Request $request, $name)
    {
        $entity = app('nice_entity_service')->make($name);

        if ($request->input('parent_id')) {

            $parent = Item::findOrFail($request->input('parent_id'));
        } else {
            $parent = null;
        }

        return view('nice::item.create', ['entity' => $entity, 'parent' => $parent]);

    }

    public function store(Request $request, $name)
    {

        $entity = app('nice_entity_service')->make($name);

        $item = $entity->makeItem();

        $item->url = $request->input('url');

        foreach ($entity->attributes() as $attribute) {

            if ($attribute->type()->isInputFile()) {
                $data = $request->file($attribute->key());

                if (!$data) {
                    continue;
                }

            } else {
                $data = $request->input($attribute->key());

            }

            $storable = $attribute->type()->storable($data, $attribute, $item);

            $item->setValue($attribute->key(), $storable);

        }

        $item->parent_id = $request->input('parent_id');

        $item->save();

        return redirect()->to($item->editorIndexRoute());

    }

    public function show()
    {

    }

    public function edit(Request $request, $name, $id)
    {

        $item = Item::findOrFail($id);

        $parent = $item->parent;

        $entity = $item->entity();

        return view('nice::item.edit', ['entity' => $entity, 'item' => $item, 'parent' => $parent]);
    }

    public function update(Request $request, $name, $id)
    {
        $item = Item::findOrFail($id);

        $entity = $item->entity();

        foreach ($entity->attributes() as $attribute) {

            if ($request->hasFile($attribute->key())) {
                $data = $request->file($attribute->key());

            } else {
                $data = $request->input($attribute->key());

            }

            $storable = $attribute->type()->storable($data, $attribute, $item);

            $item->setValue($attribute->key(), $storable);

        }

        $item->url = $request->input('url');

        $item->save();

        return redirect()->to($item->editorIndexRoute());

    }

    public function destroy(Request $request, $name, $id)
    {
        $item = Item::findOrFail($id);

        $item->delete();

        return redirect()->to($item->editorIndexRoute());

    }

}

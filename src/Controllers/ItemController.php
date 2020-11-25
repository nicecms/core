<?php

namespace Nice\Core\Controllers;

use Illuminate\Http\Request;
use Nice\Core\Entity;
use Nice\Core\Facades\Entities;
use Nice\Core\Item;

class ItemController extends \Illuminate\Routing\Controller
{

    public function __construct(Request $request)
    {

    }

    /**
     * @param Request $request
     * @param Entity $entity
     * @param Item $items
     * @return array
     */
    public function withAttributes(Request $request, $entity, $items = null)
    {

        $requestAttributes = $request->only($entity->attributesKeys());

        if ($items) {
            $items->whereValuesOf($requestAttributes);
        }

        view()->share('requestAttributes', $requestAttributes);

        return $requestAttributes;

    }

    public function index(Request $request, $name)
    {

        $entity = Entities::make($name);

        /** @type Entity $entity */

        $items = Item::query();

        /** @type Item $items */

        $items->where('entity', $entity->key());

        if ($request->input('parent_id')) {

            $parentKey = $entity->param('parent');

            $parentEntity = Entities::make($parentKey);

            /** @type Entity $parentEntity */

            if ($parentEntity->isExternal()) {
                $parent = $parentEntity->provider($request->input('parent_id'));

            } else {
                $parent = Item::findOrFail($request->input('parent_id'));

            }

            $items->where('parent_id', $parent->id);

        } else {
            $parent = null;
        }

        #

        $requestAttributes = $this->withAttributes($request, $entity);

        if ($requestAttributes) {
            $items->whereValuesOf($requestAttributes);
        }

        #

        $items->givenOrder();

        $items = $items->get();

        return view('nice::item.index', ['entity' => $entity, 'items' => $items, 'parent' => $parent]);

    }

    public function create(Request $request, $name)
    {
        $entity = Entities::make($name);

        # передача обязательных значений

        if ($request->input('parent_id')) {

            $parent = Item::findOrFail($request->input('parent_id'));

        } else {
            $parent = null;
        }

        #

        $requestAttributes = $this->withAttributes($request, $entity);

        return view('nice::item.create', ['entity' => $entity, 'parent' => $parent]);

    }

    public function store(Request $request, $name)
    {

        $entity = Entities::make($name);

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

        #

        $requestAttributes = json_decode($request->input('request_attributes', "[]"), true);



        return redirect()->to($item->editorIndexRoute($requestAttributes));

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

    public function assignPositions(Request $request)
    {
        foreach ($request->entity_ids as $position => $id) {
            Item::where('id', $id)->update(['position' => $position]);
        }

        return ['success' => true];
    }

}

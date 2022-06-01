<?php

namespace Nice\Core\Controllers;

use Illuminate\Database\Eloquent\Collection;
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

            $parent = Item::findOrFail($request->input('parent_id'));

            $items->where('parent_id', $parent->id);
        } else {
            $parent = null;
        }

        # если не множественное - редиректим на создание или редактирование

        if (!$entity->isMultiple()) {
            $item = $items->first();

            if (!$item) {
                return redirect()->route($entity->editorCreateRoute($parent));
            } else {
                return redirect()->route($item->editorEditRoute());
            }
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

        /** @type Item $item */

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

        $item->url = $request->input('url');

        if (!$item->url) {
            $item->url = $item->makeSlug();
        }

        $item->save();

        # related

        $this->setRelated($request, $item);

        #

        return redirect()->to($item->editorEditRoute());
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

        if (!$item->url) {
            $item->url = $item->makeSlug();
        }

        $item->save();

        $this->setRelated($request, $item);

        return redirect()->to($item->editorEditRoute());
    }

    public function destroy(Request $request, $name, $id)
    {
        $item = Item::findOrFail($id);

        $item->delete();

        return redirect()->to($item->editorIndexRoute());
    }

    public function assignPositions(Request $request)
    {
        foreach ($request->items as $position => $id) {
            Item::where('id', $id)->update(['position' => $position]);
        }

        return ['success' => true];
    }

    public function setRelated(Request $request, Item $item)
    {
        if ($request->input('related')) {

            $item->clearRelated();

            foreach ($request->input('related', []) as $relatedEntityKey => $relatedIDs) {
                if (is_array($relatedIDs)) {
                    $item->setRelated($relatedEntityKey, $relatedIDs);
                } else {
                    $names = explode(',', $relatedIDs);

                    $new = [];

                    foreach ($names as $name) {
                        $name = trim($name);

                        $relatedItem = Item::whereValueOf('name', $name)->first();

                        if (!$relatedItem) {
                            $entity = Entities::make($relatedEntityKey);

                            $relatedItem = $entity->makeItem();
                            $relatedItem->setValue('name', $name);
                            $relatedItem->save();
                        }

                        $new[] = $relatedItem;
                    }

                    $item->setRelated($relatedEntityKey, (new Collection($new))->pluck('id')->all());
                }
            }
        }

    }
}

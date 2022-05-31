<div class="card mb-4">

    <div class="card-body">
        <h5 class="card-title">{{$relatedEntity->namePlural()}}</h5>

        @foreach($relatedEntity->itemsQuery()->get() as $relatedItem)

            <div class="form-group form-check">
                <label class="form-check-label">
                    {{Form::checkbox('related['.$relatedEntity->key().'][]', $relatedItem->id, $item->isRelated($relatedItem), ['class' => 'form-check-input'])}}
                    {{$relatedItem->title()}}
                </label>
            </div>

        @endforeach

    </div>

</div>
<div class="card mb-4">

    <div class="card-body">
        <h5 class="card-title">{{$relatedEntity->namePlural()}}</h5>

        {{Form::textarea(
    'related['.$relatedEntity->key().']', $item->relatedQuery($relatedEntity)->get()->map(fn ($relatedItem) =>  $relatedItem->value('name'))->join(', '),
    ['class' => 'form-control'])}}

    </div>

</div>
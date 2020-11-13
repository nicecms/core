@extends(config('nice.dashboard_layout'))

@section('breadcrumbs')



    @if($parent)
        @foreach($parent->parentsChain() as $pItem)

            <li class="breadcrumb-item">
                <a href="{{$pItem->editorIndexRoute()}}">{{$pItem->title()}}</a>
            </li>

        @endforeach

    @endif

    @if($entity->isMultiple())
        <li class="breadcrumb-item"><a href="{{$item->editorIndexRoute()}}">{{$entity->param('name_plural')}}</a>
        </li>
    @endif

    <li class="breadcrumb-item active">{{$item->value($entity->param('title'))}}</li>
@endsection


@section('content')

    {!! Form::open(['files' => true, 'route' => [ config('nice.route_name').'item.update', $entity->key(), $item->id], 'method' => 'POST' ]) !!}

    <span class="h3 d-block mb-3">{{$item->value($entity->param('title'))}}</span>

    <div class="row">

        <div class="col-8">

            <div class="card">

                <div class="card-body">

                    <div class="row">
                        <div class="col-12">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        {!! Form::label('url', 'URL') !!}
                                        {!! Form::text('url', old('url', $item->url), ['class' => 'form-control', 'placeholder' => 'URL']) !!}
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    @foreach($entity->attributes() as $attribute)

                        <div class="row">
                            <div class="col-12">

                                {!! $attribute->input(old($attribute->key(), $item->value($attribute->key()))) !!}

                            </div>
                        </div>

                    @endforeach

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-lg" name="state" value="published">Сохранить</button>
                        @if($entity->isMultiple())
{{--                            <button type="submit" class="btn btn-outline-primary btn-lg" name="state" value="draft">Сохранить как черновик</button>--}}
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="col-4">

            {{--            @if($entity->hasHelpImage())--}}

            {{--                @include('admin.entity.components.help')--}}

            {{--            @endif--}}

        </div>

    </div>


    {!! Form::close() !!}

    {{--    @include('admin.entity.scripts')--}}

@endsection


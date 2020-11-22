@extends(config('nice.dashboard_layout'))

@section('breadcrumbs')

    {{--    Если есть привязка к внешнему объекту - добавляем ссылку на него в крошки--}}
    @if($externalValue)
        <li class="breadcrumb-item">
            <a href="{{$entity->externalAttribute()->getExternalUrl($externalValue)}}">{{$entity->externalAttribute()->getValue($externalValue)}}</a>
        </li>
    @endif


    @if($parent)
        @foreach($parent->parentsChain()->reverse() as $pItem)

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

    <h3 >{{$item->value($entity->param('title'))}}</h3>


    <div class="h5 text-muted">

        @if($parent)

            {{$parent->entity()->name()}} - {{$parent->title()}}

        @endif



    </div>

    <div class="mb-3">
        Ссылка: <a href="{{$item->fullUrl()}}">{{$item->fullUrl()}}</a>
    </div>

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

                                {!! $attribute->input(old($attribute->key(), $item->rawValue($attribute))) !!}

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


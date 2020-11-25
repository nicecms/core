@extends(config('nice.dashboard_layout'))


@section('scripts')
    @include('nice::common.scripts')
@endsection

@section('breadcrumbs')


    @if($parent)
        @foreach($parent->parentsChain()->reverse() as $pItem)

            <li class="breadcrumb-item">
                <a href="{{$pItem->editorIndexRoute()}}">{{$pItem->title()}}</a>
            </li>

        @endforeach

    @endif

    @if($entity->isMultiple())
        <li class="breadcrumb-item"><a href="{{$entity->editorIndexRoute($parent)}}">{{$entity->param('name_plural')}}</a>
        </li>
    @endif

    <li class="breadcrumb-item active">Cоздание</li>
@endsection


@section('content')

    {!! Form::open(['files' => true, 'url' => $entity->editorStoreRoute(), 'method' => 'POST' ]) !!}

    {{Form::hidden('request_attributes', json_encode($requestAttributes))}}

    @if($parent)

        {{Form::hidden('parent_id', $parent->id)}}

    @endif


    <div class="h3">

        {{$entity->param('name')}}: создание

    </div>

    <div class="h5 text-muted">

        @if($parent)

            <div>{{$parent->entity()->name()}} - {{$parent->title()}}</div>
        @endif


        @foreach($requestAttributes as $key => $value)

            <div>
                {{$entity->attribute($key)->name()}}: {{$entity->attribute($key)->getValue($value)}}
            </div>

        @endforeach

    </div>


    <div class="row mt-3">

        <div class="col-8">

            <div class="card">

                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                {!! Form::label('url', 'URL') !!}
                                {!! Form::text('url', old('url', ''), ['class' => 'form-control', 'placeholder' => 'URL']) !!}
                            </div>
                        </div>
                    </div>

                    @foreach($entity->attributes() as $attribute)

                        @if(data_get($requestAttributes, $attribute->key()))
                            {{Form::hidden($attribute->key(), data_get($requestAttributes, $attribute->key()))}}
                            @continue
                        @endif

                        <div class="row">
                            <div class="col-12">

                                {!! $attribute->input(old($attribute->key())) !!}

                            </div>
                        </div>

                    @endforeach

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-lg" name="state" value="published">Опубликовать</button>
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


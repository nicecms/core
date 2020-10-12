@extends(config('nice.dashboard_layout'))

@section('breadcrumbs')


    {{--    @if($entity->isMultiple())--}}
    {{--        <li class="breadcrumb-item"><a href="{{route('admin.entity.index', [$entity->name()])}}">{{$entity->getNamePlural()}}</a>--}}
    {{--        </li>--}}
    {{--    @endif--}}

    <li class="breadcrumb-item active">{{$entity->param('name')}}</li>
@endsection


@section('content')

    {!! Form::open(['files' => true, 'route' => [ config('nice.route_name').'.item.store'], 'method' => 'POST' ]) !!}

    <input type="hidden" name="entity" value="{{$entity->key()}}">

    <span class="h3 d-block mb-3">{{$entity->param('name')}}: создание</span>


    <div class="row">

        <div class="col-8">

            <div class="card">

                <div class="card-body">
                    @foreach($entity->attributes() as $attribute)

                        <div class="row">
                            <div class="col-12">

                                {!! $attribute->input(old($attribute->key())) !!}

                            </div>
                        </div>

                    @endforeach

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-lg" name="state" value="published">Опубликовать</button>
                        @if($entity->isMultiple())
                            <button type="submit" class="btn btn-outline-primary btn-lg" name="state" value="draft">Сохранить как черновик</button>
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


@extends(config('nice.dashboard_layout'))

@section('breadcrumbs')


    {{-- Ссылки по цепочке родителей --}}

    @if($parent)
        @foreach($parent->parentsChain()->reverse() as $pItem)

            <li class="breadcrumb-item">
                <a href="{{$pItem->editorIndexRoute()}}">{{$pItem->title()}}</a>
            </li>

        @endforeach
    @endif

    <li class="breadcrumb-item">
        <a href="{{$entity->editorIndexRoute($parent, $requestAttributes)}}">{{$entity->param('name_plural')}}</a>
    </li>

    <li class="breadcrumb-item active">Список</li>


@endsection

@section('content')


    {{--верх--}}

    <div class="h3">

        {{$entity->param('name_plural')}}

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



    <div class=" mb-3 mt-3">
        <a href="{{$entity->editorCreateRoute($parent, $requestAttributes)}}" class="btn btn-success">Добавить</a>
    </div>

    {{--/верх--}}

    @include('nice::item.list.'.$entity->param('editor.list_view', 'table'))

@endsection


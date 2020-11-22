@extends(config('nice.dashboard_layout'))

@section('breadcrumbs')


    {{--    Если есть привязка к внешнему объекту - добавляем ссылку на него в крошки--}}
    @if($externalValue)
        <li class="breadcrumb-item">
            <a href="{{$entity->externalAttribute()->getExternalUrl($externalValue)}}">{{$entity->externalAttribute()->getValue($externalValue)}}</a>
        </li>
    @endif

    {{-- Ссылки по цепочке родителей --}}

    @if($parent)
        @foreach($parent->parentsChain()->reverse() as $pItem)

            <li class="breadcrumb-item">
                <a href="{{$pItem->editorIndexRoute()}}">{{$pItem->title()}}</a>
            </li>

        @endforeach
    @endif

    <li class="breadcrumb-item">
        <a href="{{$entity->editorIndexRoute($parent)}}">{{$entity->param('name_plural')}}</a>
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

            {{$parent->entity()->name()}} - {{$parent->title()}}

        @endif


        @if($externalValue)
            <div>{{$entity->externalAttribute()->name()}}: {{$entity->externalAttribute()->getValue($externalValue)}}</div>
        @endif

    </div>



    <div class=" mb-3 mt-3">
        <a href="{{$entity->editorCreateRoute($parent, ($externalValue ? [$entity->externalKey() => $externalValue] : []))}}" class="btn btn-success">Добавить</a>
    </div>

    {{--/верх--}}

    @include('nice::item.list.table')

@endsection


@extends(config('nice.dashboard_layout'))

@section('breadcrumbs')


    {{--    @if($entity->isMultiple())--}}
    {{--        <li class="breadcrumb-item"><a href="{{route('admin.entity.index', [$entity->name()])}}">{{$entity->getNamePlural()}}</a>--}}
    {{--        </li>--}}
    {{--    @endif--}}

    <li class="breadcrumb-item active">{{$entity->param('name')}}</li>
@endsection


@section('content')


    {{--верх--}}

    <div class="h4 mb-3">{{$entity->param('name_plural')}}</div>

    <div class=" mb-3">
        <a href="{{route(config('nice.route_name').'item.create', $entity->key())}}" class="btn btn-success">Добавить</a>
    </div>

    {{--/верх--}}


    @include('nice::item.list.table')

@endsection


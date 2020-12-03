<div class="row items">

    @foreach($items as $item)


        <div class="{{$entity->param('editor.grid_block_class', 'col-2')}} mb-3">
            <div class="card w-100">

                <div class="card-body">

                    @foreach($entity->param('editor.list_attributes', []) as  $attribute)
                        <p class="{{$entity->isTitle($attribute) ? 'h5' : ''}}">
                            {{$item->showValue($attribute)}}
                        </p>

                    @endforeach


                    @if($entity->children())

                        @foreach($entity->children() as $childEntity)

                            <p>
                                <a href="{{$childEntity->editorIndexRoute($item)}}">{{$childEntity->param('name_plural')}} ({{$item->children($childEntity)->count()}})</a>
                            </p>

                        @endforeach

                    @endif

                    <p>
                        {{$item->state === 'draft' ? 'черновик' : 'опубликовано'}}
                    </p>

                    @if($entity->param('editor.with_url'))
                        <p>

                            <a href="{{$item->fullUrl()}}" target="_blank">открыть</a>

                        </p>
                    @endif

                </div>

                <div class="card-footer d-flex">

                    <a href="{{$item->editorEditRoute()}}" class="btn btn-sm btn-primary mr-2">редактировать</a>
                    <a href="{{$item->editorDestroyRoute()}}" class="btn btn-sm btn-danger">удалить</a>

                    @if($entity->isSortable())

                        <svg class="ml-auto lever bi bi-three-dots-vertical" width="24" height="24" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm0-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm0-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" clip-rule="evenodd"/>
                        </svg>
                    @endif

                </div>
            </div>

        </div>

    @endforeach

</div>




@if($entity->isSortable())


    <style>

        .items {
            min-width: 100%;

        }


        .placeholder {

            border: 1px dotted #ccc;

        }

        .highlight {
            box-shadow: 0px 2px 20px -5px rgba(0, 0, 0, 0.5);
        }
    </style>



    <script type="text/javascript">
        $(function () {

            $('.items').sortable(
                {
                    handle: '.lever',
                    placeholder: 'placeholder',
                    revert: 200,
                    forcePlaceholderSize: true,
                    classes: {
                        'ui-sortable-helper': 'highlight'
                    },
                    update: function (event, ui) {

                        var ids = []

                        $('[data-item-id]').each(function (index) {

                            ids.push($(this).data('item-id'))

                        })

                        $.post('{{route(config('nice.route_name').'item.assign_positions')}}', {entity_ids: ids}, function (data) {

                            //

                        }, 'json')


                    }

                }
            )

        })
    </script>

@endif

@if($entity->isSortable())
    <div class="row">
        <div class="col text-muted mb-3">меняйте порядок элементов, перетаскивая карточки за нижнюю серую часть</div>
    </div>
@endif
<div class="row items">

    @foreach($items as $item)


        <div data-item-id="{{$item->id}}" class="{{$entity->param('editor.grid_block_class', 'col-2')}} mb-3">
            <div class="card w-100 {{$entity->isSortable() ? 'sortable' : ''}}">

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
            border: 1px dotted rgba(0,0,0,.125);
            border-radius: .25rem;
        }

        .highlight .card {
            box-shadow: 0px 2px 20px -5px rgba(0, 0, 0, 0.5);
        }

        .items > div > .card{
            height: 100%;
        }
    </style>



    <script type="text/javascript">
        $(function () {


            var itemHeight = 0


            $('.items').each(function(){

                var cHeight = $(this).height();

                if(cHeight > itemHeight){
                    itemHeight = cHeight
                }

            })

            $('.items > div').css('height', itemHeight)

            $('.items').sortable(
                {
                    handle: '.sortable',
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

                        $.post('{{route(config('nice.route_name').'item.assign_positions')}}', {items: ids}, function (data) {

                            //

                        }, 'json')


                    }

                }
            )

        })
    </script>

@endif

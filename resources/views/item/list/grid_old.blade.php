<div class="row entities    ">
    @foreach($entities as $entity)
        
        <div class="col-3 mb-3" data-entity-id="{{$entity->id}}">
            
            <div class="card w-100">
                
                <div class="card-body" style="  " >
                    @foreach($entityType->getListFields() as $key)
                        
                        
                        @if($key === $entityType->getHeadingFieldKey())
                            <div class="card-heading font-weight-bold">{{$entity->data($key)}}</div>
                        @else

                            @if($entityType->getField($key)->getType() === 'image')
                                <p>
                                    <img class="img-fluid" src="{{$entity->getImageUrl('image')}}" alt="Изображение">
                                </p>
                            @else
                                <p>
                                    {!! $entity->data($key) !!}
                                </p>

                            @endif


                        @endif
                    
                    @endforeach
                </div>
                
                <div class="card-footer d-flex justify-content-between">
                    <div>
                        <a href="{{route('admin.entity.edit', [$entity->type, $entity->id])}}" class="btn btn-sm btn-primary">редактировать</a>
                        <a href="{{route('admin.entity.destroy', [$entity->id])}}" class="btn btn-sm btn-danger">удалить</a>
                    </div>
                    
                    @if($entityType->isSortable())
                        <div class="lever">
                            <svg class="bi bi-arrows-move" width="24" height="24" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6.5 8a.5.5 0 00-.5-.5H1.5a.5.5 0 000 1H6a.5.5 0 00.5-.5z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M3.854 5.646a.5.5 0 00-.708 0l-2 2a.5.5 0 000 .708l2 2a.5.5 0 00.708-.708L2.207 8l1.647-1.646a.5.5 0 000-.708zM9.5 8a.5.5 0 01.5-.5h4.5a.5.5 0 010 1H10a.5.5 0 01-.5-.5z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M12.146 5.646a.5.5 0 01.708 0l2 2a.5.5 0 010 .708l-2 2a.5.5 0 01-.708-.708L13.793 8l-1.647-1.646a.5.5 0 010-.708zM8 9.5a.5.5 0 00-.5.5v4.5a.5.5 0 001 0V10a.5.5 0 00-.5-.5z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M5.646 12.146a.5.5 0 000 .708l2 2a.5.5 0 00.708 0l2-2a.5.5 0 00-.708-.708L8 13.793l-1.646-1.647a.5.5 0 00-.708 0zM8 6.5a.5.5 0 01-.5-.5V1.5a.5.5 0 011 0V6a.5.5 0 01-.5.5z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M5.646 3.854a.5.5 0 010-.708l2-2a.5.5 0 01.708 0l2 2a.5.5 0 01-.708.708L8 2.207 6.354 3.854a.5.5 0 01-.708 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    
                    @endif
                    
                  
                
                </div>
            </div>
        
        </div>
    
    
    
    @endforeach

</div>

{{--<table class="table {{$entityType->isSortable() ?: 'table-striped' }} table-bordered entities">--}}
{{--    --}}
{{--    <thead>--}}
{{--    --}}
{{--    <tr class="head">--}}
{{--        --}}
{{--        @if($entityType->isSortable())--}}
{{--            --}}
{{--            <th>--}}
{{--                <svg class="bi bi-arrow-up-down" width="24" height="24" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <path fill-rule="evenodd" d="M11 3.5a.5.5 0 01.5.5v9a.5.5 0 01-1 0V4a.5.5 0 01.5-.5z" clip-rule="evenodd" />--}}
{{--                    <path fill-rule="evenodd" d="M10.646 2.646a.5.5 0 01.708 0l3 3a.5.5 0 01-.708.708L11 3.707 8.354 6.354a.5.5 0 11-.708-.708l3-3zm-9 7a.5.5 0 01.708 0L5 12.293l2.646-2.647a.5.5 0 11.708.708l-3 3a.5.5 0 01-.708 0l-3-3a.5.5 0 010-.708z" clip-rule="evenodd" />--}}
{{--                    <path fill-rule="evenodd" d="M5 2.5a.5.5 0 01.5.5v9a.5.5 0 01-1 0V3a.5.5 0 01.5-.5z" clip-rule="evenodd" />--}}
{{--                </svg>--}}
{{--            </th>--}}
{{--        @endif--}}
{{--        --}}
{{--        @foreach($entityType->getListFields() as $key)--}}
{{--            <th>--}}
{{--                {{$entityType->getField($key)->getName()}}--}}
{{--            </th>--}}
{{--        --}}
{{--        @endforeach--}}
{{--        --}}
{{--        <th>Состояние</th>--}}
{{--        --}}
{{--        <th>--}}
{{--            Действия--}}
{{--        </th>--}}
{{--    --}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--    --}}
{{--    <tbody>--}}
{{--    --}}
{{--    @foreach($entities as $entity)--}}
{{--        --}}
{{--        <tr style="{{$entity->state === 'draft' ? 'font-style: italic' : ''}}" data-entity-id="{{$entity->id}}">--}}
{{--            --}}
{{--            @if($entityType->isSortable())--}}
{{--                --}}
{{--                <td class="lever">--}}
{{--                    <svg class="bi bi-three-dots-vertical" width="24" height="24" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">--}}
{{--                        <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm0-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm0-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" clip-rule="evenodd" />--}}
{{--                    </svg>--}}
{{--                </td>--}}
{{--            @endif--}}
{{--            --}}
{{--            --}}
{{--            @foreach($entityType->getListFields() as $key)--}}
{{--                <td>--}}
{{--                    {{$entity->data($key)}}--}}
{{--                </td>--}}
{{--            @endforeach--}}
{{--            --}}
{{--            <td>--}}
{{--                {{$entity->state === 'draft' ? 'черновик' : 'опубликовано'}}--}}
{{--            </td>--}}
{{--            --}}
{{--            <td style="font-style: normal; min-width: 212px">--}}
{{--                <a href="{{route('admin.entity.edit', [$entity->type, $entity->id])}}" class="btn btn-sm btn-primary">редактировать</a>--}}
{{--                <a href="{{route('admin.entity.destroy', [$entity->type, $entity->id])}}" class="btn btn-sm btn-danger">удалить</a>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    --}}
{{--    @endforeach--}}
{{--    --}}
{{--    </tbody>--}}

{{--</table>--}}


@if($entityType->isSortable())
    
    
    <style>
        
        .placeholder {
            
            border: 1px dotted #ccc;
            
        }
        
        .highlight {
            /*box-shadow: 0px 2px 20px -5px rgba(0, 0, 0, 0.5);*/
        }
    </style>
    
    
    
    <script type="text/javascript">
      $(function () {

        $('.entities').sortable(
          {
            handle: '.card',
            placeholder: 'col-3 placeholder',
            revert: 200,
            classes: {
              'ui-sortable-helper': 'highlight'
            },
            update: function (event, ui) {

              var ids = []

              $('[data-entity-id]').each(function (index) {

                ids.push($(this).data('entity-id'))

              })

              $.post('{{route('admin.entity.set_positions')}}', {entity_ids: ids}, function (data) {

                //

              }, 'json')

            }

          }
        )

      })
    </script>

@endif

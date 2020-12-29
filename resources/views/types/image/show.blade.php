@if($value)
    <img src="{{$value}}" alt="" class="img-fluid" style="max-width: {{$attibute->param('editor_show_max_width', '100%')}}">
@else
    <p class="text-muted">Изображение не загружено</p>
@endif
